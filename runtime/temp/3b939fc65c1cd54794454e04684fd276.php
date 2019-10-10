<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:81:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\system\system.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1570615895;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
        <legend><?php echo lang('systemSet'); ?></legend>
    </fieldset>
    <div class="layui-tab">
        <ul class="layui-tab-title">
            <li class="layui-this">基础设置</li>
            <li>SEO管理</li>
            <li>其他</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form layui-form-pane" lay-filter="form-system">
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?php echo lang('websiteName'); ?></label>
                        <div class="layui-input-4">
                            <input type="text" name="name" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('websiteName'); ?>" class="layui-input-line">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?php echo lang('WebsiteUrl'); ?></label>
                        <div class="layui-input-4">
                            <input type="text" name="url" lay-verify="url" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('WebsiteUrl'); ?>" class="layui-input-line">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">网站LOGO</label>
                        <input type="hidden" name="logo" id="logo">
                        <div class="layui-input-block">
                            <div class="layui-upload">
                                <button type="button" class="layui-btn layui-btn-primary" id="logoBtn"><i class="icon icon-upload3"></i>点击上传</button>
                                <div class="layui-upload-list">
                                    <img class="layui-upload-img" id="Logo">
                                    <p id="demoText"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?php echo lang('recordNum'); ?></label>
                        <div class="layui-input-3">
                            <input type="text" name="bah" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('recordNum'); ?>" class="layui-input-line">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">Copyright</label>
                        <div class="layui-input-3">
                            <input type="text" name="copyright" placeholder="<?php echo lang('pleaseEnter'); ?>Copyright" class="layui-input-line">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?php echo lang('companyAddress'); ?></label>
                        <div class="layui-input-3">
                            <input type="text" name="ads" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('companyAddress'); ?>" class="layui-input-line">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?php echo lang('tel'); ?></label>
                        <div class="layui-input-3">
                            <input type="text" name="tel" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('tel'); ?>" class="layui-input-line">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?php echo lang('email'); ?></label>
                        <div class="layui-input-3">
                            <input type="text" name="email" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('email'); ?>" class="layui-input-line">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button type="button" class="layui-btn" lay-submit="" lay-filter="sys"><?php echo lang('submit'); ?></button>
                            <button type="reset" class="layui-btn layui-btn-primary"><?php echo lang('reset'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="layui-tab-item">
                <form class="layui-form layui-form-pane" lay-filter="form-system">
                    <div class="layui-form-item">
                        <label class="layui-form-label"><?php echo lang('seoTitle'); ?></label>
                        <div class="layui-input-4">
                            <input type="text"name="title" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('WebsiteUrl'); ?>" class="layui-input-line">
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label"><?php echo lang('seoKeyword'); ?></label>
                        <div class="layui-input-block">
                            <textarea name="key" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('seoKeyword'); ?>" class="layui-textarea"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label"><?php echo lang('description'); ?></label>
                        <div class="layui-input-block">
                            <textarea name="des" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('description'); ?>" class="layui-textarea"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button type="button" class="layui-btn" lay-submit="" lay-filter="sys"><?php echo lang('submit'); ?></button>
                            <button type="reset" class="layui-btn layui-btn-primary"><?php echo lang('reset'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="layui-tab-item">
                <form class="layui-form layui-form-pane" lay-filter="form-system">
                    <div class="layui-form-item">
                        <label class="layui-form-label">手机端</label>
                        <div class="layui-input-block">
                            <input type="radio" name="mobile" value="open" title="开启">
                            <input type="radio" name="mobile" value="close" title="关闭">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">验证码</label>
                        <div class="layui-input-block">
                            <input type="radio" name="code" value="open" title="开启">
                            <input type="radio" name="code" value="close" title="关闭">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button type="button" class="layui-btn" lay-submit="" lay-filter="sys"><?php echo lang('submit'); ?></button>
                            <button type="reset" class="layui-btn layui-btn-primary"><?php echo lang('reset'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>



    <!--js结束-->
    
<script>
    layui.use(['form', 'layer','upload','element'], function () {
        var form = layui.form,layer = layui.layer,upload = layui.upload,$ = layui.jquery,element = layui.element;
        var seytem = <?php echo $system; ?>;
        form.val("form-system", seytem);
        $('#Logo').attr('src',seytem.logo);
        //普通图片上传
        var uploadInst = upload.render({
            elem: '#logoBtn'
            ,url: '<?php echo url("UpFiles/upload"); ?>'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#Logo').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                //上传成功
                if(res.code>0){
                    $('#logo').val(res.url);
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
        //提交监听
        form.on('submit(sys)', function (data) {
            loading =layer.load(1, {shade: [0.1,'#fff']});
            $.post("<?php echo url('system/system'); ?>",data.field,function(res){
                layer.close(loading);
                if(res.code > 0){
                    layer.msg(res.msg,{icon: 1, time: 1000},function(){
                        location.href = res.url;
                    });
                }else{
                    layer.msg(res.msg,{icon: 2, time: 1000});
                }
            });
        })
    })
</script>



</body>

</html>