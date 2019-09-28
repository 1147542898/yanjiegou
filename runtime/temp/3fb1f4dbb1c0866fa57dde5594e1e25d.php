<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\goods_brand\add.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
        <legend>添加标签</legend>
    </fieldset>
    <form class="layui-form" method="post">
        <div class="layui-form-item">
            <label class="layui-form-label">标签</label>
            <div class="layui-input-inline" id="box_tags">
                <input type="text" data-required="1" min="0" max="0" errormsg="" title="标签" placeholder="请输入标签" lay-verify="defaul" class="tags layui-input" name="title" value="" />
            </div>
            <div class="layui-form-mid layui-word-aux red">*必填</div>
        </div>
        <div class="layui-form-item">
                <label class="layui-form-label">logo</label>
                <div class="layui-input-block">
                    <div class="upload-picture">
                        <img src="/static/admin/images/upload_200_150.jpg" width="200" height="150" class="preview-picture" onerror="javascript:this.src='/static/admin/images/upload_200_150.jpg';">
                    </div>
                    <input type="hidden" name="pic" value="">
                </div>
            </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">提交</button>
                <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary">返回列表</a>
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
var moduleid = '<?php echo $moduleid; ?>';
    layui.use(['form','upload','jquery'], function () {
        var form = layui.form,upload = layui.upload,$ = layui.jquery;
        //logo
        upload.render({
            elem: '.upload-picture',
            url: uploadApi,
            data: {
                moduleid: moduleid,
                attachmark: attachmark,
                identity: identity,
            },
            field: 'upfile',
            //size: 20000,
            exts: 'jpg|png|jpeg',
            before: function(obj) {
                layer.msg('图片上传中...', {
                    icon: 16,
                    shade: 0.01,
                    time: 0
                })
            },
            done: function(res, index, upload){ //上传后的回调
                layer.msg(res.message);
                if( res.status == 'success' ){
                    //if(res.uploadInfo.attachthumb == ''){
                        $('input[name=pic]').val(res.uploadInfo.attachurl);
                        $('img','.upload-picture').attr('src',res.uploadInfo.attachurl);
                    // }else{
                    //     $('input[name=pic]').val(res.uploadInfo.attachthumb);
                    //     $('img','.upload-picture').attr('src',res.uploadInfo.attachthumb);
                    // }
                }
            }
        });
        form.on('submit(submit)', function (data) {
            $.post("<?php echo url('add'); ?>", data.field, function (res) {
                if (res.code > 0) {
                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                        window.location.href="<?php echo url('index'); ?>"
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

