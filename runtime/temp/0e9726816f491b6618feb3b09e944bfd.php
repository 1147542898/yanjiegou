<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\fund\nows.html";i:1570515144;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
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
        <legend>提现申请</legend>
    </fieldset>
    <div class="demoTable">
        <!-- <div class="layui-inline">
            <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">
        </div>
        <button class="layui-btn" id="search" data-type="reload">搜索</button>
        <a href="<?php echo url('index'); ?>" class="layui-btn">显示全部</a> -->
        <div style="float:left; height:30px;line-height:30px;font-size:13px;">
            <span style="padding: 10px">可用资金:<span style="color:red">¥<?php echo $shop_money; ?></span></span> 
            <span style="padding: 10px">冻结资金:<span style="color:red">¥<?php echo $lock_money; ?></span></span>            
        </div>
    </div>
    <table class="layui-table" id="list" lay-filter="list"></table>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script>
    layui.use(['table','form'], function() {
        var table = layui.table,form = layui.form, $ = layui.jquery;
        var tableIn = table.render({
            id: 'user',
            elem: '#list',
            url: '<?php echo url(""); ?>',
            method: 'post',
            toolbar: '#topBtn',
            page: true,
            cols: [[
                {field: 'addtime', title: '申请时间', width: 150},
                {field: 'money', title: '金额', width: 100},                
                {field: 'bank_name', title: '开户行', width: 160},
                {field: 'bank_number', title: '银行卡号', width: 160},
                {field: 'bank_user_name', title: '持卡人', width: 120},
                {field: 'bank_address', title: '开户地址', width: 120},
                {field: 'status', title: '状态', width: 100},
                {field: 'note', title: '申请备注', width: 150},
                {field: 'dotime', title: '处理时间', width: 150},
                {field: 'info', title: '处理备注', width: 150},
                {field: 'dousername', title: '处理人账号', width: 120},
            ]],
            limit: 10 //每页默认显示的数量
        });
       
        //搜索
        $('#search').on('click', function() {
            var key = $('#key').val();
            if($.trim(key)==='') {
                layer.msg('<?php echo lang("pleaseEnter"); ?>关键字！',{icon:0});
                return;
            }
            tableIn.reload({ page: {page: 1},where: {key: key}});
        });
       
    });
</script>

<script type="text/html" id="topBtn">
    <a href="javascript:;" onclick="xadmin.open('添加申请','<?php echo url('add'); ?>',600,500)" style="height:30px; width:68px; " class="layui-btn layui-btn-danger layui-btn-sm" id="add" >添加申请</a>
</script>



</body>

</html>

