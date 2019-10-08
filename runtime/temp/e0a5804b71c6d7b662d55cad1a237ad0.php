<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\info\postage.html";i:1569466684;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
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
.layui-input-inline{width:50px;margin-left: 200px;}
.aname{display: inline-block;width: 200px}
.son{padding-left: 50px;display: inline-block;width: 200px}
</style>


</head>
<body>

<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-body">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>邮费设置</legend>
    </fieldset>
    <form class="layui-form" method="post">
    <div class="layui-collapse" lay-accordion="">
      <?php if(is_array($arealist) || $arealist instanceof \think\Collection || $arealist instanceof \think\Paginator): if( count($arealist)==0 ) : echo "" ;else: foreach($arealist as $key=>$val): ?>
      <div class="layui-colla-item">
        <h2 class="layui-colla-title">
           <span class="aname"><?php echo $val['area_name']; ?></span> 
           <input type="text" data-id="<?php echo $val['id']; ?>" class="layui-input-inline father" name="yf[<?php echo $val['id']; ?>]" value="<?php echo $val['yf_val_money']; ?>">
        </h2>
        <div class="layui-colla-content" id="son<?php echo $val['id']; ?>">
           <?php if(is_array($val['son']) || $val['son'] instanceof \think\Collection || $val['son'] instanceof \think\Paginator): if( count($val['son'])==0 ) : echo "" ;else: foreach($val['son'] as $key=>$vals): ?>
           <p><span class="son"><?php echo $vals['area_name']; ?></span> <input type="text" class="layui-input-inline" name="yf[<?php echo $vals['id']; ?>]" value="<?php echo $val['yfs_val_money']; ?>"></p>
           <?php endforeach; endif; else: echo "" ;endif; ?> 
        </div>
      </div>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
     <div class="content-bottom">
       <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>
    </div> 
    </form>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script type="text/javascript">
    layui.use(['form','jquery'], function () {
        var form = layui.form,
            $ = layui.jquery;
        //自定义验证规则
        form.verify({
        });
        //监听提交
        form.on('submit(submit)', function (data) {
            console.log(data)
            // 提交到方法 默认为本身
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post("", data.field, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                        location.href = '<?php echo url(''); ?>';
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
        });
        
    });
    $("body").on("blur",".father",function(){
        var id=$(this).data('id');
        var vals=$(this).val();
        $('#son'+id+' .layui-input-inline').val(vals);
    });
</script>




</body>

</html>

