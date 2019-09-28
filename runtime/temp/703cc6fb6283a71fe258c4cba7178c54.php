<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\order\refund.html";i:1569466684;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
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
<div class="layui-fluid"><div class="layui-row layui-col-space15"><div class="layui-col-md12"><div class="layui-card"><div class="layui-card-body">    <fieldset class="layui-elem-field layui-field-title">        <legend>售后订单列表</legend>    </fieldset>    <div class="demoTable">        <div class="layui-inline">            <input class="layui-input" name="key" id="key" placeholder="请输入下单手机或订单号">        </div>        <!-- <div class="layui-inline ">            <select name="status" id="status" class="layui-input"  style="width:110px">                <option>请选择订单状态</option>                <?php echo get_status_option(input('status'),'order_status'); ?>            </select>        </div> -->        <button type="button" class="layui-btn" id="search" data-type="reload" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>    </div>    <table class="layui-table" id="list" lay-filter="list" lay-skin="row"></table></div></div></div></div></div>


<!--js结束-->
<script type="text/html" id="action">    {{# if(d.status==0){ }}       <!-- <a class="green" lay-event="check" title="审核通过">通过</a>       <a class="red" lay-event="nocheck" title="审核不通过">不通过</a> -->    {{# } }}       <a class="green" onclick="xadmin.open('查看申请售后信息','<?php echo url("refundinfo"); ?>?id={{d.id}}')">处理</a>       <a class="green" onclick="xadmin.open('查看原订单信息','<?php echo url("info"); ?>?id={{d.order_id}}')">订单详情</a>       </script><script type="text/html" id="pics">    <img style="cursor: pointer; width: 50px;height:50px;" lay-event='open_image' src="{{d.headimg}}"></script><script>        layui.use(['table','form'], function() {        var table = layui.table, $ = layui.jquery,form = layui.form;        var tableIn = table.render({            elem: '#list'            ,url: "<?php echo url(''); ?>" //数据接口            ,method: 'post'            ,toolbar: '#topBtn'            ,page: true //开启分页            ,cols: [[ //表头                 {field: 'id', title: '编号',width:60}                ,{field: 'order_sn', title: '原订单号',width:150}                ,{field: 'username', title: '下单账户',width:100}                // ,{field: 'sname', title: '商家',width:150}                // ,{field: 'pay_type', title: '支付方式',width:80}                // ,{field: 'oadd_time', title: '下单时间',width:150}                ,{field: 'headimg', title: '商品图片', width: 80,  toolbar: '#pics',align:'center'}                ,{field: 'title', title: '商品名称', edit: 'text',width:400}                ,{field: 'add_time', title: '申请售后时间',width:150}                ,{field: 'statusname', title: '售后状态',width:150}                ,{toolbar: '#action',title:'操作',width:300}            ]],            limit: 10        });             $('#search').on('click', function () {            var key = $('#key').val();            tableIn.reload({ page: {page: 1}, where: {key: key,status:'<?php echo input("status"); ?>'} });        });        form.on('submit(sreach)', function(data){            return false;        });        table.on('tool(list)', function(obj) {            var data = obj.data;            if(obj.event === 'check'){                layer.prompt({formType: 2,title: '请输入通过处理说明'},                     function(value, index){                        var loading = layer.load(1, {shade: [0.1, '#fff']});                        $.post("<?php echo url('setrefundstatus'); ?>",{id:data.id,text:value,status:2},function(res){                            layer.close(loading);                            if(res.code===1){                                layer.msg(res.msg,{time:1000,icon:1});                                tableIn.reload({where:{way:'<?php echo input("way"); ?>'}});                            }else{                                layer.msg('操作失败！',{time:1000,icon:2});                            }                        });                        layer.close(index);                    })               }            if(obj.event === 'nocheck'){                layer.prompt({formType: 2,title: '请输入不通过原因'},                 function(value, index){                    var loading = layer.load(1, {shade: [0.1, '#fff']});                    $.post("<?php echo url('setrefundstatus'); ?>",{id:data.id,text:value,status:1},function(res){                        layer.close(loading);                        if(res.code===1){                            layer.msg(res.msg,{time:1000,icon:1});                            tableIn.reload({where:{way:'<?php echo input("way"); ?>'}});                        }else{                            layer.msg('操作失败！',{time:1000,icon:2});                        }                    });                    layer.close(index);                });            }        });    });</script>


</body>

</html>

