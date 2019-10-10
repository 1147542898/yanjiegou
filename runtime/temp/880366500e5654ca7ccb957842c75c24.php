<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\fund\order.html";i:1570675228;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
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
                    <div class="layui-tab layui-tab-brief">
                        <fieldset class="layui-elem-field layui-field-title">
                            <legend>订单结算</legend>
                        </fieldset>
                        <ul class="layui-tab-title">
                            <li class="layui-this">结算信息</li>
                            <li>未结算订单</li>
                            <li>已结算订单</li>
                        </ul>
                        <div class="layui-tab-content">
                            <div class="layui-tab-item layui-show">
                                <table class="layui-table" id="jsxx" lay-filter="jsxx"></table>
                            </div>
                            <div class="layui-tab-item">
                                <!-- <div class="demoTable">
                                    <div class="layui-inline">
                                        <input class="layui-input" name="key" id="key"
                                            placeholder="<?php echo lang('pleaseEnter'); ?>关键字">
                                    </div>
                                    <button class="layui-btn" id="search" data-type="reload">搜索</button>
                                    <a href="<?php echo url('index'); ?>" class="layui-btn">显示全部</a>
                                </div> -->
                                <table class="layui-table" id="list" lay-filter="list"></table>
                            </div>
                            <div class="layui-tab-item">
                                    <table class="layui-table" id="yjsd" lay-filter="yjsd"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--js结束-->

<script>
    layui.use(['table', 'form', 'jquery', 'element'], function () {
        var table = layui.table, form = layui.form, $ = layui.jquery, element = layui.element;
        var tableIn = table.render({
            id: 'user',
            elem: '#jsxx',
            url: '<?php echo url("settlements"); ?>',
            method: 'post',          
            page: true,
            cols: [[
                { field: 'settlementNo', title: '结算单号', width: 150 },
                { field: 'settlementType', title: '类型', width: 100 },
                { field: 'settlementMoney', title: '结算金额', width: 160 },
                { field: 'backMoney', title: '返还金额', width: 120 },
                { field: 'createTime', title: '创建时间', width: 120 },                
                { field: 'settlementStatus', title: '结算状态', width: 120 },                
                { field: 'settlementTime', title: '结算时间', width: 120 },                
                { field: 'remarks', title: '备注', width: 200 },                
            ]],
            limit: 10 //每页默认显示的数量
        });
        var tableIn = table.render({
            id: 'user',
            elem: '#list',
            url: '<?php echo url(""); ?>',
            method: 'post',
            // toolbar: '#topBtn',
            page: true,
            cols: [[
                { field: 'order_sn', title: '订单单号', width: 150 },
                { field: 'add_time', title: '下单时间', width: 200 },
                { field: 'pay_type', title: '支付方式', width: 160 },
                { field: 'freight', title: '运费', width: 120 },
                { field: 'money', title: '实付金额', width: 120 },
                , { width: 160, align: 'center', toolbar: '#action', title: '操作' }
            ]],
            limit: 10 //每页默认显示的数量
        });
        var tableIn = table.render({
            id: 'user',
            elem: '#yjsd',
            url: '<?php echo url("jsOrder"); ?>',
            method: 'post',
            // toolbar: '#topBtn',
            page: true,
            cols: [[
                { field: 'order_sn', title: '订单单号', width: 150 },
                { field: 'add_time', title: '下单时间', width: 200 },
                { field: 'pay_type', title: '支付方式', width: 160 },
                { field: 'freight', title: '运费', width: 120 },
                { field: 'money', title: '实付金额', width: 120 },
                { field: 'settlementNo', title: '结算单号', width: 120 },
                { field: 'settlementTime', title: '结算时间', width: 120 },                
            ]],
            limit: 10 //每页默认显示的数量
        });
        //搜索
        $('#search').on('click', function () {
            var key = $('#key').val();
            if ($.trim(key) === '') {
                layer.msg('<?php echo lang("pleaseEnter"); ?>关键字！', { icon: 0 });
                return;
            }
            tableIn.reload({ page: { page: 1 }, where: { key: key } });
        });
        table.on('tool(list)', function (obj) {
            var data = obj.data;
            if (obj.event === 'sendOrder') {
                console.log(data.id);
                $.post("<?php echo url('setOrderjs'); ?>", { id: data.id }, function (res) {
                    if (res.code == 1) {
                        layer.msg(res.msg, { time: 1000, icon: 1 }, function () {
                            tableIn.reload();
                        });
                    } else {
                        layer.msg(res.msg, { time: 1000, icon: 2 });
                    }

                });

            }
        });

    });
</script>
<script type="text/html" id="action">
    {{# if(d.settlementId ==0){ }}
        <a  class="layui-btn layui-btn-xs" lay-event="sendOrder">申请结算</a>
    {{# }}}     
</script>



</body>

</html>

