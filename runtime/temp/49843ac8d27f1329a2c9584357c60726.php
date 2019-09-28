<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:82:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\evaluate\index.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
        <div class="layui-card-body ">

            <table id="order"></table>
        </div>

    </div>
</div>




<!--js结束-->

<script>
    layui.use(['table','form'], function() {
        var table = layui.table, form = layui.form, $ = layui.jquery;
        var tableIn = table.render({
            elem: '#order'
            ,url: "<?php echo url('admin/evaluate/index'); ?>" //数据接口
            ,page: true //开启分页
            ,cols: [[ //表头
                {field: 'id', title: '评论ID', sort: true, fixed: 'left'}
                ,{field: 'gtitle', title: '商品'}
                ,{field: 'umobile', title: '评论者'}
                ,{field: 'sname', title: '商家'}
                ,{field: 'add_time', title: '评论时间'}
                ,{field: 'is_show', align: 'center', title: '是否显示', width: 100, toolbar: '#open'},
                ,{width: 160,title:'操作', toolbar: '#action'}
            ]]
        });

        $('#search').on('click', function () {

            var key = $('#key').val();


            var paid = $('#paid').val();

//            if ($.trim(key) === '') {
//
//                layer.msg('<?php echo lang("pleaseEnter"); ?>关键字！', {icon: 0});
//
//                return;
//
//            }

            tableIn.reload({ page: {page: 1}, where: {key: key,paid:paid} });

        });

        form.on('switch(open)', function (obj) {
            loading = layer.load(1, {shade: [0.1, '#fff']});
            var id = this.value;
            var is_show = obj.elem.checked === true ? 1 : 0;
            $.post('<?php echo url("editState"); ?>', {'id': id, 'is_show': is_show}, function (res) {
                layer.close(loading);
                if (res.status == 1) {
                    tableIn.reload();
                } else {
                    layer.msg(res.msg, {time: 1000, icon: 2});
                    return false;
                }
            })
        });

        form.on('submit(sreach)', function(data){

            return false;
        });


    });
</script>


<script type="text/html" id="action">

    <a href="<?php echo url('admin/evaluate/see'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs">查看</a>

</script>

<script type="text/html" id="open">
    <input type="checkbox" name="is_show" value="{{d.id}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="open" {{ d.is_show == 1 ? 'checked' : '' }}>
</script>



</body>

</html>

