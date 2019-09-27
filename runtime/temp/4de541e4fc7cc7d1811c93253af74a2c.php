<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\recommend\goods.html";i:1569478521;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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

<style>
input[type=text]{padding: 6px 5px;}
</style>
<form autocomplete='off'>
<div id='alertTips' class='alert alert-success alert-tips fade in'>
  <div id='headTip' class='head'><i class='fa fa-lightbulb-o'></i>操作说明</div>
  <ul class='body'>
      <li>本功能主要用于前台商品展示的推荐设置，例如首页各楼层，猜你喜欢，最新上架，热销商品，推荐商城等等。</li>
      <li>若未进行过商品的推荐操作，则系统默认按照商品销量、上架时间排序；若有设置过则以设置的商品及排序为主。</li>
      <li>本功能为扩展功能，开发者可通过组合不同的商品分类和推荐类型在前台进行商品信息的展示</li>
  </ul>
</div>
<table class='wst-form wst-box-top'>
	  <tr>
	     <th width='120'>商品分类<font color='red'>*</font>：</th>
	     <td colspan='2'>
	        <select id="cat12_0" class='ipt pgoodsCats1_2' level="0" onchange="WST.ITGoodsCats({id:'cat12_0',val:this.value,isRequire:false,className:'pgoodsCats1_2'});">
	          <option value=''>请选择</option>
	          <?php $_result=WSTGoodsCats(0);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	          <option value="<?php echo $vo['catId']; ?>"><?php echo $vo['catName']; ?></option>
	          <?php endforeach; endif; else: echo "" ;endif; ?>
	        </select>
	     </td>
	     <td>
	        商品分类<font color='red'>*</font>：
	        <select id="cat22_0" class='ipt pgoodsCats2_2' level="0" onchange="WST.ITGoodsCats({id:'cat22_0',val:this.value,isRequire:false,className:'pgoodsCats2_2',afterFunc:'listQueryByGoods'});">
	          <option value=''>所有分类</option>
	          <?php $_result=WSTGoodsCats(0);if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	          <option value="<?php echo $vo['catId']; ?>"><?php echo $vo['catName']; ?></option>
	          <?php endforeach; endif; else: echo "" ;endif; ?>
	        </select>
	     </td>
	  <tr>
	     <th width='120'>搜索：</th>
	     <td colspan='2'>
	        <input type='text' id='key_2' style='width:250px' class='ipt_2' placeholder='店铺名、商品名称、商品编号、商品货号'/>
	        <button type="button" class="btn btn-primary" onclick='javascript:loadGoods("_2")'><i class="fa fa-search"></i>搜索</button>
	     </td>
	     <td style='padding-left:30px;'>
	       类型<font color='red'>*</font>：
	       <select id='dataType_2' onchange='listQueryByGoods("_2")'>
	          <option value='0'>推荐</option>
	          <option value='1'>热销</option>
	          <option value='2'>精品</option>
	          <option value='3'>新品</option>
	        </select>
	     </td>
	  </tr>
	  <tr>
	     <th>请选择<font color='red'>*</font>：</th>
	     <td width='320'>
	       <div class="recom-lbox">
	            <div class="trow head">
	              <div class="tck"><input onclick="WST.checkChks(this,'.lchk_2')" type="checkbox"></div>
	              <div class="ttxt">商品</div>
	            </div>
	            <div id="llist_2" style="width:350px;"></div>
	       </div>
	     </td>
	     <td align='center'>
	       <input type='button' value='》》' class='btn btn-primary' onclick='javascript:moveRight("_2")'/>
	       <br/><br/>
	       <input type='button' value='《《' class='btn btn-primary' onclick='javascript:moveLeft("_2")'/>
	       <input type='hidden' id='ids_2'/>
	     </td>
	     <td>
	       <div class="recom-rbox">
	            <div class="trow head">
		            <div class="tck"><input onclick="WST.checkChks(this,'.rchk_2')" type="checkbox"></div>
		            <div class="ttxt">商品</div>
		            <div class="top">排序</div>
		        </div>
	            <div id="rlist_2"></div>
	       </div>
	     </td>
	  </tr>
	 
</table>
</form>
<script>
$(function(){
	listQueryByGoods('_2');
	$('#headTip').WSTTips({width:90,height:35,callback:function(v){}});
});
</script>



<!--js结束-->

<script src="__ADMIN__/recommends/recommends.js?v=1" type="text/javascript"></script>



</body>

</html>

