<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\fund\add.html";i:1570500033;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
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
        <form class="layui-form" method="post" enctype="multipart/form-data">
            <div class="layui-form-item">
                <label class="layui-form-label">提现账号</label>
                <div class="layui-input-inline">
                    <select name="bank_name"  lay-verify="required" lay-filter="bank_name">
                        <option value="">选择账号</option>
                        <?php if(is_array($banks) || $banks instanceof \think\Collection || $banks instanceof \think\Paginator): $i = 0; $__LIST__ = $banks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $list['bank_name']; ?>:<?php echo $list['bank_number']; ?>:<?php echo $list['bank_address']; ?>:<?php echo $list['bank_user_name']; ?>" data-id="<?php echo $list['bank_number']; ?>"><?php echo $list['bank_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux">
                    必填
                </div>
            </div>
            <div class="layui-form-item">
                    <label class="layui-form-label">持卡人</label>
                    <div class="layui-input-inline">
                        <input name="bank_user_name" id="bank_user_name" class="layui-input" lay-verify="required">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        必填
                    </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">提现金额</label>
                <div class="layui-input-inline">
                    <input type="text" id="username" name="money" lay-verify="required" placeholder="请输入金额" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    必填
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备注说明</label>
                <div class="layui-input-inline">
                    <textarea name="note" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
            
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>
                </div>
            </div>
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
   form.on('select(bank_name)',function(data){
       console.log(data)
      console.log(data.value)
      var data=data.value;
      var bank_user_name=data.split(":").pop();
      $("#bank_user_name").val(bank_user_name);
      console.log(bank_user_name)
   });
});
</script>



</body>

</html>

