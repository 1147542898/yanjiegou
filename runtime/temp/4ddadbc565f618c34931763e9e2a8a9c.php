<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:81:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\fsale\baseset.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
<!doctype html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>沿街购管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="/static/admin/css/font.css">
    <link rel="stylesheet" href="/static/admin/css/xadmin.css">
    <link rel="stylesheet" href="/static/admin/css/theme10.min.css">
    <link rel="stylesheet" href="/static/admin/lib/font-awesome-4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="/static/admin/js/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript" src="/static/admin/js/xadmin.js"></script>
<!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
<!--[if lt IE 9]>
<script src="/static/admin/js/html5.min.js"></script>
<script src="/static/admin/js/respond.min.js"></script>
<![endif]-->
<script>
var identity = 'ruler';
var attachmark = '<?php echo $attachmark; ?>';
var uploadApi = "<?php echo url('upload/index/uploadimage'); ?>";
layui.use('layer',function(){
    var $ = layui.jquery, layer = layui.layer;
    $('#cache').click(function () {
        document.cookie="skin=;expires="+new Date().toGMTString();
        layer.confirm('确认要清除缓存？', {icon: 3}, function () {
            $.post('<?php echo url("clear"); ?>',function (data) {
                layer.msg(data.info, {icon: 6}, function (index) {
                    layer.close(index);
                    window.location.href = data.url;
                });
            });
        });
    });
        //刷新当前
    $(".refresh").on("click",function(){
        if($(this).hasClass("refreshThis")){
            $(this).removeClass("refreshThis");
            $(".layui-tab-item.layui-show").find("iframe")[0].contentWindow.location.reload(true);
            setTimeout(function(){
                $(".refresh").addClass("refreshThis");
            },000)
        }else{
            layer.msg("您点击的速度超过了服务器的响应速度，还是等两秒再刷新吧！");
        }
    })
    $(".smenu:first").show();
    $(".open_meun").on("click",function(){
        $('.smenu').hide();
        $('.son_menu'+$(this).data('id')).show();
    })
})

</script>
    

    

</head>
<body>

