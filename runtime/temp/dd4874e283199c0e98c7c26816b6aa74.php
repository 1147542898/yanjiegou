<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\goods\index.html";i:1569466684;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
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
    
<style type="text/css">
    .layui-table-body tr{height:50px;}
    .layui-table-body td .laytable-cell-1-0-2{padding: 0;margin:0;height:50px;}
    .layui-table td,.layui-table th{padding:0;}
</style>


</head>
<body>

<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-body">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>商品列表</legend>
    </fieldset>
    <div class="demoTable">
        <div class="layui-inline">
            <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">
        </div>
        <button class="layui-btn" id="search" data-type="reload"><?php echo lang('search'); ?></button>
        <a href="<?php echo url('index',['catid'=>input('catid')]); ?>" class="layui-btn">显示全部</a>
        <div style="clear: both;"></div>
    </div>
    <table class="layui-table" id="list" lay-filter="list" lay-skin="row"></table>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script type="text/html" id="order">
    <input name="{{d.id}}" data-id="{{d.id}}" class="list_order layui-input" value=" {{d.sort}}" size="10"/>
</script>
<script type="text/html" id="title">
   {{d.title}}{{# if(d.title){ }}<img src="/static/admin/images/image.gif" onmouseover="layer.tips('<img src={{d.thumb}}>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();" >{{# } }}
</script>
<script type="text/html" id="action">
    <a class="green" href="{{d.url}}" target="_blank"  title="预览">预览</a>
    <a class="green" href="<?php echo url('edit'); ?>?id={{d.id}}&catid={{d.catid}}" title="编辑">编辑</a>
    <a class="red" lay-event="del" title="删除">删除</a>
</script>
<script type="text/html" id="pics">
    <img style="cursor: pointer; width: 50px;height:50px;" lay-event='open_image' src="{{d.headimg}}">
</script>
<script type="text/html" id="sttr">
    <a href="javascript:;" data-id="{{d.id}}" data-sttr="isnew" data-val="{{d.isnew}}" class="{{# if(d.isnew){ }}red{{# } }} do_sttr">新品</a> 
    <a href="javascript:;" data-id="{{d.id}}" data-sttr="ishot" data-val="{{d.ishot}}" class="{{# if(d.ishot){ }}red{{# } }} do_sttr">热卖</a> 
    <a href="javascript:;" data-id="{{d.id}}" data-sttr="isrecommand" data-val="{{d.isrecommand}}" class="{{# if(d.isrecommand){ }}red{{# } }} do_sttr">推荐</a> 
    <!-- <a href="javascript:;" data-id="{{d.id}}" data-sttr="isdiscount" data-val="{{d.isdiscount}}" class="{{# if(d.isdiscount){ }}red{{# } }} do_sttr">促销</a>  -->
    <a href="javascript:;" data-id="{{d.id}}" data-sttr="isqc" data-val="{{d.isqc}}" class="{{# if(d.isqc){ }}red{{# } }} do_sttr">清仓</a> 
    <a href="javascript:;" data-id="{{d.id}}" data-sttr="istj" data-val="{{d.istj}}" class="{{# if(d.istj){ }}red{{# } }} do_sttr">特价</a>
    <!-- <a href="javascript:;" data-id="{{d.id}}" data-sttr="issendfree" data-val="{{d.issendfree}}" class="{{# if(d.issendfree){ }}red{{# } }} do_sttr">包邮</a> 
    <a href="javascript:;" data-id="{{d.id}}" data-sttr="notiscount" data-val="{{d.notiscount}}" class="{{# if(d.notiscount){ }}red{{# } }} do_sttr">不参与折扣</a> -->
</script>
 <!--上架|下架-->
<script type="text/html" id="status">
    <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="上架|下架" lay-filter="status" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="topBtn">
    <?php if((input('way') == 1)): ?><button type="button" class="layui-btn layui-btn-danger" id="downAll">批量下架</button><?php endif; if((input('way') == 4)): ?><button type="button" class="layui-btn" id="upAll">批量上架</button><?php endif; ?>
    <a href="<?php echo url('add'); ?>" class="layui-btn"><?php echo lang('add'); ?></a>
    <button type="button" class="layui-btn layui-btn-danger" id="delAll">批量删除</button>
</script>
<script>
    layui.use(['table','form','util'], function() {
        var table = layui.table, $ = layui.jquery,form = layui.form;util = layui.util;
        var tableIn = table.render({
            id: 'content',
            elem: '#list',
            url: '<?php echo url("index"); ?>',
            where:{way:'<?php echo input("way"); ?>'},
            method: 'post',
            toolbar: '#topBtn',
            page: true,
            cols: [[
                {type: "checkbox"},
                {field: 'sorts', title: '<?php echo lang("order"); ?>', width: 40, edit: 'text',align:'center'},
                {field: 'headimg', title: '商品图片', width: 80,  toolbar: '#pics',align:'center'},
                {field: 'title', title: '商品名称', edit: 'text'},
               {field: 'shopname', title: '所属商家', width:150,templet:function(d){if (d.shopname) {return d.shopname;} else {return '平台自营';}}},
                {field: 'catname',  title: '商品分类', width: 120},
                {field: 'sold',  title: '销量', width: 80, edit: 'text'},
                {field: 'total',  title: '库存', width: 80, edit: 'text'},
                {field: 'price',  title: '价格', width: 80, edit: 'text'},
                {title: '属性',toolbar: '#sttr',width:250},
                {field: 'createtime', title: '<?php echo lang("add"); ?><?php echo lang("time"); ?>', width:100, templet:function(d){return util.toDateString(d.createtime*1000, "yyyy-MM-dd");}},
                {field: 'status', align: 'center', title: '上下架', width: 120, toolbar: '#status'},
                {align: 'left', toolbar: '#action',title:'操作'}
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
                    layer.msg(res.msg,{time:1000,icon:1});
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
        $('body').on('click','.do_sttr',function() {
            var id=$(this).data('id');
            var sttr=$(this).data('sttr');
            var val=$(this).data('val');
            val=val?0:1;
            sttredit(id,sttr,val);
        });
        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('您确定要删除该内容吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('listDel'); ?>",{id:data.id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload({where:{way:'<?php echo input("way"); ?>'}});
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
        });
        $('body').on('click','#delAll',function() {
            layer.confirm('确认要删除选中的商品吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('content'); //content即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('delAll'); ?>", {ids: ids}, function (data) {
                    if (data.code === 1) {
                        layer.close(loading);
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn.reload({where:{way:'<?php echo input("way"); ?>'}});
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })
        $('body').on('click','#downAll',function() {
            layer.confirm('确认要下架选中的商品吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('content'); //content即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('SetStatus'); ?>", {id: ids,status:0}, function (data) {
                    if (data.code === 1) {
                        layer.close(loading);
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn.reload({where:{way:'<?php echo input("way"); ?>'}});
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })
        $('body').on('click','#upAll',function() {
            layer.confirm('确认要上架选中的商品吗？', {icon: 3}, function(index) {
                layer.close(index);
                var checkStatus = table.checkStatus('content'); //content即为参数id设定的值
                var ids = [];
                $(checkStatus.data).each(function (i, o) {
                    ids.push(o.id);
                });
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url('SetStatus'); ?>", {id: ids,status:1}, function (data) {
                    if (data.code === 1) {
                        layer.close(loading);
                        layer.msg(data.msg, {time: 1000, icon: 1});
                        tableIn.reload({where:{way:'<?php echo input("way"); ?>'}});
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 2});
                    }
                });
            });
        })
        function sttredit(id,sttr,val){
            loading =layer.load(1, {shade: [0.1,'#fff']});
            $.post('<?php echo url("sttredit"); ?>',{'sttr':sttr,'val':val,'id':id},function (res) {
                if (res.code==1) {
                    layer.msg(res.msg,{time:1000,icon:1},function(){
                        layer.close(loading);
                        tableIn.reload({where:{way:'<?php echo input("way"); ?>'}});
                    });
                    
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                    return false;
                }
            })
        }
    });
</script>



</body>

</html>
