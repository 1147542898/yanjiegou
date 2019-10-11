<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\coupon\add.html";i:1569466684;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
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
        <fieldset class="layui-elem-field layui-field-title">
            <legend>添加优惠券</legend>
        </fieldset>
        <form class="layui-form" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label">最低消费金额</label>
                <div class="layui-input-block">
                    <input type="text" name="min_price" required  lay-verify="required" placeholder="请输入最低消费金额" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">优惠金额</label>
                <div class="layui-input-block">
                    <input type="text" name="sub_price" required  lay-verify="required" placeholder="请输入优惠金额" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">有效开始时间</label>
                <div class="layui-input-block">
                    <input type="text"  name="begin_time" id="begin_time" required  lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">有效结束时间</label>
                <div class="layui-input-block">
                    <input type="text" name="end_time" id="end_time" required  lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">数量</label>
                <div class="layui-input-block">
                    <input type="text" name="total_count" required  lay-verify="number" autocomplete="off" placeholder="请输入数量" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">使用说明</label>
                <div class="layui-input-block">
                    <textarea name="rule" placeholder="请输入使用说明" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="sort" class="layui-form-label">排序</label>
                <div class="layui-input-inline">
                    <input type="text" id="sort" name="sort" placeholder="从小到大排序" required=""  autocomplete="off" class="layui-input" value="0"></div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">特殊节日</label>
                <div class="layui-input-block">
                    <input type="text" name="special" required  lay-verify="number" autocomplete="off" placeholder="请输入节日日期" class="layui-input" value="0">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>
                    <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary"><?php echo lang('back'); ?></a>
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
    layui.use(['form','laydate','jquery'], function () {
        var form = layui.form,
            laydate = layui.laydate,
            $ = layui.jquery;
        //自定义验证规则
        form.verify({
        });
        //监听提交
        form.on('submit(submit)', function (data) {
            // 提交到方法 默认为本身
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post("", data.field, function (res) {
                layer.close(loading);
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                        location.href = res.url;
                    });
                } else {
                    layer.msg(res.msg, {time: 1800, icon: 2});
                }
            });
        });
        //开始日期
        laydate.render({
            elem: "#begin_time",
            type:"date",
            format:"yyyy-MM-dd"
        });
        //结束日期
        laydate.render({
            elem: "#end_time",
            type:"date",
            format:"yyyy-MM-dd"
        });
    });
</script>



</body>

</html>

