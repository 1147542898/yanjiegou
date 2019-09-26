<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"/www/wwwroot/svn.yanjiegou.com/public/../application/shop/view/order/info.html";i:1561105812;s:71:"/www/wwwroot/svn.yanjiegou.com/application/shop/view/Public/common.html";i:1561105812;s:67:"/www/wwwroot/svn.yanjiegou.com/application/shop/view/Public/js.html";i:1561543465;}*/ ?>
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
    <div class="layui-card-header">订单状态</div>
    <div class="layui-card-body">
      <div class="log-box">
        <div class="state">
          <?php if($info['pay_type']==4): ?>
             <div class="icon">
                <span class="icons <?php if(($info['status']>=1)): ?>icon13 <?php else: ?>icon11 <?php endif; ?>">
                </span>
            </div>
            <div class="arrow <?php if(($info['status']>=1)): ?>arrow2<?php endif; ?>">··················></div>
          <?php else: ?>
            <div class="icon">
                <span class="icons <?php if(($info['status']>=1)): ?>icon13 <?php else: ?>icon11 <?php endif; ?>">
                </span>
            </div>
            <div class="arrow <?php if(($info['status']>=1)): ?>arrow2<?php endif; ?>">··················></div>
            <div class="icon">
                <span class="icons <?php if(($info['status'] != 6) and ($info['status']>=2)): ?>icon23 <?php else: ?>icon21<?php endif; ?>">
                </span>
            </div>
            <div class="arrow <?php if(($info['status'] != 6) and ($info['status']>=2)): ?>arrow2<?php endif; ?>">··················></div>
          <?php endif; ?>
            <div class="icon">
                <span class="icons <?php if(($info['status'] != 6) and ($info['status']>=3)): ?>icon33 <?php else: ?>icon31 <?php endif; ?>"></span>
            </div>
            <div class="arrow <?php if(($info['status'] != 6) and ($info['status']>=3)): ?>arrow2<?php endif; ?>">··················></div>
            <div class="icon">
                <span class="icons <?php if(($info['status'] != 6) and ($info['status']>=4)): ?>icon43 <?php else: ?>icon41 <?php endif; ?>">
                </span>
            </div>
            <div class="arrow <?php if(($info['status'] != 6) and ($info['status']>=4)): ?>arrow2<?php endif; ?>">··················></div>
            <div class="icon">
               <span class="icons <?php if(($info['status'] != 6) and ($info['status']>=5)): ?>icon53 <?php else: ?>icon51 <?php endif; ?>"></span>
            </div>
            <?php if(($info['status'] > 5)): ?>
            <div class="arrow <?php if(($info['status']>=5)): ?>red<?php endif; ?>">··················></div>
            <?php endif; if(($info['status'] == 6)): ?>
            <div class="icon">
               <span class="icons <?php if(($info['status'] == 6)): ?>icon63 <?php else: ?>icon61 <?php endif; ?>"></span>
            </div>
            <?php endif; if(($info['status'] == 7)): ?>
            <div class="icon">
               <span class="icons <?php if(($info['status'] == 7)): ?>icon73 <?php else: ?>icon71 <?php endif; ?>"></span>
            </div>
            <?php endif; ?>
        </div>
       <div class="state2">
             <p class="<?php if(($info['status']>=1)): ?>green<?php else: ?>hui<?php endif; ?>">下单<br/><?php if($info['add_time']): ?><?php echo date('Y-m-d H:i:s',$info['add_time']); endif; ?></p>
          <?php if($info['pay_type']!=4): ?>
             <p class="<?php if(($info['status'] != 6) and ($info['status']>=2)): ?>green<?php else: ?>hui<?php endif; ?>">等待支付<br/><?php if($info['paytime']): ?><?php echo date('Y-m-d H:i:s',$info['paytime']); endif; ?></p>
          <?php endif; ?>
             <p class="<?php if(($info['status'] != 6) and ($info['status']>=3)): ?>green<?php else: ?>hui<?php endif; ?>">商家发货<br/><?php if($info['sendtime']): ?><?php echo date('Y-m-d H:i:s',$info['sendtime']); endif; ?></p>
             <p class="<?php if(($info['status'] != 6) and ($info['status']>=4)): ?>green<?php else: ?>hui<?php endif; ?>">确认收货<br/><?php if($info['affirmtime']): ?><?php echo date('Y-m-d H:i:s',$info['affirmtime']); endif; ?></p>
             <p class="<?php if(($info['status'] != 6) and ($info['status']>=5)): ?>green<?php else: ?>hui<?php endif; ?>">订单结束<br/><?php if($info['overtime']): ?><?php echo date('Y-m-d H:i:s',$info['overtime']); endif; ?></p>
             <?php if(($info['status'] == 6)): ?>
                 <p class="red">取消<br/><?php if($info['canceltime']): ?><?php echo date('Y-m-d H:i:s',$info['canceltime']); endif; ?></p>
             <?php endif; if(($info['status'] == 7)): ?>
                 <p class="red">售后<br/><?php if($info['shtime']): ?><?php echo date('Y-m-d H:i:s',$info['shtime']); endif; ?></p>
             <?php endif; ?>
       </div>
       <div class="wst-clear"></div>
      </div>
    </div>
    <div class="layui-card-header">订单信息</div>
    <div class="layui-card-body">
        <div class="layui-row" style="padding-left: 30px">
            <div class="layui-col-md12">
              <label class="green">订单号：</label><?php echo $info['order_sn']; ?>
            </div>
            <div class="layui-col-md12">
              <label class="green">支付方式：</label><?php echo $info['pay_type']; ?>
            </div>
            <div class="layui-col-md12">
             <label class="green">配送方式：</label><?php echo $info['send_type']; ?>
            </div>
            <div class="layui-col-md12">
             <label class="green">快递公司：</label><?php echo get_status($info['expresscom'],'express_company'); ?>
            </div>
            <div class="layui-col-md12">
             <label class="green">单号：</label><?php echo $info['expresssn']; ?>
            </div>
      </div>
    </div>
    <div class="layui-card-header">收货人信息</div>
    <div class="layui-card-body">
        <div class="layui-row" style="padding-left: 30px">
            <div class="layui-col-md12">
              <label class="green">联系人：</label><?php echo $info['getusername']; ?>
            </div>
            <div class="layui-col-md12">
              <label class="green">联系方式：</label><?php echo $info['mobile']; ?>
            </div>
            <div class="layui-col-md12">
             <label class="green">地址：</label><?php echo $info['address']; ?>
            </div>
            <div class="layui-col-md12">
              <label class="green">买家留言：</label><?php echo $info['remark_member']; ?>
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
               <td><?php echo $val['count']; ?></td>
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

