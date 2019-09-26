<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\shop\index.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
    <legend>商家管理</legend>
</fieldset>
<div class="layui-inline layui-show-xs-block">
    <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">
</div>
<div class="layui-inline layui-show-xs-block">
    <button class="layui-btn" id="search" data-type="reload" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
</div>
<table class="layui-table" id="list" lay-filter="list"></table>              
 </div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script type="text/javascript">
    layui.use(['table','form'], function() {
        var table = layui.table, $ = layui.jquery,form = layui.form;
        var tableIn = table.render({
            id: 'content',
            elem: '#list',
            url: '<?php echo url("admin/shop/index"); ?>',
            where:{catid:'<?php echo input("catid"); ?>'},
            method: 'post',
            toolbar: '#topBtn',
            page: true,
            cols: [[
                {type: "checkbox", fixed: true},
                {field: 'id', title: '<?php echo lang("id"); ?>', width: 80, fixed: true},
                {field: 'name',  title: '商家名称', templet: '#name'},
                {field: 'bname',  title: '所属商圈'},
                {field: 'phone', title: '电话', width:120},
                {field: 'pastdue',  title: '服务到期时间', width: 120},
                {field: 'sort', align: 'center', title: '<?php echo lang("order"); ?>', width: 120, templet: '#order'},
                {field: 'statusname', align: 'center', title: '状态', width: 120 },
                {field: 'lock_name', align: 'center', title: '锁定状态', width: 120},
                {width: 300, align: 'center', toolbar: '#action',title:'操作'}
            ]],
            limit: 10
        });
        form.on('switch(status)', function(obj){
            loading =layer.load(1, {shade: [0.1,'#fff']});
            var id = this.value;
            var status = obj.elem.checked===true?1:0;
            $.post('<?php echo url("shopState"); ?>',{'id':id,'status':status},function (res) {
                layer.close(loading);
                if (res.code==1) {
                    tableIn.reload();
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                    return false;
                }
            })
        });
        $('#search').on('click', function () {
            var key = $('#key').val();
            if ($.trim(key) === '') {
                layer.msg('<?php echo lang("pleaseEnter"); ?>关键字！', {icon: 0});
                return;
            }
            tableIn.reload({ page: {page: 1}, where: {key: key,catid:'<?php echo input("catid"); ?>'} });
        });
        $('body').on('blur','.list_order',function() {
            var id = $(this).attr('data-id');
            var sort = $(this).val();
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post('<?php echo url("listorder"); ?>',{id:id,sort:sort},function(res){
                layer.close(loading);
                if(res.code === 1){
                    layer.msg(res.msg, {time: 1000, icon: 1}, function () {
                        location.href = res.url;
                    });
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                }
            })
        });
        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('您确定要删除该内容吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('listDel'); ?>",{id:data.id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload({where:{catid:'<?php echo input("catid"); ?>'}});
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
            if(obj.event === 'nature'){
                layer.open({
                    type: 2,
                    title: '商品属性',
                    area: ['700px', '450px'],
                    fixed: false, //不固定
                    maxmin: true,
                    content: ['details.html','no']
                });
            }
        });
        $('body').on('click','#delAll',function() {
            layer.confirm('确认要删除选中的内容吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('content'); //content即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('delAll'); ?>", {ids: ids,catid:'<?php echo input("catid"); ?>'}, function (data) {
                    layer.close(loading);
                    if (data.code === 1) {
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn.reload({where:{catid:'<?php echo input("catid"); ?>'}});
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })
    });
</script>
<script type="text/html" id="order">
    <input name="{{d.id}}" data-id="{{d.id}}" class="list_order layui-input" value=" {{d.sort}}" size="10"/>
</script>
<script type="text/html" id="name">
    {{d.name}}{{# if(d.name){ }}<img src="/static/admin/images/image.gif" onmouseover="layer.tips('<img width=300  src={{d.shoplogo}}>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();" >{{# } }}
</script>
<script type="text/html" id="action">
    {{# if(d.is_show==1){ }}
    <a href="{{d.url}}" target="_blank" class="layui-btn layui-btn-xs layui-btn-normal">预览</a>
    {{# } }}
    <a href="<?php echo url('admin/shop/edit'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    <a href="<?php echo url('admin/shop/admin'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs">商家管理员</a>
</script>
<script type="text/html" id="myaddress">
    <p>{d.province}</p>
</script>
<script type="text/html" id="topBtn">
    <button type="button" class="layui-btn layui-btn-danger" id="delAll"><i class="layui-icon"></i>批量删除</button>
    <a href="<?php echo url('add',array('catid'=>input('catid'))); ?>" class="layui-btn"><i class="layui-icon"></i><?php echo lang('add'); ?></a>
</script>



</body>

</html>

