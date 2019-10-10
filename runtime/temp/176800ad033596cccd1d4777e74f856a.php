<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:80:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\shop\uncheck.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1570615895;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
    <div class="x-nav">          <span class="layui-breadcrumb">            <a href="">首页</a>            <a href="">商家管理</a>            <a>              <cite>待审核商家列表</cite></a>          </span>    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a></div><div class="layui-fluid">    <div class="layui-row layui-col-space15">        <div class="layui-col-md12">            <div class="layui-card">                <div class="layui-card-body ">                    <div class="layui-inline layui-show-xs-block">                        <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">                    </div>                    <div class="layui-inline layui-show-xs-block">                        <button class="layui-btn" id="search" data-type="reload" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>                    </div>                </div>                <div class="layui-card-header">                    <button type="button" class="layui-btn layui-btn-danger" id="delAll"><i class="layui-icon"></i>批量删除</button>                    <a href="<?php echo url('add',array('catid'=>input('catid'))); ?>" class="layui-btn"><i class="layui-icon"></i><?php echo lang('add'); ?></a>                </div>                <div class="layui-card-body layui-table-body layui-table-main">                    <table class="layui-table" id="list" lay-filter="list"></table>                </div>            </div>        </div>    </div></div>    <div id="myverify" style="display: none;margin-top: 20px;">        <form class="layui-form" action="">            <div class="layui-form-item layui-form-text">                <label class="layui-form-label">审核原因</label>                <div class="layui-input-block" style="margin-right: 30px;">                    <textarea style="resize: none;" id="verify_reason" name="verify_reason" placeholder="请输入审核原因" class="layui-textarea"></textarea>                </div>            </div>        </form>    </div>


    <!--js结束-->
    <script type="text/javascript">    layui.use(['table','form','layer'], function() {        var table = layui.table,            $ = layui.jquery,            form = layui.form,            layer = layui.layer;        var tableIn = table.render({            id: 'content',            elem: '#list',            url: '<?php echo url("admin/shop/uncheck"); ?>',            where:{catid:'<?php echo input("catid"); ?>'},            method: 'post',            toolbar: '#topBtn',            page: true,            cols: [[                {type: "checkbox", fixed: true},                {field: 'id', title: '<?php echo lang("id"); ?>', width: 80, fixed: true},                {field: 'name',  title: '商家名称', width: 120,templet: '#name'},                {field: 'phone', title: '电话', width:120},                {field: 'pastdue',  title: '服务到期时间', width: 120},                {field: 'sort', align: 'center', title: '<?php echo lang("order"); ?>', width: 120, templet: '#order'},                {width: 160, align: 'center', toolbar: '#verify',title:'审核'},                {width: 160, align: 'center', toolbar: '#action',title:'操作'}            ]],            limit: 10        });        form.on('switch(status)', function(obj){            loading =layer.load(1, {shade: [0.1,'#fff']});            var id = this.value;            var status = obj.elem.checked===true?1:0;            $.post('<?php echo url("shopState"); ?>',{'id':id,'status':status},function (res) {                layer.close(loading);                if (res.code==1) {                    tableIn.reload();                }else{                    layer.msg(res.msg,{time:1000,icon:2});                    return false;                }            })        });        $('#search').on('click', function () {            var key = $('#key').val();            if ($.trim(key) === '') {                layer.msg('<?php echo lang("pleaseEnter"); ?>关键字！', {icon: 0});                return;            }            tableIn.reload({ page: {page: 1}, where: {key: key,catid:'<?php echo input("catid"); ?>'} });        });        $('body').on('blur','.list_order',function() {            var id = $(this).attr('data-id');            var sort = $(this).val();            var loading = layer.load(1, {shade: [0.1, '#fff']});            $.post('<?php echo url("listorder"); ?>',{id:id,sort:sort},function(res){                layer.close(loading);                if(res.code === 1){                    layer.msg(res.msg, {time: 1000, icon: 1}, function () {                        location.href = res.url;                    });                }else{                    layer.msg(res.msg,{time:1000,icon:2});                }            })        });        table.on('tool(list)', function(obj) {            var data = obj.data;            if(obj.event === 'del'){                layer.confirm('您确定要删除该内容吗？', function(index){                    var loading = layer.load(1, {shade: [0.1, '#fff']});                    $.post("<?php echo url('listDel'); ?>",{id:data.id},function(res){                        layer.close(loading);                        if(res.code===1){                            layer.msg(res.msg,{time:1000,icon:1});                            tableIn.reload({where:{catid:'<?php echo input("catid"); ?>'}});                        }else{                            layer.msg('操作失败！',{time:1000,icon:2});                        }                    });                    layer.close(index);                });            }            //审核原因            if(obj.event==='verify'){                var id = obj.data.id;                layer.open({                    title:'商家审核原因'                    ,skin: 'demo-class'                    ,area: ['300px', '250px']                    ,btn: ['审核通过', '审核失败']                    ,yes: function(index, layero){                        //状态  1 审核中   2 审核通过  3  审核失败                        var status = 2;                        var verify_reason = $('#verify_reason').val();                        $.ajax({                            url:"<?php echo url('admin/shop/verify'); ?>",                            type:'post',                            data:{"id":id,"status":status,"verify_reason":verify_reason},                            success:function(res){                            }                        })                        location.href = "<?php echo url('admin/shop/uncheck'); ?>";                        layer.close(index);                        //layer.close(index);                    }                    ,btn2: function(index, layero){                        var status = 3;                        var verify_reason = $('#verify_reason').val();                        $.ajax({                            url:"<?php echo url('admin/shop/verify'); ?>",                            type:'post',                            data:{"id":id,"status":status,"verify_reason":verify_reason},                            success:function(res){                                if(res.code==200){                                }                            }                        })                        location.href = "<?php echo url('admin/shop/uncheck'); ?>";                        layer.close(index);                    }                    ,type: 1,                    content: $('#myverify') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响                });            }            if(obj.event === 'nature'){                layer.open({                    type: 2,                    title: '商品属性',                    area: ['700px', '450px'],                    fixed: false, //不固定                    maxmin: true,                    content: ['details.html','no']                });            }        });        $('body').on('click','#delAll',function() {            layer.confirm('确认要删除选中的内容吗？', {icon: 3}, function(index) {                layer.close(index);                var checkStatus = table.checkStatus('content'); //content即为参数id设定的值                var ids = [];                $(checkStatus.data).each(function (i, o) {                    ids.push(o.id);                });                var loading = layer.load(1, {shade: [0.1, '#fff']});                $.post("<?php echo url('delAll'); ?>", {ids: ids,catid:'<?php echo input("catid"); ?>'}, function (data) {                    layer.close(loading);                    if (data.code === 1) {                        layer.msg(data.msg, {time: 1000, icon: 1});                        tableIn.reload({where:{catid:'<?php echo input("catid"); ?>'}});                    } else {                        layer.msg(data.msg, {time: 1000, icon: 2});                    }                });            });        })    });</script><script type="text/html" id="order">    <input name="{{d.id}}" data-id="{{d.id}}" class="list_order layui-input" value=" {{d.sort}}" size="10"/></script><script type="text/html" id="action">    {{# if(d.is_show==1){ }}    <a href="{{d.url}}" target="_blank" class="layui-btn layui-btn-xs layui-btn-normal">预览</a>    {{# } }}    <!-- <a class="layui-btn layui-btn-xs" lay-event="nature">属性</a> -->    <a href="<?php echo url('admin/shop/edit'); ?>?id={{d.id}}" class="layui-btn layui-btn-xs">编辑</a>    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>    <!-- <div>layui</div>    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> --></script><script type="text/html" id="verify">    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="verify" data-id="{{d.id}}">点击审核</a></script><script type="text/html" id="name">    {{d.name}}{{# if(d.name){ }}<img src="/static/admin/images/image.gif" onmouseover="layer.tips('<img width=300  src={{d.shoplogo}}>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();" >{{# } }}</script><!--上架|下架--><script type="text/html" id="status">    <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="上架|下架" lay-filter="status" {{ d.status == 1 ? 'checked' : '' }}></script>


</body>

</html>