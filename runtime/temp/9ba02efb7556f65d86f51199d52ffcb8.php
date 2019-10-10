<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\auth\admin_list.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1570615895;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
        <legend><?php echo lang('admin'); ?><?php echo lang('list'); ?></legend>
    </fieldset>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
</div>
</div>
</div>
</div>



    <!--js结束-->
    
<script type="text/html" id="barDemo">
    <a href="<?php echo url('adminEdit'); ?>?admin_id={{d.admin_id}}" class="layui-btn layui-btn-xs"><?php echo lang('edit'); ?></a>
    {{# if(d.admin_id==1){ }}
    <a href="#" class="layui-btn layui-btn-xs layui-btn-disabled"><?php echo lang('del'); ?></a>
    {{# }else{  }}
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('del'); ?></a>
    {{# } }}
</script>
<script type="text/html" id="open">
    {{# if(d.admin_id==1){ }}
        <input type="checkbox" disabled name="is_open" value="{{d.admin_id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="open" checked>
    {{# }else{  }}
        <input type="checkbox" name="is_open" value="{{d.admin_id}}" lay-skin="switch" lay-text="开启|关闭" lay-filter="open" {{ d.is_open == 1 ? 'checked' : '' }}>
    {{# } }}
</script>
<script type="text/html" id="topBtn">
   <a href="<?php echo url('adminAdd'); ?>" class="layui-btn layui-btn-sm"><?php echo lang('add'); ?><?php echo lang('admin'); ?></a>
</script>
<script>
    layui.use(['table','form'], function() {
        var table = layui.table,form = layui.form,$ = layui.jquery;
        var tableIn = table.render({
            elem: '#list',
            url: '<?php echo url("adminList"); ?>',
            method:'post',
			toolbar: '#topBtn',
			title:'<?php echo lang("admin"); ?><?php echo lang("list"); ?>',
            cols: [[
                {field:'admin_id', title: '编号', width:60,fixed: true}
                ,{field:'username', title: '用户名', width:180}
                ,{field:'realname', title: '真名', width:180}
				,{field:'title', title: '<?php echo lang("userGroup"); ?>', width:200}
                ,{field:'email', title: '邮箱', width:200}
                ,{field:'tel', title: '<?php echo lang("tel"); ?>', width:150}
                ,{field:'ip', title: '<?php echo lang("ip"); ?>',width:150,hide:true}
                ,{field:'is_open', title: '<?php echo lang("status"); ?>',width:150,toolbar: '#open'}
                ,{width:160, align:'center', toolbar: '#barDemo'}
            ]]
        });
        form.on('switch(open)', function(obj){
            loading =layer.load(1, {shade: [0.1,'#fff']});
            var id = this.value;
            var is_open = obj.elem.checked===true?1:0;
            $.post('<?php echo url("adminState"); ?>',{'id':id,'is_open':is_open},function (res) {
                layer.close(loading);
                if (res.status==1) {
                    tableIn.reload();
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                    return false;
                }
            })
        });
        table.on('tool(list)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('<?php echo lang("Are you sure you want to delete it"); ?>', function(index){
                    $.post("<?php echo url('adminDel'); ?>",{admin_id:data.admin_id},function(res){
                        if(res.code==1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            obj.del();
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
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