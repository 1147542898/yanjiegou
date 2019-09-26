<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"/www/wwwroot/svn.yanjiegou.com/public/../application/admin/view/ad/add.html";i:1561516925;s:72:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/common.html";i:1561105812;s:68:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/js.html";i:1562165964;}*/ ?>
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
        <style>        .layui-upload-img { width: 90px; height: 90px; margin: 0; }        .pic-more { width:100%; left; margin: 10px 0px 0px 0px;}        .pic-more li { width:90px; float: left; margin-right: 5px;}        .pic-more li .layui-input { display: initial; }        .pic-more li a { position: absolute; top: 0; display: block; }        .pic-more li a i { font-size: 24px; background-color: #008800; }        #slide-pc-priview .item_img img{ width: 90px;}        #slide-pc-priview li{position: relative;}        #slide-pc-priview li .operate{ color: #000; display: none;}        #slide-pc-priview li .toleft{ position: absolute;top: 40px; left: 1px; cursor:pointer;}        #slide-pc-priview li .toright{ position: absolute;top: 40px; right: 1px;cursor:pointer;}        #slide-pc-priview li .close{position: absolute;top: 5px; right: 5px;cursor:pointer;}        #slide-pc-priview li:hover .operate{ display: block;}    </style>

</head>
<body>
    <div class="layui-fluid">        <div class="layui-row">            <fieldset class="layui-elem-field layui-field-title">                <legend><?php echo $title; ?></legend>            </fieldset>                <form class="layui-form" method="post" enctype="multipart/form-data">                    <div class="layui-form-item">                        <label for="type_id" class="layui-form-label">所属位置</label>                        <div class="layui-input-inline">                            <select id="type_id" name="type_id" class="valid">                                <option value="0">请选择所属广告位</option>                                <?php if(is_array($adtypeList) || $adtypeList instanceof \think\Collection || $adtypeList instanceof \think\Paginator): $i = 0; $__LIST__ = $adtypeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>                                <option value="<?php echo $vo['type_id']; ?>"><?php echo $vo['name']; ?></option>                                <?php endforeach; endif; else: echo "" ;endif; ?>                            </select>                        </div>                    </div>                    <div class="layui-form-item">                        <label for="name" class="layui-form-label">广告名称</label>                        <div class="layui-input-inline">                            <input type="text" id="name" name="name" placeholder="<?php echo lang('pleaseEnter'); ?>广告名称" required="" lay-verify="required" autocomplete="off" class="layui-input"></div>                    </div>                                        <div class="layui-form-item">                        <label class="layui-form-label">商家商标logo</label>                        <div class="layui-input-block">                            <div class="upload-picture">                                <img src="/static/admin/images/upload_200_150.jpg" width="200" height="150" class="preview-picture" onerror="javascript:this.src='/static/admin/images/upload_200_150.jpg';">                            </div>                            <input type="hidden" name="pic" value="">                        </div>                    </div>                    <div class="layui-form-item">                        <label for="url" class="layui-form-label"><?php echo lang('ad'); ?>URL</label>                        <div class="layui-input-inline">                            <input type="text" id="url" name="url" required="" lay-verify="url" autocomplete="off" class="layui-input" value="http://" placeholder="<?php echo lang('pleaseEnter'); ?><?php echo lang('ad'); ?>URL">                        </div>                    </div>                    <div class="layui-form-item">                        <label class="layui-form-label">是否审核</label>                        <div class="layui-input-block">                            <input type="radio" name="open" value="1" title="<?php echo lang('open'); ?>">                            <input type="radio" name="open" value="0" title="<?php echo lang('close'); ?>" checked>                        </div>                    </div>                    <div class="layui-form-item">                        <label for="sort" class="layui-form-label"><?php echo lang('order'); ?></label>                        <div class="layui-input-inline">                            <input type="text" id="sort" name="sort" placeholder="从小到大排序" required=""  autocomplete="off" class="layui-input"></div>                    </div>                <div class="layui-form-item layui-form-text">                    <label for="content" class="layui-form-label">内容</label>                    <div class="layui-input-block">                        <textarea placeholder="请输广告内容" id="content" name="content" class="layui-textarea"></textarea>                    </div>                </div>                <div class="layui-form-item">                    <div class="layui-input-block">                        <button type="button" class="layui-btn" lay-submit="" lay-filter="submit"><?php echo lang('submit'); ?></button>                        <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary"><?php echo lang('back'); ?></a>                    </div>                </div>         </form>     </div>    </div>


<!--js结束-->
 <script>var moduleid = '<?php echo $moduleid; ?>';        layui.use(['form', 'layer','upload','jquery'], function() {            $ = layui.jquery;            var form = layui.form,                layer = layui.layer,                upload = layui.upload;            //自定义验证规则            form.verify({            });            //监听提交            form.on('submit(submit)', function (data) {                // 提交到方法 默认为本身                var loading = layer.load(1, {shade: [0.1, '#fff']});                $.post("", data.field, function (res) {                    layer.close(loading);                    if (res.code > 0) {                        layer.msg(res.msg, {time: 1800, icon: 1}, function () {                            location.href = res.url;                        });                    } else {                        layer.msg(res.msg, {time: 1800, icon: 2});                    }                });            });            //多图上传            upload.render({                elem: '.upload-picture',                url: uploadApi,                data: {                    moduleid: moduleid,                    attachmark: attachmark,                    identity: identity,                },                field: 'upfile',                //size: 20000,                exts: 'jpg|png|jpeg',                before: function(obj) {                    layer.msg('图片上传中...', {                        icon: 16,                        shade: 0.01,                        time: 0                    })                },                done: function(res, index, upload){ //上传后的回调                    layer.msg(res.message);                    if( res.status == 'success' ){                        //if(res.uploadInfo.attachthumb == ''){                            $('input[name=pic]').val(res.uploadInfo.attachurl);                            $('img','.upload-picture').attr('src',res.uploadInfo.attachurl);                        // }else{                        //     $('input[name=shoplogo]').val(res.uploadInfo.attachthumb);                        //     $('img','.upload-picture').attr('src',res.uploadInfo.attachthumb);                        // }                    }                }            });        });        //点击多图上传的X,删除当前的图片        $("body").on("click",".close",function(){            $(this).closest("li").remove();        });        //多图上传点击<>左右移动图片        $("body").on("click",".pic-more ul li .toleft",function(){            var li_index=$(this).closest("li").index();            if(li_index>=1){                $(this).closest("li").insertBefore($(this).closest("ul").find("li").eq(Number(li_index)-1));            }        });        $("body").on("click",".pic-more ul li .toright",function(){            var li_index=$(this).closest("li").index();            $(this).closest("li").insertAfter($(this).closest("ul").find("li").eq(Number(li_index)+1));        });    </script>


</body>

</html>

