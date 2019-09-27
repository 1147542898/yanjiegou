<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\sign\goods.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
        <div class="layui-btn-group">
            <button class="layui-btn layui-btn-danger" id="signgoods">添加参与签到的商品</button>
        </div>
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

                url: '<?php echo url("admin/sign/goods"); ?>',

                method: 'post',
                toolbar: '#topBtn',

                page: true,

                cols: [[

                    {type: "checkbox", fixed: true},
                    {field: 'id', title: '编号'},
                    {field: 'title', title: '商品名称'},
                    {field: 'price', title: '商品价格'},
                    {field: 'intro', title: '简介'},
                    {field: 'starttime', title: '开始时间'},
                    {field: 'stoptime', title: '截止时间'},
                    {field: 'joinnum', title: '可中奖的人数'}

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

        });


        $(function(){
            $('#signgoods').click(function () {
                layui.use(['table','form','util'], function() {
                    var table = layui.table, $ = layui.jquery,form = layui.form;util = layui.util;
                    var tableIn = table.render({
                        id: 'content',
                        elem: '#list',
                        url: '<?php echo url("admin/goods/index"); ?>',
                        method: 'post',
                        toolbar: '#box1',
                        page: true,
                        cols: [[
                            {type: "checkbox"},
                            {field: 'headimg', title: '商品图片', width: 80,  toolbar: '#pics',align:'center'},
                            {field: 'title', title: '商品名称', width:300},
                            {field: 'shopname', title: '所属商家', width:150,templet:function(d){if (d.shopname) {return d.shopname;} else {return '平台自营';}}},
                            {field: 'catname',  title: '商品分类', width: 120},
                            {field: 'sold',  title: '销量', width: 80},
                            {field: 'total',  title: '库存', width: 80},
                            {field: 'price',  title: '价格', width: 80},
                            {field: 'createtime', title: '<?php echo lang("add"); ?><?php echo lang("time"); ?>', width:100, templet:function(d){return util.toDateString(d.createtime*1000, "yyyy-MM-dd");}},
                        ]],
                        limit: 10
                    });
                    table.on('edit(list)', function(obj){
                        sttredit(obj.data.id,obj.field,obj.value);
                    });
                    form.on('switch(status)', function(obj){
                        loading =layer.load(1, {shade: [0.1,'#fff']});
                        var id = this.value;
                        var status = obj.elem.checked===true?1:0;
                        $.post('<?php echo url("SetStatus"); ?>',{'id':id,'status':status},function (res) {
                            if (res.code==1) {
                                layer.close(loading);
                                tableIn.reload({where:{way:'<?php echo input("way"); ?>'}});
                            }else{
                                layer.msg(res.msg,{time:1000,icon:2});
                                return false;
                            }
                        })
                    });
                    $('#search').on('click', function () {
                        var key = $('#key').val();
                        if ($.trim(key) === '') {
                            layer.msg('<?php echo lang("pleaseEnter"); ?>关键字！', {icon: 0});
                            return;
                        }
                        tableIn.reload({ page: {page: 1}, where: {key: key,catid:'<?php echo input("catid"); ?>'} });
                    });
                    $('body').on('blur','.list_order',function() {
                        var id = $(this).attr('data-id');
                        var sort = $(this).val();
                        var loading = layer.load(1, {shade: [0.1, '#fff']});
                        $.post('<?php echo url("listorder"); ?>',{id:id,sort:sort,catid:'<?php echo input("catid"); ?>'},function(res){
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


                    table.on('toolbar(list)', function(obj){
                        switch(obj.event){
                            case 'box1':
                                var checkStatus = table.checkStatus('content'); //content即为参数id设定的值

                                var ids = [];

                                $(checkStatus.data).each(function (i, o) {

                                    ids.push(o.id);

                                });
                                if(ids==''){
                                    layer.msg('请选择相关商品！', {time: 1000, icon: 2});
                                    return false;
                                }
                                var ids = ids.join(",");
                                var url = "<?php echo url('admin/sign/signgoods'); ?>";
                                location.href = url+'?ids='+ids;

                                break;
                        };
                    });



                });

            });




        });

    </script>


<script type="text/html" id="box1">

    <a href="javascript:void(0);" class="layui-btn layui-btn-sm" lay-event="box1">请选择签到的商品</a>

</script>

<script type="text/html" id="topBtn">
    <button type="button" class="layui-btn layui-btn-danger layui-btn-sm" id="delAll">批量删除</button>
</script>




</body>

</html>

