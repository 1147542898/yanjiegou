<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\ad\type.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1570615895;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
    <div class="layui-fluid"><div class="layui-row layui-col-space15"><div class="layui-col-md12"><div class="layui-card"><div class="layui-card-body ">    <fieldset class="layui-elem-field layui-field-title">        <legend><?php echo lang('ad'); ?>位管理</legend>    </fieldset>    <div class="demoTable">        <div class="layui-inline">            <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">        </div>        <button class="layui-btn" id="search" data-type="reload"><?php echo lang('search'); ?></button>        <a href="<?php echo url('type'); ?>" class="layui-btn">显示全部</a>        <a href="<?php echo url('addType'); ?>" class="layui-btn" style="float:right;"><i class="fa fa-plus" aria-hidden="true"></i><?php echo lang('add'); ?><?php echo lang('ad'); ?>位</a>        <div style="clear: both;"></div>    </div>    <table class="layui-table" id="list" lay-filter="list"></table></div></div></div></div></div>


    <!--js结束-->
    <script>    layui.use('table', function() {        var table = layui.table, $ = layui.jquery;        var tableIn = table.render({            id: 'type',            elem: '#list',            url: '<?php echo url("type"); ?>',            method: 'post',            cols: [[                {field: 'type_id', title: '<?php echo lang("id"); ?>', width: 80, fixed: true, sort: true},                {field: 'name', title: '广告位名称', width: 400, templet: '#name'},                {field: 'sort', align: 'center', title: '<?php echo lang("order"); ?>', width: 120, templet: '#order', sort: true},                {width: 160, align: 'center', toolbar: '#action'}            ]]        });        //搜索        $('#search').on('click', function () {            var key = $('#key').val();            if ($.trim(key) === '') {                layer.msg('<?php echo lang("pleaseEnter"); ?>关键字！', {icon: 0});                return;            }            tableIn.reload({                where: {key: key}            });        });        //排序        $('body').on('blur','.list_order',function() {            var type_id = $(this).attr('data-id');            var sort = $(this).val();            var loading = layer.load(1, {shade: [0.1, '#fff']});            $.post('<?php echo url("typeOrder"); ?>',{type_id:type_id,sort:sort},function(res){                layer.close(loading);                if(res.code === 1){                    layer.msg(res.msg, {time: 1000, icon: 1});                    tableIn.reload();                }else{                    layer.msg(res.msg,{time:1000,icon:2});                }            })        });        table.on('tool(list)', function(obj) {            var data = obj.data;            if(obj.event === 'del'){                layer.confirm('您确定要删除该广告分类吗？', function(index){                    var loading = layer.load(1, {shade: [0.1, '#fff']});                    $.post("<?php echo url('delType'); ?>",{type_id:data.type_id},function(res){                        layer.close(loading);                        if(res.code===1){                            layer.msg(res.msg,{time:1000,icon:1});                            tableIn.reload();                        }else{                            layer.msg('操作失败！',{time:1000,icon:2});                        }                    });                    layer.close(index);                });            }        });    });</script><script type="text/html" id="order">    <input name="{{d.type_id}}" data-id="{{d.type_id}}" class="list_order layui-input" value=" {{d.sort}}" size="10"/></script><script type="text/html" id="action">    <a href="<?php echo url('editType'); ?>?type_id={{d.type_id}}" class="layui-btn layui-btn-xs">编辑</a>    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a></script>


</body>

</html>