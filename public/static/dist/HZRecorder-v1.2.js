export class Recorder {
    config = {
        bufferLen: 4096,
        numChannels: 1, // 默认单声道
        mimeType: 'audio/wav',
        onaudioprocess:null
    };

    recording = false;

    callbacks = {
        getBuffer: [],
        encode:[],
        exportWAV: []
    };




    static createRecorder(callback,config){
        window.AudioContext = window.AudioContext || window.webkitAudioContext;
        window.URL = window.URL || window.webkitURL;
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
        
        if (navigator.getUserMedia) {
            navigator.getUserMedia(
                { audio: true } //只启用音频
                , function (stream) {
                    var audio_context = new AudioContext;
                    var input = audio_context.createMediaStreamSource(stream);
                    var rec = new Recorder(input, config);
                    callback(rec);
                }
                , function (error) {
                    switch (error.code || error.name) {
                        case 'PERMISSION_DENIED':
                        case 'PermissionDeniedError':
                            throwError('用户拒绝提供信息。');
                            break;
                        case 'NOT_SUPPORTED_ERROR':
                        case 'NotSupportedError':
                            throwError('浏览器不支持硬件设备。');
                            break;
                        case 'MANDATORY_UNSATISFIED_ERROR':
                        case 'MandatoryUnsatisfiedError':
                            throwError('无法发现指定的硬件设备。');
                            break;
                        default:
                            throwError('无法打开麦克风。异常信息:' + (error.code || error.name));
                            break;
                    }
                });
        } else {
            throwError('当前浏览器不支持录音功能。'); return;
        }
    }

    


        this.node.onaudioprocess = (e) => {
            if (!this.recording) return;
            var buffer = [];

            for (var channel = 0; channel < this.config.numChannels; channel++) {
                buffer.push(e.inputBuffer.getChannelData(channel));
            }

            // 发送给worker
            this.worker.postMessage({
                command: 'record',
                buffer: buffer
            });

            // 数据回调
            if(this.config.onaudioprocess){
                this.config.onaudioprocess(buffer[0]);
            }
        };

    encode(cb,buffer,sampleRate) {
        cb = cb || this.config.callback;
        if (!cb) throw new Error('Callback not set');
        this.callbacks.encode.push(cb);
        this.worker.postMessage({ command: 'encode',buffer:buffer,sampleRate:sampleRate});
    }







    
}
/**
             * 转换采样率
             * @param data
             * @param newSampleRate 目标采样率
             * @param oldSampleRate 原始数据采样率
             * @returns {any[]|Array}
             */
            function interpolateArray(data, newSampleRate, oldSampleRate) {
                var fitCount = Math.round(data.length * (newSampleRate / oldSampleRate));
                var newData = new Array();
                var springFactor = new Number((data.length - 1) / (fitCount - 1));
                newData[0] = data[0]; // for new allocation
                for (var i = 1; i < fitCount - 1; i++) {
                    var tmp = i * springFactor;
                    var before = new Number(Math.floor(tmp)).toFixed();
                    var after = new Number(Math.ceil(tmp)).toFixed();
                    var atPoint = tmp - before;
                    newData[i] = this.linearInterpolate(data[before], data[after], atPoint);
                }
                newData[fitCount - 1] = data[data.length - 1]; // for new allocation
                return newData;
            }

            function linearInterpolate(before, after, atPoint) {
                return before + (after - before) * atPoint;
            }
            /**
             * 导出wav
             * @param type
             * @param desiredSamplingRate 期望的采样率
             */
            function exportWAV(type,desiredSamplingRate) {
                // 默认为16k
                desiredSamplingRate = desiredSamplingRate || 16000;
                var buffers = [];
                for (var channel = 0; channel < numChannels; channel++) {
                    var buffer = mergeBuffers(recBuffers[channel], recLength);
                    // 需要转换采样率
                    if (desiredSamplingRate!=sampleRate) {
                        // 插值去点
                        buffer = interpolateArray(buffer, desiredSamplingRate, sampleRate);
                    }
                    buffers.push(buffer);
                }
                var interleaved = numChannels === 2 ? interleave(buffers[0], buffers[1]) : buffers[0];
                var dataview = encodeWAV(interleaved,desiredSamplingRate);
                var audioBlob = new Blob([dataview], { type: type });
                self.postMessage({ command: 'exportWAV', data: audioBlob });
            }

export default Recorder;