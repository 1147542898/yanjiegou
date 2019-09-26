<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"/www/wwwroot/svn.yanjiegou.com/public/../application/admin/view/users/edit.html";i:1561105812;s:72:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/common.html";i:1561105812;s:68:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/js.html";i:1562165964;}*/ ?>
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
            <label class="layui-form-label">所属用户组</label>
            <div class="layui-input-inline">
                <select name="level" lay-verify="required" ">
                    <option value="">请选择会员组</option>
                    <?php if(is_array($user_level) || $user_level instanceof \think\Collection || $user_level instanceof \think\Paginator): $i = 0; $__LIST__ = $user_level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo['level_id']; ?>" <?php if(($info['level'] == $vo['level_id'])): ?>selected<?php endif; ?>><?php echo $vo['level_name']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('nickname'); ?></label>
            <div class="layui-input-inline">
                <input type="text" name="username"  lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('nickname'); ?>" class="layui-input" value="<?php echo $info['username']; ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('email'); ?></label>
            <div class="layui-input-inline">
                <input type="text" name="email"  lay-verify="eamil" placeholder="输入<?php echo lang('email'); ?>" class="layui-input" value="<?php echo $info['email']; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux">
                必填：用于找回密码
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('tel'); ?></label>
            <div class="layui-input-inline">
                <input type="text" name="mobile"  lay-verify="mobile" placeholder="输入<?php echo lang('tel'); ?>" class="layui-input" value="<?php echo $info['mobile']; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux">
                只能填写数字
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('pwd'); ?></label>
            <div class="layui-input-inline">
                <input type="password" name="password" placeholder="输入<?php echo lang('pwd'); ?>" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                密码必须大于6位，小于15位,不修改请不要填写
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label"><?php echo lang('sex'); ?></label>
                <div class="layui-input-inline">
                    <input type="radio" name="sex" value="1" <?php if(($info['sex'] == 1)): ?>checked<?php endif; ?> title="<?php echo lang('man'); ?>">
                    <input type="radio" name="sex" value="0" <?php if(($info['sex'] == 0)): ?>checked<?php endif; ?> title="<?php echo lang('woman'); ?>">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><?php echo lang('qq'); ?></label>
            <div class="layui-input-inline">
                <input type="text" name="qq"  placeholder="输入<?php echo lang('qq'); ?>" class="layui-input" value="<?php echo $info['qq']; ?>">
            </div>
        </div>
       <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
        <div class="layui-form-item">
            <div class="layui-input-block">
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
layui.use(['form', 'layer'], function () {
    var form = layui.form, layer = layui.layer,$= layui.jquery;
    form.on('submit(submit)', function (data) {
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
    })
});
</script>



</body>

</html>

