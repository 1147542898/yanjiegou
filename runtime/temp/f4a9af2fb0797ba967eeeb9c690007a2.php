<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\sign\log.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
        <div class="layui-row">
            <div class="layui-card">
                <table class="layui-table" id="list" lay-filter="list"></table>
            </div>
        </div>
    </div>



<!--js结束-->

<script type="text/javascript">
    layui.use(['table','form'], function() {

        var table = layui.table, $ = layui.jquery, form = layui.form;

        var tableIn = table.render({

            id: 'content',

            elem: '#list',

            url: '<?php echo url("admin/sign/log"); ?>',

            method: 'post',
            toolbar: '#topBtn',

            page: true,

            cols: [[

                {type: "checkbox", fixed: true},
                {field: 'id', title: '编号'},
                {field: 'mobile', title: '手机号'},
                {field: 'add_time', title: '签到时间'},
                {field: 'code', title: '签到码'},
                {field: 'winstatus', title: '是否中奖'},
                {field: 'code_source', title: '签到码来源'},
                {align: 'center', toolbar: '#action'}

            ]],

            limit: 10

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
                    if(data.code===1) {
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn.reload();
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })



        table.on('tool(list)', function(obj) {
            var data = obj.data;
           var signlog_id = data.id;
            if (obj.event === 'setprize') {
                layui.use(['table','form'], function() {

                    var table = layui.table, $ = layui.jquery, form = layui.form;

                    var tableIn = table.render({

                        id: 'content',

                        elem: '#list',

                        url: '<?php echo url("admin/sign/goods"); ?>',

                        method: 'post',
                        toolbar: '#topBtn',

                        page: true,

                        cols: [[
                            {field: 'id', title: '编号'},
                            {field: 'title', title: '商品名称'},
                            {field: 'price', title: '商品价格'},
                            {field: 'intro', title: '简介'},
                            {field: 'starttime', title: '开始时间'},
                            {field: 'stoptime', title: '截止时间'},
                            {field: 'joinnum', title: '可中奖的人数'},
                            {width: 160, align: 'center', toolbar: '#mygoods'}

                        ]],

                        limit: 10

                    });

                    table.on('tool(list)', function(obj) {

                        var data = obj.data;
                        if (obj.event === 'prizegoods'){
                            layer.confirm('您确定要设置该商品中奖吗？', function(index){
                                var loading = layer.load(1, {shade: [0.1, '#fff']});
                                $.post("<?php echo url('setprize'); ?>",{id:data.id,goods_id:data.goods_id,signlog_id:signlog_id},function(res){
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


            }
        });



    });



</script>


<script type="text/html" id="action">
    <a href="javascript:void(0);" class="layui-btn layui-btn-xs" lay-event="setprize">设置中奖</a>
</script>

<script type="text/html" id="mygoods">
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="prizegoods">设置</a>
</script>




</body>

</html>

