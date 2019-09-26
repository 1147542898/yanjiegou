<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"/www/wwwroot/svn.yanjiegou.com/public/../application/bigshop/view/statistic/shop.html";i:1561516925;s:74:"/www/wwwroot/svn.yanjiegou.com/application/bigshop/view/Public/common.html";i:1561105812;s:70:"/www/wwwroot/svn.yanjiegou.com/application/bigshop/view/Public/js.html";i:1561543465;}*/ ?>
<!doctype html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>沿街购【商圈】管理端</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="/static/admin/css/font.css">
    <link rel="stylesheet" href="/static/admin/css/xadmin.css">
    <link rel="stylesheet" href="/static/admin/css/theme12.min.css">
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
    
<style type="text/css">
    .layui-table-body tr{height:50px;}
    .layui-table-body td .laytable-cell-1-0-2{padding: 0;margin:0;height:50px;}
</style>


</head>
<body>

<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-body">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>商品销售排行</legend>
    </fieldset>
    <div class="demoTable">
        <div class="layui-inline">
            <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">
        </div>
        <button class="layui-btn" id="search" data-type="reload"><?php echo lang('search'); ?></button>
        <a href="<?php echo url('index',['catid'=>input('catid')]); ?>" class="layui-btn">显示全部</a>
        <div style="clear: both;"></div>
    </div>
    <table class="layui-table" id="list" lay-filter="list" lay-skin="row"></table>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->


<script type="text/html" id="title">
   {{d.shopname}}{{# if(d.shopname){ }}<img src="/static/admin/images/image.gif" onmouseover="layer.tips('<img src={{d.shoplogo}}>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();" >{{# } }}
</script>

<script>
    layui.use(['table','form','util'], function() {
        var table = layui.table, $ = layui.jquery,form = layui.form;util = layui.util;
        var tableIn = table.render({
            id: 'content',
            elem: '#list',
            url: '<?php echo url(""); ?>',
            method: 'post',
            toolbar: '#topBtn',
            page: true,
            cols: [[
                {field: 'id', title: '商品编号', width: 150},
                {field: 'shopname', title: '商铺名称',toolbar: '#title',},
                {field: 'num', title: '总商品销售数量'},
                {field: 'money', title: '总商品销售价格'},
            ]],
            limit: 10
        });
    });    
</script>



</body>

</html>

