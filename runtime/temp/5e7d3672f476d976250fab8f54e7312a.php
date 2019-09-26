<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:82:"/www/wwwroot/svn.yanjiegou.com/public/../application/admin/view/message/index.html";i:1561105812;s:70:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/common/head.html";i:1561105812;s:70:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/common/foot.html";i:1561105812;}*/ ?>
<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title><?php echo config('sys_name'); ?>后台管理</title>

    <meta name="renderer" content="webkit">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css" media="all" />

    <link rel="stylesheet" href="/static/admin/css/global.css" media="all">

    <link rel="stylesheet" href="/static/common/css/font.css" media="all">

   

</head>

<body class="skin-<?php if(!empty($_COOKIE['skin'])){echo $_COOKIE['skin'];}else{echo '0';setcookie('skin','0');}?>">
<div class="admin-main layui-anim layui-anim-upbit">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>订单退换原因</legend>
    </fieldset>
    <div class="demoTable">
        <div class="layui-inline">
            <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">
        </div>
        <button class="layui-btn" id="search" data-type="reload"><?php echo lang('search'); ?></button>
        <a href="<?php echo url('index'); ?>" class="layui-btn">显示全部</a>
        <button type="button" class="layui-btn layui-btn-danger" id="delAll">批量删除</button>
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
<script type="text/javascript" src="/static/plugins/layui/layui.js"></script>


<script type="text/html" id="action">
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script>
    layui.use('table', function() {
        var table = layui.table, $ = layui.jquery;
        var tableIn = table.render({
            id: 'message',
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            method: 'post',
            page: true,
            cols: [[
                {checkbox: true, fixed: true},
                {field: 'message_id', title: '<?php echo lang("id"); ?>', width: 80,fixed: true},
                {field: 'name', title: '<?php echo lang("name"); ?>', width: 120},
                {field: 'email', title: '<?php echo lang("email"); ?>', width: 180},
                {field: 'content', title: '<?php echo lang("content"); ?>', width: 300},
                {field: 'addtime', title: '留言时间', width: 150},
                {field: 'ip', title: '<?php echo lang("ip"); ?>', width: 180},
                {width: 80, align: 'center', toolbar: '#action'}
            ]],
            limit: 10 //每页默认显示的数量
        });
        //搜索
        $('#search').on('click', function () {
            var key = $('#key').val();
            if ($.trim(key) === '') {
                layer.msg('<?php echo lang("pleaseEnter"); ?>关键字！', {icon: 0});
                return;
            }
            tableIn.reload({ page: {page: 1}, where: {key: key}});
        });
        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if (obj.event === 'del') {
                layer.confirm('您确定要删除该留言吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('del'); ?>",{message_id:data.message_id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
        });
        $('#delAll').click(function(){
            layer.confirm('确认要删除选中的留言吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('message'); //test即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.message_id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('delall'); ?>", {ids: ids}, function (data) {
                    layer.close(loading);
                    if (data.code === 1) {
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn.reload();
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })
    });
</script>