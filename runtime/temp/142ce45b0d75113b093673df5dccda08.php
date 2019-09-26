<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:81:"/www/wwwroot/svn.yanjiegou.com/public/../application/bigshop/view/shop/index.html";i:1561543465;s:74:"/www/wwwroot/svn.yanjiegou.com/application/bigshop/view/Public/common.html";i:1561105812;s:70:"/www/wwwroot/svn.yanjiegou.com/application/bigshop/view/Public/js.html";i:1561543465;}*/ ?>
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
    

    

</head>
<body>

<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-body">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>楼层管理</legend>
    </fieldset>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script type="text/html" id="barDemo">
    {{# if(d.is_lock==1){ }}
     <a class="layui-btn layui-btn-xs" lay-event="agree">开启</a>
    {{# }else{  }}
     <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="reject">停用</a>
    {{# } }}
    <a class="layui-btn layui-btn-xs" onclick="xadmin.open('修改商家楼层','<?php echo url("shop/editfloor"); ?>?sid={{d.id}}',800,600)"><?php echo lang('edit'); ?>楼层</a>
    <a class="layui-btn layui-btn-xs" onclick="xadmin.open('商家详情','<?php echo url("shop/info/index"); ?>?sid={{d.id}}')">详情</a>
</script>
<script type="text/html" id="topBtn">
   <a href="<?php echo url('FloorAdd'); ?>" class="layui-btn layui-btn-sm"><?php echo lang('add'); ?></a>
</script>
<script>
    layui.use(['table','form'], function() {
        var table = layui.table,form = layui.form,$ = layui.jquery;
        var tableIn = table.render({
            elem: '#list',
            url: '<?php echo url(""); ?>',
            method:'post',
			//toolbar: '#topBtn',
			title:'<?php echo lang("admin"); ?><?php echo lang("list"); ?>',
            cols: [[
                {field:'id', title: '编号', width:60,fixed: true}
                ,{field:'shopname', title: '商家名称', width:200}
                ,{field:'num', title: '楼层编号', width:20}
                ,{field:'floorname', title: '楼层名称', width:100}
                ,{field:'is_lock_name', title: '状态', width:80}
                ,{field:'lock_time', title: '操作时间', width:150}
                ,{field:'lock_info', title: '禁用原因', width:200}
                ,{width:300, title:'操作',align:'center', toolbar: '#barDemo'}
            ]]
        });
       table.on('tool(list)', function(obj) {
            var data = obj.data;
            if(obj.event === 'agree'){
                layer.confirm('您确定开启此商家吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('setstatus'); ?>",{id:data.id,status:0},function(res){
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
            if(obj.event === 'reject'){
                layer.prompt({title: '请输入原因', formType: 2},function(text, index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('setstatus'); ?>",{id:data.id,status:1,info:text},function(res){
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
    });
</script>



</body>

</html>

