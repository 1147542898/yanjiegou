<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:80:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\module\index.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1570615895;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
        <legend>图片规则列表</legend>
    </fieldset>
	<table class="layui-hide layui-table" lay-filter="modify"></table>
</div>
</div>
</div>
</div>
</div>



    <!--js结束-->
    
<script type="text/html" id="topBtn">
  <a href="<?php echo url('add'); ?>" lay-text="新增图片规则" class="layui-btn"><i class="layui-icon">&#xe654;</i>新增图片规则</a>
  <button class="layui-btn cms-refresh"><i class="layui-icon">&#xe669;</i></button>
</script>
<script type="text/html" id="table-tpl-status">
	<input type="checkbox" name="status" value="{{ d.id }}" {{ d.status == 9 ? 'checked' : '' }} title="已启用" lay-filter="table-status">
</script>
<script type="text/html" id="table-tpl-operation">
	<a href="<?php echo url('edit'); ?>?id={{ d.id }}" lay-text="信息编辑" class="layui-btn layui-btn-normal layui-btn-sm" data-title="编辑信息" >编辑</a>
	<a href="#" data-href="<?php echo url('delete'); ?>?id={{ d.id }}" class="layui-btn layui-btn-sm layui-bg-red layui-delete">删除</a>
</script>
<script type="text/javascript">
var urlApiField = "<?php echo url('field'); ?>";

layui.use(['table','util','form'],function(){
	var table = layui.table,
		form = layui.form,
		util = layui.util;
	var tableIns = table.render({
		elem: '.layui-table',
		url: "<?php echo url('data'); ?>", //数据接口
		method: 'post',
        toolbar: '#topBtn',
		text: '暂无数据',
		page: true, //开启分页
		cols:[[ 
			{ field: 'id', title: 'ID', width:10 },
			{ field: 'moduleid', title: '模型编号', width:90 },			
			{ field: 'modulename', title: '模型名称', width:90 },
			{ field: 'moduleapp', title: '控制器名', width:90 },
			{ field: 'uploadcatalog', title: '上传目录', width:90 },
			{ field: 'uploadformatimage', title: '上传目录规则', width:400 },
			{ field: 'compresswidth', title: '最大图宽', width:90 },
			{ field: 'compressheight', title: '最大图高', width:90 },
			{ field: 'markopenname', title: '水印位置', width:90 },
			{ field: 'thumbname', title: '缩略图', width:90 },	
			{ field: 'status', title: '状态', width:120,  templet:"#table-tpl-status" },
			{ title: '操作', width:180,  templet:'#table-tpl-operation' },
		]],
	});
	//监听编辑事件
	table.on('edit(modify)', function(o){ 
		$.post(urlApiField,{ 'id':o.data.id, 'fieldname':o.field, 'value':o.value },function(res){
			if(res.status == 'error'){
				layer.msg(res.message);
			}
		},'json');
	});
	//监听锁定操作
    form.on('checkbox(table-status)', function(data){
		var value = data.elem.checked == true ? 9 : 0 ;
		$.post(urlApiField,{ 'id':data.value, 'fieldname':'status', 'value':value },function(res){
			
		},'json');
	});
	//删除事件
	$('#qf-container').on('click','.layui-delete',function(e){
		e.preventDefault();
		var url = $(this).data('href');
		layer.confirm('确定要删除么？', function(index){
			$.post(url,function(res){
				layer.msg(res.message);
				if(res.status=='success'){
					setTimeout(function(){
						tableIns.reload();
					},600);
				}
				return false;
			},'json');
		});
	});
});
</script>



</body>

</html>