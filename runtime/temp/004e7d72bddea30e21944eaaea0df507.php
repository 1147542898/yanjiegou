<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:81:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\auth\adminEdit.html";i:1569466684;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
<!doctype html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>沿街购【商家】管理端</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="/static/admin/css/font.css">
    <link rel="stylesheet" href="/static/admin/css/xadmin.css">
    <link rel="stylesheet" href="/static/admin/css/theme224.min.css">
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
            layer.confirm('确认要清除缓存？', {icon: 3}, function () {
                $.post('<?php echo url("clear"); ?>',function (data) {
                    layer.msg(data.info, {icon: 6}, function (index) {
                        layer.close(index);
                        location.reload();
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
    <form class="layui-form layui-form-pane" lay-filter="form" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">所属用户组</label>
            <div class="layui-input-inline">
                <select name="group_id" lay-verify="required">
                    <option value="">请选择用户组</option>
                    <?php if(is_array($authGroup) || $authGroup instanceof \think\Collection || $authGroup instanceof \think\Paginator): $i = 0; $__LIST__ = $authGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo['group_id']; ?>"><?php echo $vo['title']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('username'); ?></label>
            <div class="layui-input-inline">
                <input type="text" name="username" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>登录用户名" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                用户名在4到25个字符之间。
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('pwd'); ?></label>
            <div class="layui-input-inline">
                <input type="password" name="pwd" placeholder="<?php echo lang('pleaseEnter'); ?>登录密码" <?php if(ACTION_NAME == 'adminadd'): ?>lay-verify="required"<?php endif; ?> class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                密码必须大于6位，小于15位。
            </div>
        </div>
       <!--  <div class="layui-form-item">
            <label class="layui-form-label">头像</label>
            <input type="hidden" name="avatar" id="avatar">
            <div class="layui-input-inline">
                <div class="layui-upload">
                    <button type="button" class="layui-btn layui-btn-primary" id="adBtn"><i class="icon icon-upload3"></i>点击上传</button>
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="adPic">
                        <p id="demoText"></p>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('email'); ?></label>
            <div class="layui-input-inline">
                <input type="text" name="email" lay-verify="email" placeholder="<?php echo lang('pleaseEnter'); ?>用户邮箱" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                用于密码找回，请认真填写。
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('tel'); ?></label>
            <div class="layui-input-inline">
                <input type="text" name="tel" lay-verify="phone" value="" placeholder="<?php echo lang('pleaseEnter'); ?>手机号" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">真名</label>
            <div class="layui-input-inline">
                <input type="text" name="realname" lay-verify="required" value="" placeholder="<?php echo lang('pleaseEnter'); ?>真名" class="layui-input">
            </div>
        </div>
        <!--提交-->
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" name="admin_id">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>
                <a href="<?php echo url('adminList'); ?>" class="layui-btn layui-btn-primary"><?php echo lang('back'); ?></a>
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
        var form = layui.form, layer = layui.layer,$= layui.jquery,upload = layui.upload;
        var info = <?php echo $info; ?>;
        form.val("form", info);
        if(info){
            $('#adPic').attr('src',info.avatar);
        }
        form.render();
        form.on('submit(submit)', function (data) {
            loading =layer.load(1, {shade: [0.1,'#fff']});
            $.post("<?php echo url('adminEdit'); ?>", data.field, function (res) {
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
                    $('#avatar').val(res.url);
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

