<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:80:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\fsale\feeset.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
        <legend><?php echo $title; ?></legend>
    </fieldset>
    <form class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <label class="layui-form-label label25">分销佣金类型： <b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="radio" name="price_type"  value="0" title="百分比" <?php if(($info['price_type'] == 0)): ?>checked="checked"<?php endif; ?>>
                <input type="radio" name="price_type"  value="1" title="固定金额" <?php if(($info['price_type'] == 1)): ?>checked="checked"<?php endif; ?>>
            </div>
        </div>
       
        <div class="layui-form-item">
            <label class="layui-form-label label25">一级名称:  <b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="text" name="first_name"  lay-verify="required" value="<?php if(($info['first_name'])): ?><?php echo $info['first_name']; else: ?>一级<?php endif; ?>" class="layui-input"> 
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">一级佣金:  <b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="text" name="first_fee"  onkeyup="num(this)"  lay-verify="required" value="<?php if(($info['first_fee'])): ?><?php echo $info['first_fee']; else: ?>30<?php endif; ?>" class="layui-input"> <span class="red units"><?php if(($info['price_type'])): ?>元<?php else: ?>%<?php endif; ?></span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">二级名称:  <b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="text" name="second_name"  lay-verify="required" value="<?php if(($info['second_fee'])): ?><?php echo $info['second_name']; else: ?>二级<?php endif; ?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">二级佣金:  <b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="text" name="second_fee"  onkeyup="num(this)"  lay-verify="required" value="<?php if(($info['second_fee'])): ?><?php echo $info['second_fee']; else: ?>20<?php endif; ?>" class="layui-input"> <span class="red units"><?php if(($info['price_type'])): ?>元<?php else: ?>%<?php endif; ?></span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">三级名称:  <b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="text" name="third_name"  lay-verify="required" value="<?php if(($info['third_fee'])): ?><?php echo $info['third_name']; else: ?>三级<?php endif; ?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label label25">三级拥金:  <b class="red">*</b></label>
            <div class="layui-input-block">
                <input type="text" name="third_fee"  onkeyup="num(this)"  lay-verify="required" value="<?php if(($info['first_fee'])): ?><?php echo $info['third_fee']; else: ?>10<?php endif; ?>" class="layui-input"> <span class="red units"><?php if(($info['price_type'])): ?>元<?php else: ?>%<?php endif; ?></span>
            </div>
        </div>
        
        <div class="layui-form-item">
            <div class="layui-input-block" >
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
        
        layui.use(['form', 'layer','upload'], function () {
            var form = layui.form, $ = layui.jquery, upload = layui.upload;
            form.on('radio()', function(data){
              if(data.value==0){
                  $('.units').html('%');
              }else{
                  $('.units').html('元');
              }
            }); 

            form.on('submit(submit)', function (data) {
                
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("", data.field, function (res) {
                    layer.close(loading);
                    if (res.code > 0) {
                        layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                            window.location.reload()
                            //location.href = res.url;
                        });
                    } else {
                        layer.msg(res.msg, {time: 1800, icon: 2});
                    }
                });
            });
            
           

            //普通图片上传
            var uploadInst = upload.render({
                elem: '#adBtn'
                ,url: '<?php echo url("UpFiles/upload"); ?>'
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#adPic').attr('src', result); //图片链接（base64）
                    });
                },
                done: function(res){
                    if(res.code>0){
                        $('#pic').val(res.url);
                    }else{
                        //如果上传失败
                        return layer.msg('上传失败');
                    }
                }
                ,error: function(){
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function(){
                        uploadInst.upload();
                    });
                }
            });
        });

function num(obj){
obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数
}
</script>



</body>

</html>

