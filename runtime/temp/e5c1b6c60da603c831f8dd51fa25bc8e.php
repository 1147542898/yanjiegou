<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:86:"/www/wwwroot/svn.yanjiegou.com/public/../application/admin/view/information/index.html";i:1561105812;s:72:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/common.html";i:1561105812;s:68:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/js.html";i:1562165964;}*/ ?>
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
    
    <style type="text/css">
        #mytab{
            margin-top: 20px;
        }
        .layui-tab-title .layui-this{
            color: red;
        }

    </style>


</head>
<body>

<div class="layui-fluid">
    <div class="layui-row">
        <div class="layui-col-md12">

            <div class="layui-btn-group">
                <button class="layui-btn layui-btn-danger information" data-type="7">发送系统消息</button>
                <button class="layui-btn information" data-type="6">发送全商圈消息</button>
                <button class="layui-btn information" data-type="4">发送全商家消息</button>
                <button class="layui-btn information" data-type="2">发送全用户消息</button>
                <button class="layui-btn information" data-type="1">发送指定用户消息</button>
                <button class="layui-btn information" data-type="3">发送指定商家消息</button>
                <button class="layui-btn information" data-type="5">发送指定商圈消息</button>
            </div>
            <div>
                <!--消息类型，1 指定用户消息  2 全用户消息  3 指定商家消息   4 全商家消息    5 指定商圈消息  6 全商圈消息   7 总消息(系统消息)，商家 商圈 用户都能收到-->
                <ul class="layui-tab-title" id="mytab">
                    <li class="layui-this" data-type="7">系统消息</li>
                    <li data-type="6">全商圈消息</li>
                    <li data-type="5">指定商圈消息</li>
                    <li data-type="4">全商家消息</li>
                    <li data-type="3">指定商家消息</li>
                    <li data-type="2">全用户消息</li>
                    <li data-type="1">指定用户消息</li>
                </ul>
            </div>
            <div class="layui-card">
                <table class="layui-table" id="list" lay-filter="list"></table>
            </div>



        </div>
    </div>
</div>





