<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\coupon\index.html";i:1569466684;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
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
<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-body">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>优惠券管理</legend>
    </fieldset>
    <div class="demoTable">
        <div class="layui-inline">
            <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">
        </div>
        <button class="layui-btn" id="search" data-type="reload"><?php echo lang('search'); ?></button>
        <a href="<?php echo url('index',['catid'=>input('catid')]); ?>" class="layui-btn">显示全部</a>
        <div style="clear: both;"></div>
    </div>
    <table id="coupon" lay-filter="coupon"></table>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script type="text/javascript">
    layui.use(['table','util'], function(){
        var table = layui.table;util = layui.util;
        //第一个实例
        var tableIn = table.render({
            elem: '#coupon'
            ,url: "<?php echo url('index'); ?>" //数据接口
            ,method: 'post'
            ,toolbar: '#topBtn'
            ,page: true
            ,cols: [[ //表头
                {field: 'id', title: 'ID', sort: true, fixed: 'left',width: 50}
                ,{field: 'name', title: '优惠券名称',width: 200}
                ,{field: 'min_price', title: '最低消费金额',width: 130}
                ,{field: 'sub_price', title: '优惠金额',width: 100}
                ,{field: 'begin_time', title: '有效期开始时间',width: 130,templet:function(d){return util.toDateString(d.begin_time*1000, "yyyy-MM-dd");}}
                ,{field: 'end_time', title: '有效期结束时间',width: 130,templet:function(d){return util.toDateString(d.end_time*1000, "yyyy-MM-dd");}}
                ,{field: 'add_time', title: '添加时间',width: 100,templet:function(d){return util.toDateString(d.add_time*1000, "yyyy-MM-dd");}}
                ,{field: 'total_count', title: '发放总数量',width: 100}
                ,{field: 'sort', align: 'center', title: '<?php echo lang("order"); ?>', width: 120, templet: '#order'}
                ,{field: 'is_expire', title: '是否有效',width: 80}
                ,{width: 160, align: 'center', toolbar: '#action',title:'操作'}
            ]]
        });
        table.on('tool(coupon)', function(obj) {
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('您确定要删除该内容吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('listDel'); ?>",{id:data.id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg(res.msg,{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
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
    });
</script>
<script type="text/html" id="topBtn">
   <a href="<?php echo url('add',array('catid'=>input('catid'))); ?>" class="layui-btn"><i class="layui-icon"></i><?php echo lang('add'); ?></a>
</script>
<script type="text/html" id="order">
    <input name="{{d.id}}" data-id="{{d.id}}" class="list_order layui-input" value=" {{d.sort}}" size="10"/>
</script>
<script type="text/html" id="action">
    {{#  if(d.typeid!=2){ }}
        <a href="<?php echo url('edit'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    {{#  } else { }}
        {{d.shop_name}}(商家)
    {{#  } }}
</script>



</body>

</html>

