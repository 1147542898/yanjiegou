<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:80:"/www/wwwroot/svn.yanjiegou.com/public/../application/admin/view/ad/typeForm.html";i:1561105812;s:72:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/common.html";i:1561105812;s:68:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/js.html";i:1562165964;}*/ ?>
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
<div class="admin-main layui-anim layui-anim-upbit">    <fieldset class="layui-elem-field layui-field-title">        <legend><?php echo $title; ?></legend>    </fieldset>    <form class="layui-form layui-form-pane">        <div class="layui-form-item">            <label class="layui-form-label">广告位名称</label>            <div class="layui-input-inline">                <input type="text" name="name" lay-verify="required" placeholder="<?php echo lang('pleaseEnter'); ?>广告位名称" class="layui-input">            </div>            <div class="layui-form-mid layui-word-aux">建议格式: 【首页】顶部通栏</div>        </div>        <div class="layui-form-item">            <label class="layui-form-label"><?php echo lang('order'); ?></label>            <div class="layui-input-inline">                <input type="text" name="sort"  value="" placeholder="从小到大排序" class="layui-input">            </div>        </div>        <div class="layui-form-item">            <div class="layui-input-block">                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>                <a href="<?php echo url('type'); ?>" class="layui-btn layui-btn-primary"><?php echo lang('back'); ?></a>            </div>        </div>    </form></div>


<!--js结束-->
<script type="text/javascript">        layui.use(['form', 'layer'], function () {            var form = layui.form, $ = layui.jquery;            form.on('submit(submit)', function (data) {                // 提交到方法 默认为本身                var loading = layer.load(1, {shade: [0.1, '#fff']});                $.post("", data.field, function (res) {                    layer.close(loading);                    if (res.code > 0) {                        layer.msg(res.msg, {time: 1000, icon: 1}, function () {                            location.href = res.url;                        });                    } else {                        layer.msg(res.msg, {time: 1000, icon: 2});                    }                });            })        });</script>


</body>

</html>