<!--js结束-->

    <script type="text/javascript">
        var type_id;
        $('ul#mytab li').click(function(){
            type_id = $(this).attr('data-type');

            layui.use(['table','form'], function() {
                type_id = type_id;

                var table = layui.table, $ = layui.jquery, form = layui.form;

                var tableIn = table.render({

                    id: 'content',

                    elem: '#list',

                    url: '<?php echo url("admin/information/index"); ?>',
                    where:{type_id:type_id},

                    method: 'post',
                    toolbar: '#topBtn',

                    page: true,

                    cols: [[

                        {type: "checkbox", fixed: true},

                        {field: 'id', title: '消息编号'},

                        {field: 'title', title: '标题'},
                        {field: 'recevier', title: '消息接收者'},

                        {field: 'content', title: '内容'},

                        {field: 'add_time', title: '发送时间'},
                        {field: 'type_id', title: '消息类型'}

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

            })

//            $.post("<?php echo url('admin/information/index'); ?>", {type_id: type_id}, function (data) {
//
//
//            });

        });



        layui.use(['table','form'], function() {

            var table = layui.table, $ = layui.jquery, form = layui.form;

            var tableIn = table.render({

                id: 'content',

                elem: '#list',

                url: '<?php echo url("admin/information/index"); ?>',

                method: 'post',
                toolbar: '#topBtn',
                page: true,

                cols: [[

                    {type: "checkbox", fixed: true},

                    {field: 'id', title: '消息编号'},

                    {field: 'title', title: '标题'},
                    {field: 'recevier', title: '消息接收者'},

                    {field: 'content', title: '内容'},

                    {field: 'add_time', title: '发送时间'},
                    {field: 'type_id', title: '消息类型'}

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

        })



        $(function(){
            //type_id   消息类型，1 指定用户消息  2 全用户消息  3 指定商家消息   4 全商家消息    5 指定商圈消息  6 全商圈消息   7 总消息，商家 商圈 用户都能收到
            $('.information').click(function () {
                $(this).addClass('layui-btn-danger').siblings().removeClass('layui-btn-danger');
                var type_id = $(this).attr('data-type');
                if(type_id=='1'){
                    $(this).text("选择指定用户发送")
                    layui.use(['table','form'], function() {

                        var table = layui.table, form = layui.form, $ = layui.jquery;

                        var tableIn = table.render({

                            id: 'content',

                            elem: '#list',

                            url: '<?php echo url("admin/users/index"); ?>',

                            method: 'post',

                            toolbar: '#box1',

                            page: true,

                            cols: [[

                                {checkbox: true, fixed: true},

                                {field: 'id', title: '<?php echo lang("id"); ?>', width: 80, fixed: true},

                                {field: 'username', title: '<?php echo lang("nickname"); ?>', width: 120},

                                {field: 'level_name', title: '会员等级', width: 100},

                                {field: 'email', title: '<?php echo lang("email"); ?>', width: 250, templet: '#email'},

                                {field: 'mobile', title: '<?php echo lang("tel"); ?>', width: 150, hide: true},

                                {field: 'sex', title: '性别', width: 80, templet: '#sex', hide: true},

                                {field: 'reg_time', title: '注册时间', width: 150},

                                {width: 160, align: 'center', toolbar: '#action'}

                            ]],

                            limit: 10 //每页默认显示的数量


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
                                        layer.msg('请选择要发送的！', {time: 1000, icon: 2});
                                        return false;
                                    }
                                    var user_ids = ids.join(",");
                                    var url = "<?php echo url('admin/information/send'); ?>";
                                    location.href = url+'?type_id='+type_id+'&user_ids='+user_ids;
                                    break;
                            };
                        });


                    });





                }else if(type_id=='3'){
                    //3 指定商家消息
                    layui.use(['table','form'], function() {

                        var table = layui.table, $ = layui.jquery, form = layui.form;

                        var tableIn = table.render({

                            id: 'content',

                            elem: '#list',

                            url: '<?php echo url("admin/shop/index"); ?>',

                            where: {catid: '<?php echo input("catid"); ?>'},

                            method: 'post',

                            toolbar: '#box3',

                            page: true,

                            cols: [[

                                {type: "checkbox", fixed: true},

                                {field: 'id', title: '<?php echo lang("id"); ?>', width: 80, fixed: true},

                                {field: 'name', title: '商家名称', width: 120, templet: '#name'},

                                {field: 'phone', title: '电话', width: 120},

                                {field: 'pastdue', title: '服务到期时间', width: 120},


                                {
                                    field: 'sort',
                                    align: 'center',
                                    title: '<?php echo lang("order"); ?>',
                                    width: 120,
                                    templet: '#order'
                                },

                                {field: 'status', align: 'center', title: '状态', width: 120, toolbar: '#status'},

                                {width: 160, align: 'center', toolbar: '#action', title: '操作'}

                            ]],

                            limit: 10

                        });

                        table.on('toolbar(list)', function(obj){
                            switch(obj.event){
                                case 'box3':
                                    var checkStatus = table.checkStatus('content'); //content即为参数id设定的值

                                    var ids = [];

                                    $(checkStatus.data).each(function (i, o) {

                                        ids.push(o.id);

                                    });
                                    if(ids==''){
                                        layer.msg('请选择要发送的！', {time: 1000, icon: 2});
                                        return false;
                                    }
                                    var ids = ids.join(",");
                                    var url = "<?php echo url('admin/information/send'); ?>";
                                    location.href = url+'?type_id='+type_id+'&ids='+ids;

                                    break;
                            };
                        });

                    })

                }else if(type_id=='5'){
                    //3 指定商家消息
                    layui.use(['table','form'], function() {

                        var table = layui.table, $ = layui.jquery, form = layui.form;

                        var tableIn = table.render({

                            id: 'content',

                            elem: '#list',

                            url: '<?php echo url("admin/bigshop/index"); ?>',

                            where: {catid: '<?php echo input("catid"); ?>'},

                            method: 'post',

                            toolbar: '#box5',

                            page: true,

                            cols: [[

                                {type: "checkbox", fixed: true},

                                {field: 'id', title: '<?php echo lang("id"); ?>', width: 80, fixed: true},

                                {field: 'name',  title: '商圈名称', width: 120,templet: '#name'},

                                {field: 'phone', title: '电话', width:120},

                                {field: 'pastdue',  title: '服务到期时间', width: 120},


                                {field: 'sort', align: 'center', title: '<?php echo lang("order"); ?>', width: 120, templet: '#order'},

                                {field: 'myaddress', align: 'center', title: '地址', width: 120},


                            ]],

                            limit: 10

                        });

                        table.on('toolbar(list)', function(obj){
                            switch(obj.event){
                                case 'box5':
                                    var checkStatus = table.checkStatus('content'); //content即为参数id设定的值

                                    var ids = [];

                                    $(checkStatus.data).each(function (i, o) {

                                        ids.push(o.id);

                                    });
                                    if(ids==''){
                                        layer.msg('请选择要发送的！', {time: 1000, icon: 2});
                                        return false;
                                    }
                                    var ids = ids.join(",");
                                    var url = "<?php echo url('admin/information/send'); ?>";
                                    location.href = url+'?type_id='+type_id+'&ids='+ids;
                                    break;
                            };
                        });

                    })

                }else{
                    var url = "<?php echo url('admin/information/send'); ?>";
                    location.href = url+'?type_id='+type_id;
                }

            });




        });

    </script>


    <script type="text/html" id="box1">

        <a href="javascript:void(0);" class="layui-btn layui-btn-sm" lay-event="box1">请选择指定用户发送消息</a>

    </script>


<script type="text/html" id="box3">

    <a href="javascript:void(0);" class="layui-btn layui-btn-sm" lay-event="box3">请选择指定商家发送消息</a>

</script>

<script type="text/html" id="box5">

    <a href="javascript:void(0);" class="layui-btn layui-btn-sm" lay-event="box5">请选择指定商圈发送消息</a>

</script>

<script type="text/html" id="topBtn">
    <button type="button" class="layui-btn layui-btn-danger layui-btn-sm" id="delAll">批量删除</button>
</script>



</body>

</html>

