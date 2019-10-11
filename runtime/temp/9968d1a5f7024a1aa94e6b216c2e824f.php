<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:84:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\users\user_group.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1570755897;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
    <div class="layui-fluid"><div class="layui-row layui-col-space15"><div class="layui-col-md12"><div class="layui-card"><div class="layui-card-body">    <fieldset class="layui-elem-field layui-field-title">        <legend>会员组<?php echo lang('list'); ?></legend>    </fieldset>    <blockquote class="layui-elem-quote">        <a href="<?php echo url('groupAdd'); ?>" class="layui-btn layui-btn-sm">            <?php echo lang('add'); ?>会员组        </a>    </blockquote>    <table class="layui-table" id="list" lay-filter="list"></table></div></div></div></div></div>


    <!--js结束-->
    <script type="text/javascript">    layui.use('table', function() {        var table = layui.table, $ = layui.jquery;        table.render({            id: 'user',            elem: '#list',            url: '<?php echo url("userGroup"); ?>',            method: 'post',            cols: [[                {field: 'level_id', title: '<?php echo lang("id"); ?>', width: 80, fixed: true, sort: true},                {field: 'level_name', title: '名称', width: 120},                {field: 'bomlimit', title: '满足积分条件', width: 150,templet:'#bom'},                {field: 'sort',align: 'center',title: '<?php echo lang("order"); ?>', width: 120,templet:'#sort',sort: true},                {width: 160, align: 'center', toolbar: '#action'}            ]]        });        table.on('tool(list)', function(obj){            var data = obj.data;            if(obj.event === 'del'){                layer.confirm('您确定要删除该记录吗？', function(index){                    var loading = layer.load(1, {shade: [0.1, '#fff']});                    $.post("<?php echo url('groupDel'); ?>",{level_id:data.level_id},function(res){                        layer.close(loading);                        if(res.code==1){                            layer.msg(res.msg,{time:1000,icon:1});                            obj.del();                        }else{                            layer.msg(res.msg,{time:1000,icon:2});                        }                    });                    layer.close(index);                });            }        });        $('body').on('blur','.list_order',function() {            var level_id = $(this).attr('data-id');            var sort = $(this).val();            $.post('<?php echo url("groupOrder"); ?>',{level_id:level_id,sort:sort},function(res){                if(res.code==1){                    layer.msg(res.msg,{time:1000,icon:1},function(){                        location.href = res.url;                    });                }else{                    layer.msg(res.msg,{time:1000,icon:2});                }            })        })    });</script><script type="text/html" id="bom">    {{d.bomlimit}}-{{d.toplimit}}</script><script type="text/html" id="sort">    <input name="{{d.level_id}}" data-id="{{d.level_id}}" class="list_order layui-input" value=" {{d.sort}}" size="10"/></script><script type="text/html" id="action">    <a href="<?php echo url('groupEdit'); ?>?level_id={{d.level_id}}" class="layui-btn layui-btn-xs"><?php echo lang('edit'); ?></a>    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><?php echo lang('del'); ?></a></script>


</body>

</html>