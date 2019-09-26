<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:80:"/www/wwwroot/svn.yanjiegou.com/public/../application/admin/view/users/index.html";i:1561105812;s:72:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/common.html";i:1561105812;s:68:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/js.html";i:1562165964;}*/ ?>
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
<div class="layui-fluid"><div class="layui-row layui-col-space15"><div class="layui-col-md12"><div class="layui-card"><div class="layui-card-body">    <fieldset class="layui-elem-field layui-field-title">        <legend><?php echo lang('user'); ?><?php echo lang('list'); ?></legend>    </fieldset>    <div class="demoTable">        <div class="layui-inline">            <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">        </div>        <button class="layui-btn" id="search" data-type="reload">搜索</button>        <a href="<?php echo url('index'); ?>" class="layui-btn">显示全部</a>    </div>    <table class="layui-table" id="list" lay-filter="list"></table></div></div></div></div></div>


<!--js结束-->
<script>    layui.use(['table','form'], function() {        var table = layui.table,form = layui.form, $ = layui.jquery;        var tableIn = table.render({            id: 'user',            elem: '#list',            url: '<?php echo url("index"); ?>',            method: 'post',            toolbar: '#topBtn',            page: true,            cols: [[                {checkbox:true,fixed: true},                {field: 'id', title: '<?php echo lang("id"); ?>', width: 80, fixed: true},                {field: 'username', title: '<?php echo lang("nickname"); ?>', width: 120},                {field: 'level_name', title: '会员等级', width: 100},                {field: 'email', title: '<?php echo lang("email"); ?>', width: 250,templet:'#email'},                {field: 'mobile', title: '<?php echo lang("tel"); ?>', width: 150,hide:true},                {field: 'sex', title: '性别', width: 80,templet:'#sex',hide:true},                {field: 'is_lock', align: 'center',title: '<?php echo lang("status"); ?>', width: 120,toolbar: '#is_lock'},                {field: 'reg_time', title: '注册时间', width: 150},                {width: 160, align: 'center', toolbar: '#action'}            ]],            limit: 10 //每页默认显示的数量        });        form.on('switch(is_lock)', function(obj){            loading =layer.load(1, {shade: [0.1,'#fff']});            var id = this.value;            var is_lock = obj.elem.checked===true?0:1;            $.post('<?php echo url("usersState"); ?>',{'id':id,'is_lock':is_lock},function (res) {                layer.close(loading);                if (res.status==1) {                    tableIn.reload();                }else{                    layer.msg(res.msg,{time:1000,icon:2});                    return false;                }            })        });        //搜索        $('#search').on('click', function() {            var key = $('#key').val();            if($.trim(key)==='') {                layer.msg('<?php echo lang("pleaseEnter"); ?>关键字！',{icon:0});                return;            }            tableIn.reload({ page: {page: 1},where: {key: key}});        });        //删除        table.on('tool(list)', function(obj) {            var data = obj.data;            if (obj.event === 'del') {                layer.confirm('您确定要删除该会员吗？', function(index){                    var loading = layer.load(1, {shade: [0.1, '#fff']});                    $.post("<?php echo url('usersDel'); ?>",{id:data.id},function(res){                        layer.close(loading);                        if(res.code===1){                            layer.msg(res.msg,{time:1000,icon:1});                            tableIn.reload();                        }else{                            layer.msg('操作失败！',{time:1000,icon:2});                        }                    });                    layer.close(index);                });            }        });    });</script><script type="text/html" id="is_lock">    <input type="checkbox" name="is_lock" value="{{d.id}}" lay-skin="switch" lay-text="正常|禁用" lay-filter="is_lock" {{ d.is_lock == 0 ? 'checked' : '' }}></script><script type="text/html" id="action">    <a href="<?php echo url('edit'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs">编辑</a>    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a></script><script type="text/html" id="email">    {{d.email}}    {{# if(d.email && d.email_validated=='0'){ }}    (未验证)    {{# } }}</script><script type="text/html" id="topBtn">    <a href="<?php echo url('add'); ?>" style="height:30px; width:68px; " class="layui-btn layui-btn-danger layui-btn-sm" id="add" >添加会员</a></script><script type="text/html" id="sex">    {{# if(d.sex=='0'){ }}    女    {{# }else{ }}    男    {{# } }}</script>


</body>

</html>

