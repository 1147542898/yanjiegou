<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:94:"D:\phpstudy123\PHPTutorial\WWW\yanjiegou\public/../application/shop\view\order\refundinfo.html";i:1570671125;s:81:"D:\phpstudy123\PHPTutorial\WWW\yanjiegou\application\shop\view\Public\common.html";i:1570671125;s:77:"D:\phpstudy123\PHPTutorial\WWW\yanjiegou\application\shop\view\Public\js.html";i:1570671125;}*/ ?>
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
    
<style>
.layui-card-header{border-bottom:solid 1px #EEE;}
label{font-weight: bold;color:#009688;}
.bottom,.bottoms{display: inline-block;width:200px;text-align: right;font-size: 14px}
.bottoms{text-align: left;width:80px;}
.green{color: #7BBC52;font-weight:bold;}
.hui{color:#989898;}
</style>


</head>
<body>

<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
    
    <div class="layui-card-header">申请信息</div>
    <div class="layui-card-body">
        <div class="layui-row" style="padding-left: 30px">
            <div class="layui-col-md12">
              <label class="green">订单号：</label><?php echo $info['order_sn']; ?>
            </div>
            <div class="layui-col-md12">
              <label class="green">金额：</label><?php echo $info['money']; ?>
            </div>
            <div class="layui-col-md12">
             <label class="green">联系电话：</label><?php echo $info['mobile']; ?>
            </div>
            <div class="layui-col-md12">
             <label class="green">申请说明：</label><?php echo $info['remark']; ?>
            </div>
            <div class="layui-col-md12">
             <label class="green">申请图片说明：</label>
             <?php if(is_array($info['imgs']) || $info['imgs'] instanceof \think\Collection || $info['imgs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['imgs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
              <img width=80 src="/<?php echo $v; ?>"  onmouseover="layer.tips('<img   src=\'/<?php echo $v; ?>\'>',this,{tips: [1, '#fff']});" onmouseout="layer.closeAll();"/>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            
      </div>
    </div>

     <div class="layui-card-header">处理信息</div>
    <div class="layui-card-body">
        <div class="layui-row" style="padding-left: 30px">
            <div class="layui-col-md12">
              <label class="green">处理时间：</label><?php echo date("Y-m-d H:i:s",$info['do_time']); ?>
            </div>
            <div class="layui-col-md12">
              <label class="green">状态：</label><?php echo get_status($info['status'],'check'); ?>
            </div>
            <div class="layui-col-md12">
             <label class="green">申请说明：</label><?php echo $info['shop_remark']; ?>
            </div>
            
      </div>
    </div>
   
    <div class="layui-card-header">商品清单</div>
    <div class="layui-card-body">
        <table class="layui-table">
           <tr>
               <th>商品</th>
               <th>商品编号</th>
               <th>单价</th>
               <th>数量</th>
               <th>总价</th>
           </tr>
           <?php if(is_array($goods) || $goods instanceof \think\Collection || $goods instanceof \think\Paginator): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
           <tr>
               <td><img src="<?php echo $val['headimg']; ?>" height="60px" width="60px"><?php echo $val['title']; ?></td>
               <td><?php echo $val['id']; ?></td>
               <td><?php echo $val['price']; ?></td>
               <td><?php echo $val['num']; ?></td>
               <td><?php echo $val['num']*$val['price']; ?></td>
           </tr>
           <?php endforeach; endif; else: echo "" ;endif; ?>
           <tr><td colspan="5" style="text-align: right">
                <label class="red bottom">商品总金额：</label><span class="bottoms">¥ <?php echo $info['counts']; ?></span><br/>
                <label class="red bottom">运费：</label><span class="bottoms">¥ 0.00</span><br/>
                <label class="red bottom">应付总金额：</label><span class="bottoms">¥ <?php echo $info['counts']; ?></span><br/>
                <label class="red bottom">积分抵扣金额：</label><span class="bottoms">¥ -0.00</span><br/>
                <label class="red bottom">实付总金额：</label><span class="bottoms">¥ <?php echo $info['counts']; ?></span><br/>
                <label class="red bottom">可获得积分：</label><span class="bottoms">0个</span>
           </td></tr>
        </table>
    </div>
    <?php if(($info['status']==0)): ?>
    <div class="content-bottom">
       <a class="layui-btn" id="check" title="审核通过">通过</a>
       <a class="layui-btn layui-btn-danger" id="nocheck" title="审核不通过">不通过</a>
    </div> 
    <?php endif; ?>   
</div>

</div>
</div>
</div>



<!--js结束-->

<script>
var id=<?php echo $info['id']; ?>;
layui.use('layer', function () {
    var layer = layui.layer,$= layui.jquery;
    $('#check').click(function() {
      layer.prompt({formType: 2,title: '请输入通过处理说明'}, 
        function(value, index){
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post("<?php echo url('setrefundstatus'); ?>",{id:id,text:value,status:2},function(res){
                layer.close(loading);
                if(res.code===1){
                    layer.msg(res.msg,{time:1000,icon:1},function(){
                        location.reload();
                    });
                    tableIn.reload({where:{way:'<?php echo input("way"); ?>'}});
                }else{
                    layer.msg('操作失败！',{time:1000,icon:2});
                }
            });
            layer.close(index);
      })   
    })
    $('#nocheck').click(function() {
        layer.prompt({formType: 2,title: '请输入不通过原因'}, 
        function(value, index){
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post("<?php echo url('setrefundstatus'); ?>",{id:id,text:value,status:1},function(res){
                layer.close(loading);
                if(res.code===1){
                    layer.msg(res.msg,{time:1000,icon:1},function(){
                        location.reload();
                    });
                }else{
                    layer.msg('操作失败！',{time:1000,icon:2});
                }
            });
            layer.close(index);
        });
    })
});
</script>



</body>

</html>

