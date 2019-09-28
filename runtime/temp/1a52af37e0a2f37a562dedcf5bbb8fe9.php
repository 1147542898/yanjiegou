<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\order\lists.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
<div class="layui-fluid"><div class="layui-row layui-col-space15"><div class="layui-col-md12"><div class="layui-card"><div class="layui-card-body">    <fieldset class="layui-elem-field layui-field-title">        <legend>订单列表</legend>    </fieldset>    <div class="demoTable">        <div class="layui-inline">            <input class="layui-input" name="key" id="key" placeholder="请输入下单手机或订单号">        </div>        <!-- <div class="layui-inline ">            <select name="status" id="status" class="layui-input"  style="width:110px">                <option>请选择订单状态</option>                <?php echo get_status_option(input('status'),'order_status'); ?>            </select>        </div> -->        <button type="button" class="layui-btn" id="search" data-type="reload" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>    </div>    <table class="layui-table" id="list" lay-filter="list" lay-skin="row"></table></div></div></div></div></div>


<!--js结束-->
<script type="text/html" id="action">    {{# if(d.status==2){ }}    <!-- <a  class="green" onclick="xadmin.open('请输入发货信息','<?php echo url("send"); ?>?id={{d.id}}')">发货</a> -->     {{# } }}    <a class="red" onclick="xadmin.open('查看订单信息','<?php echo url("info"); ?>?id={{d.id}}')">查看详情</a></script><script>        layui.use(['table','form'], function() {        var table = layui.table, $ = layui.jquery,form = layui.form;        var tableIn = table.render({            elem: '#list'            ,url: "<?php echo url('lists'); ?>" //数据接口            ,where:{status:'<?php echo input("status"); ?>'}            ,method: 'post'            ,toolbar: '#topBtn'            ,page: true //开启分页            ,cols: [[ //表头                {field: 'order_sn', title: '订单号',width:150}                ,{field: 'umobile', title: '下单者',width:150}                ,{field: 'sname', title: '商家',width:150}                ,{field: 'money', title: '应收金额',width:150}                ,{field: 'oldmoney', title: '原金额',width:150}                ,{field: 'total_num', title: '购买数量',width:80}                ,{field: 'statusname', title: '订单状态',width:90}                ,{field: 'pay_type', title: '支付方式',width:80}                ,{field: 'add_time', title: '下单时间',width:150}                ,{toolbar: '#action',title:'操作'}            ]],            limit: 10        });             $('#search').on('click', function () {            var key = $('#key').val();            tableIn.reload({ page: {page: 1}, where: {key: key,status:'<?php echo input("status"); ?>'} });        });        form.on('submit(sreach)', function(data){            return false;        });    });</script>


</body>

</html>

