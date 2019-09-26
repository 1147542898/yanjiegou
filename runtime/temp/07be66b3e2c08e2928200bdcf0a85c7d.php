<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"/www/wwwroot/svn.yanjiegou.com/public/../application/admin/view/auth/admin_group.html";i:1561105812;s:72:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/common.html";i:1561105812;s:68:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/js.html";i:1562165964;}*/ ?>
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
        <legend>用户组列表</legend>
    </fieldset>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script type="text/html" id="action">
    <a href="<?php echo url('groupAccess'); ?>?id={{d.group_id}}" class="layui-btn layui-btn-xs layui-btn-normal">配置规则</a>
    <a href="<?php echo url('groupEdit'); ?>?id={{d.group_id}}" class="layui-btn layui-btn-warm layui-btn-xs"><?php echo lang('edit'); ?></a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('del'); ?></a>
</script>
<script type="text/html" id="topBtn">
   <a href="<?php echo url('groupAdd'); ?>" class="layui-btn layui-btn-sm"><?php echo lang('add'); ?>用户组</a>
</script>
<script>
    layui.use('table', function() {
        var table = layui.table,$ = layui.jquery;
        table.render({
            elem: '#list',
            url: '<?php echo url("adminGroup"); ?>',
            method:'post',
			toolbar: '#topBtn',
			title:'用户组列表',
            cols: [[
                {field:'group_id', title: '<?php echo lang("id"); ?>',width:80, fixed: true,sort: true},
                {field:'title', title: '用户组名', width:180},
                {field:'addtime', title: '添加时间', width:200,sort: true},
                {width:260, align:'center',toolbar:'#action'}
            ]]
        });
        table.on('tool(list)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('你确定要删除该分组吗？', function(index){
                    loading =layer.load(1, {shade: [0.1,'#fff']});
                    $.post("<?php echo url('groupDel'); ?>",{id:data.group_id},function(res){
                        layer.close(loading);
                        layer.close(index);
                        if(res.code==1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            obj.del();
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
                        }
                    });
                });
            }
        });
    });
</script>



</body>

</html>

