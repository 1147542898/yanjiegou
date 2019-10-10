<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:84:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\shop\settlements.html";i:1570674348;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1570615895;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
                        <legend>结算申请</legend>
                    </fieldset>
                    <!-- <div class="demoTable">
                        <form class="layui-form">
                            <div class="layui-inline">
                                <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">
                            </div>
                            <div class="layui-inline ">
                                <select name="status" id="" lay-filter="status">
                                    <option value=" ">状态</option>
                                    <option value="0">待审核</option>
                                    <option value="2">审核通过</option>
                                    <option value="1">未通过</option>
                                </select>
                            </div>
                            <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">搜索</button>
                            <a href="<?php echo url('nows'); ?>" class="layui-btn">显示全部</a>
                        </form>
                    </div> -->
                    <table class="layui-table" id="list" lay-filter="list"></table>
                </div>
            </div>
        </div>
    </div>
</div>



    <!--js结束-->
    
<script>
    layui.use(['table', 'form'], function () {
        var table = layui.table, form = layui.form, $ = layui.jquery;
        var tableIn = table.render({
            id: 'user',
            elem: '#list',
            url: '<?php echo url(""); ?>',
            method: 'post',
            page: true,
            cols: [[
                { field: 'settlementNo', title: '结算单号', width: 80 },
                { field: 'name', title: '申请店铺', width: 150 },
                { field: 'settlementMoney', title: '结算金额', width: 80 },
                { field: 'backMoney', title: '返还金额', width: 100 },
                { field: 'createTime', title: '申请时间', width: 200 },
                { field: 'settlementStatus', title: '状态', width: 100 ,templet:'#status'},                
                { width: 160, align: 'center', toolbar: '#action', title: '操作' }
            ]],
            limit: 10 //每页默认显示的数量
        });
        table.on('tool(list)', function (obj) {
            var data = obj.data;
            if (obj.event === 'agree') {
                layer.confirm('您确定同意该请求吗？', function (index) {
                    var loading = layer.load(1, { shade: [0.1, '#fff'] });
                    $.post("<?php echo url('dosettlements'); ?>", { id: data.settlementId }, function (res) {
                        layer.close(loading);
                        if (res.code === 1) {
                            layer.msg(res.msg, { time: 1000, icon: 1 });
                            tableIn.reload();
                        } else {
                            layer.msg(res.msg, { time: 1000, icon: 2 });
                        }
                    });
                    layer.close(index);
                });
            }      
        });
        // form.on('submit(submit)', function (data) {
        //    var key =data.field.key;
        //    var status=data.field.status;
        //    tableIn.reload({page:{page:1},where:{key:key,status:status}});
        // })

    });
</script>
<script type="text/html" id="action">
{{# if(d.settlementStatus==0){ }}
    <a class="layui-btn layui-btn-xs" lay-event="agree">同意</a>   
{{# } }}    
</script>
<script type="text/html" id="status">
    {{# if(d.settlementStatus==0){ }}
        <span style="color:#31c15a">未结算</span>
    {{# }else{}}
        <span style="color:#31c15a">已结算</span>
    {{# }}}    
    </script>



</body>

</html>