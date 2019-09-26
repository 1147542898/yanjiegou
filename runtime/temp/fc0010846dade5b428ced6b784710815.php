<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"/www/wwwroot/svn.yanjiegou.com/public/../application/shop/view/order/send.html";i:1561105812;s:71:"/www/wwwroot/svn.yanjiegou.com/application/shop/view/Public/common.html";i:1561105812;s:67:"/www/wwwroot/svn.yanjiegou.com/application/shop/view/Public/js.html";i:1561543465;}*/ ?>
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
<form class="layui-form layui-form-pane" lay-filter="form" method="post">
<table class="layui-table">
   <!-- <tr>
   	<td></td>
   	<td></td>
   	<td></td>
   	<td></td>
   	<td></td>
   </tr> -->
   <tr>
   	 <td width="100px">发货方式</td>
   	 <td colspan="4">
   	    <input type="radio" value="1" name="send_type" checked title="需要物流">
   	    <input type="radio" value="0" name="send_type" title="无需物流">   
   	 </td>
   </tr>
   <tr>
   	<td>快递公司</td>
   	<td colspan="4">
        <select name="expresscom" id="">
           <option value="0">请选择</option>
            <?php echo get_status_option('','express_company'); ?>
        </select>
   	</td>
   </tr>
   <tr>
   	<td>快递号</td>
   	<td colspan="4"><input type="text" name="expresssn"  class="layui-input"></td>
   </tr>
   <tr>
   	<td>收货信息</td>
   	<td colspan="4"><?php echo $info['address']; ?>--<?php echo $info['mobile']; ?></td>
   </tr>
   <tr>
   	<td colspan="5" style="text-align: center"> <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">确定发货</button></td>
   </tr>
   <input type="hidden" value="<?php echo $info['id']; ?>" name="id"/>
</table>
</form>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script>
layui.use(['form', 'layer'], function () {
    var form = layui.form, layer = layui.layer,$= layui.jquery;
    form.on('submit(submit)', function (data) {
        loading =layer.load(1, {shade: [0.1,'#fff']});
        $.post("<?php echo url(''); ?>", data.field, function (res) {
        	var index = parent.layer.getFrameIndex(window.name);
            layer.close(loading);
            if (res.code > 0) {
                layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                    parent.layer.close(index);
                    window.parent.location.reload();
                });
            } else {
                layer.msg(res.msg, {time: 1800, icon: 2});
            }
        });
    });
});
</script>



</body>

</html>