<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-body">
    <fieldset class="layui-elem-field layui-field-title">
        <legend><?php echo $title; ?></legend>
    </fieldset>
    <form class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label class="layui-form-label label25">分销层级<b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="radio" name="level" value="0" title="不开启" <?php if(($info['level'] == 0)): ?>checked="checked"<?php endif; ?>>
                <input type="radio" name="level" value="1" title="一级分销" <?php if(($info['level'] == 1)): ?>checked="checked"<?php endif; ?>>
                <input type="radio" name="level" value="2" title="二级分销" <?php if(($info['level'] == 2)): ?>checked="checked"<?php endif; ?>>
                <input type="radio" name="level" value="3" title="三级分销" <?php if(($info['level'] == 3)): ?>checked="checked"<?php endif; ?>>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">分销内购<b class="red">*</b></label>
            <div class="layui-input-block beizhu">
                <input type="radio" name="is_rebate" value="0" title="开启" <?php if(($info['is_rebate'] == 0)): ?>checked="checked"<?php endif; ?>>
                <input type="radio" name="is_rebate" value="1" title="关闭" <?php if(($info['is_rebate'] == 1)): ?>checked="checked"<?php endif; ?>>
                <br/><span class="red">开启分销内购，分销商自己购买商品，享受一级佣金，上级享受二级佣金，上上级享受三级佣金</span>
            </div>
            
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">成为下线条件<b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="radio" name="condition" value="0" title="无条件（需要审核）" <?php if(($info['condition'] == 0)): ?>checked="checked"<?php endif; ?>>
                <input type="radio" name="condition" value="1" title="申请（需要审核）" <?php if(($info['condition'] == 1)): ?>checked="checked"<?php endif; ?>>
                <input type="radio" name="condition" value="2" title="无需审核" <?php if(($info['condition'] == 2)): ?>checked="checked"<?php endif; ?>>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">成为分销商条件<b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="radio" name="share_condition" value="0" title="首次点击链接" <?php if(($info['share_condition'] == 0 )): ?>checked="checked"<?php endif; ?>>
                <input type="radio" name="share_condition" value="1" title="首次下单" <?php if(($info['share_condition'] == 1)): ?>checked="checked"<?php endif; ?>>
                <input type="radio" name="share_condition" value="2" title="首次付款" <?php if(($info['share_condition'] == 2)): ?>checked="checked"<?php endif; ?>>
            </div>
        </div>
        <!-- <div class="layui-form-item">
            <label class="layui-form-label label25">提现方式<b class="red">*</b></label>
            <div class="layui-input-block ">
                <input type="checkbox" name="wechat" value="1" title="微信支付" checked="checked">
                <input type="checkbox" name="alipay" value="1" title="支付宝支付" checked="checked">
                <input type="checkbox" name="bank" value="1" title="银行卡支付" checked="checked">
                <input type="checkbox" name="remaining_sum" value="1" title="余额支付" checked="checked">
                <br/><span class="red beizhu">微信自动支付，需要申请微信支付的企业付款到零钱功能</span>
            </div>
            
        </div> -->
        <!-- <div class="layui-form-item">
            <label class="layui-form-label label25">最少提现额度<b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="text" name="min_money"  lay-verify="required" value="1" class="layui-input"> <span class="red">元</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">每日提现上限<b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="text" name="cash_max_day"  lay-verify="required" value="1000" class="layui-input"> <span class="red">元</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">提现手续费<b class="red">*</b></label>
            <div class="layui-input-block ">
                <input type="text" name="cash_service_charge"  lay-verify="required" value="0" class="layui-input"> <span class="red">%</span>
                <br/><span class="red beizhu">0表示不设置提现手续费,提现手续费额外从提现中扣除,例如：10%的提现手续费：
                提现100元，扣除手续费10元， 实际到手90元</span>
            </div>
        </div> -->
        <div class="layui-form-item">
            <label class="layui-form-label label25">消费自动成为分销商<b class="red">*</b></label>
            <div class="layui-input-block ">
                <input type="text" name="auto_share_val"  lay-verify="required" value="<?php if(($info['auto_share_val'])): ?><?php echo $info['auto_share_val']; else: ?>10000<?php endif; ?>" class="layui-input"> <span class="red">元</span>
                <br/><span class="red beizhu">消费满指定金额(付款即生效,无需过售后)自动成为分销商，0元表示不自动</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">购买商品自动成为分销商<b class="red">*</b></label>
            <div class="layui-input-block ">
                <input type="radio" name="share_good_status" value="0" title="关闭" <?php if(($info['share_good_status'] == 0)): ?>checked="checked"<?php endif; ?>>
                <input type="radio" name="share_good_status" value="1" title="任意商品" <?php if(($info['share_good_status'] == 1)): ?>checked="checked"<?php endif; ?>>
                <input type="radio" name="share_good_status" value="2" title="制定商品" <?php if(($info['share_good_status'] == 2)): ?>checked="checked"<?php endif; ?>><br/>
                <span class="red">购买商品付款即生效，无需过售后</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">用户须知</label>
            <div class="layui-input-block">
                <textarea placeholder="请输用户须知" name="content" class="layui-textarea"><?php echo $info['content']; ?></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">申请协议</label>
            <div class="layui-input-block">
                <textarea placeholder="请输申请协议" name="agree" class="layui-textarea"><?php echo $info['agree']; ?></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block" >
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>
                <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary"><?php echo lang('back'); ?></a>
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script>
    
        layui.use(['form', 'layer','upload'], function () {
            var form = layui.form, $ = layui.jquery, upload = layui.upload;
           
            form.on('submit(submit)', function (data) {
                // 提交到方法 默认为本身
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("", data.field, function (res) {
                    layer.close(loading);
                    if (res.code > 0) {
                        layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                            location.href = res.url;
                        });
                    } else {
                        layer.msg(res.msg, {time: 1800, icon: 2});
                    }
                });
            });
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#adBtn'
                ,url: '<?php echo url("UpFiles/upload"); ?>'
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#adPic').attr('src', result); //图片链接（base64）
                    });
                },
                done: function(res){
                    if(res.code>0){
                        $('#pic').val(res.url);
                    }else{
                        //如果上传失败
                        return layer.msg('上传失败');
                    }
                }
                ,error: function(){
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });
                }
            });
        });
</script>



</body>

</html>

