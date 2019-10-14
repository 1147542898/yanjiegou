<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\evaluate\see.html";i:1569466684;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
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

    <fieldset class="layui-elem-field">
        <legend><?php echo $comments['gtitle']; ?> 【评论详情】</legend>
        <div class="layui-field-box">

            <div class="layui-form-item">
                <label class="layui-form-label">评论者</label>
                <div class="layui-input-block">
                    <div class="layui-form-mid layui-word-aux"><?php echo $comments['umobile']; ?></div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">订单编号</label>
                <div class="layui-input-block">
                    <div class="layui-form-mid layui-word-aux"><?php echo $comments['ordersn']; ?></div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">订单金额</label>
                <div class="layui-input-block">
                    <div class="layui-form-mid layui-word-aux"><?php echo $comments['omoney']; ?></div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">商品名称</label>
                <div class="layui-input-block">
                    <div class="layui-form-mid layui-word-aux"><?php echo $comments['gtitle']; ?></div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">商家</label>
                <div class="layui-input-block">
                    <div class="layui-form-mid layui-word-aux"><?php echo $comments['sname']; ?></div>
                </div>
            </div>



            <div class="layui-form-item">
                <label class="layui-form-label">物流服务</label>
                <div class="layui-input-block">
                    <div class="layui-form-mid layui-word-aux"><?php echo $comments['logistics']; ?></div>
                </div>
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label">服务态度</label>
                <div class="layui-input-block">
                    <div class="layui-form-mid layui-word-aux"><?php echo $comments['manner']; ?></div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">评论内容</label>
                <div class="layui-input-block">
                    <div class="layui-form-mid layui-word-aux"><?php echo $comments['content']; ?></div>
                </div>
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label">评论图片</label>
                <div class="layui-input-block">
                    <div class="layui-form-mid layui-word-aux">
                        <?php if(empty($imgsrc) || (($imgsrc instanceof \think\Collection || $imgsrc instanceof \think\Paginator ) && $imgsrc->isEmpty())): ?>
                        没有上传图片
                        <?php else: if(is_array($imgsrc) || $imgsrc instanceof \think\Collection || $imgsrc instanceof \think\Paginator): $i = 0; $__LIST__ = $imgsrc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                       <p style="margin-bottom: 10px;"> <a href="/<?php echo $vo; ?>" target="_blank"><img src="/<?php echo $vo; ?>" alt="" width="300"></a></p>
                        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </div>
                </div>
            </div>










        </div>
    </fieldset>



<!--js结束-->





</body>

</html>

