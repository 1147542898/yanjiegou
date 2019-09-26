<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"/www/wwwroot/svn.yanjiegou.com/public/../application/shop/view/auth/admin_rule.html";i:1561105812;s:71:"/www/wwwroot/svn.yanjiegou.com/application/shop/view/Public/common.html";i:1561105812;s:67:"/www/wwwroot/svn.yanjiegou.com/application/shop/view/Public/js.html";i:1561543465;}*/ ?>
<!doctype html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>沿街购【商家】管理端</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="/static/admin/css/font.css">
    <link rel="stylesheet" href="/static/admin/css/xadmin.css">
    <link rel="stylesheet" href="/static/admin/css/theme224.min.css">
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
        <legend>权限<?php echo lang('list'); ?></legend>
    </fieldset>
    <blockquote class="layui-elem-quote">
        <a href="<?php echo url('ruleAdd'); ?>" class="layui-btn layui-btn-sm"><?php echo lang('add'); ?>节点</a>
        <a href="<?php echo url('clear'); ?>" class="layui-btn layui-btn-sm layui-btn-danger">清除节点</a>
        <a class="layui-btn layui-btn-normal layui-btn-sm"  onclick="openAll();">展开或折叠全部</a>
    </blockquote>
    <table class="layui-table" id="treeTable" lay-filter="treeTable"></table>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script type="text/html" id="auth">
    <input type="checkbox" name="authopen" value="{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="authopen" {{ d.authopen == 0 ? 'checked' : '' }}>
</script>
<script type="text/html" id="status">
    <input type="checkbox" name="menustatus" value="{{d.id}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="menustatus" {{ d.menustatus == 1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="order">
    <input name="{{d.id}}" data-id="{{d.id}}" class="list_order layui-input" value=" {{d.sort}}" size="10"/>
</script>
<script type="text/html" id="icon">
    <span class="fa {{d.icon}}"></span>
</script>
<script type="text/html" id="action">
    <a href="<?php echo url('ruleEdit'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs"><?php echo lang('edit'); ?></a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('del'); ?></a>
</script>
<script type="text/html" id="topBtn">
   <a href="<?php echo url('ruleAdd'); ?>" class="layui-btn layui-btn-sm"><?php echo lang('add'); ?>权限</a>
</script>
<script>
var editObj=null,ptable=null,treeGrid=null,tableId='treeTable',layer=null;
    layui.config({
        base: '/static/admin/lib/layui/extend/'
    }).extend({
        treeGrid:'treeGrid'
    }).use(['jquery','treeGrid','layer','form'], function(){
        var $=layui.jquery;
        treeGrid = layui.treeGrid;
        layer=layui.layer;
        form = layui.form;
        ptable=treeGrid.render({
            id:tableId
            ,elem: '#'+tableId
            ,idField:'id'
            ,url:'<?php echo url("adminRule"); ?>'
            ,cellMinWidth: 100
            ,treeId:'id'//树形id字段名称
            ,treeUpId:'pid'//树形父id字段名称
            ,treeShowName:'title'//以树形式显示的字段
            ,height:'full-140'
            ,isFilter:false
            ,iconOpen:true//是否显示图标【默认显示】
            ,isOpenDefault:true//节点默认是展开还是折叠【默认展开】
            ,cols: [[
                {field: 'id', title: '<?php echo lang("id"); ?>', width: 70, fixed: true},
                {field: 'icon', align: 'center',title: '<?php echo lang("icon"); ?>', width: 60,templet: '#icon'},
                {field: 'title', title: '权限名称', width: 200},
                {field: 'href', title: '控制器/方法', width: 200},
                {field: 'authopen',align: 'center', title: '是否验证权限', width: 150,toolbar: '#auth'},
                {field: 'menustatus',align: 'center',title: '菜单<?php echo lang("status"); ?>', width: 150,toolbar: '#status'},
                {field: 'sort',align: 'center', title: '<?php echo lang("order"); ?>', width: 80, templet: '#order'},
                {width: 160,align: 'center', toolbar: '#action'}
            ]]
            ,page:false
        });
        treeGrid.on('tool('+tableId+')',function (obj) {
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('您确定要删除该记录吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('ruleDel'); ?>",{id:data.id},function(res){
                        layer.close(loading);
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
        form.on('switch(authopen)', function(obj){
            loading =layer.load(1, {shade: [0.1,'#fff']});
            var id = this.value;
            var authopen = obj.elem.checked===true?0:1;
            $.post('<?php echo url("ruleTz"); ?>',{'id':id,'authopen':authopen},function (res) {
                layer.close(loading);
                if (res.status==1) {
                    treeGrid.render;
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                    treeGrid.render;
                    return false;
                }
            })
        });
        form.on('switch(menustatus)', function(obj){
            loading =layer.load(1, {shade: [0.1,'#fff']});
            var id = this.value;
            var menustatus = obj.elem.checked===true?1:0;
            $.post('<?php echo url("ruleState"); ?>',{'id':id,'menustatus':menustatus},function (res) {
                layer.close(loading);
                if (res.status==1) {
                    treeGrid.render;
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                    treeGrid.render;
                    return false;
                }
            })
        });
        $('body').on('blur','.list_order',function() {
           var id = $(this).attr('data-id');
           var sort = $(this).val();
           $.post('<?php echo url("ruleOrder"); ?>',{id:id,sort:sort},function(res){
                if(res.code==1){
                    layer.msg(res.msg,{time:1000,icon:1},function(){
                        location.href = res.url;
                    });
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                    treeGrid.render;
                }
           })
        })
    });
function openAll() {
    var treedata=treeGrid.getDataTreeList(tableId);
    treeGrid.treeOpenAll(tableId,!treedata[0][treeGrid.config.cols.isOpen]);
}
</script>



</body>

</html>

