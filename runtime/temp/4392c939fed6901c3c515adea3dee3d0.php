<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\users_card\info.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
    <style>.layui-table tr td:nth-child(1){width:150px;text-align:right;font-weight: bold;}.layui-table,tr,td{border:0;}</style>

</head>
<body>
<div class="layui-fluid"><div class="layui-row layui-col-space15"><div class="layui-col-md12"><div class="layui-card"><div class="layui-card-body">    <fieldset class="layui-elem-field layui-field-title">        <legend>会员卡</legend>    </fieldset>    <blockquote class="layui-elem-quote"><span class="red">只能设置一张会员卡</span></blockquote><table class="layui-table">    <tr>        <td>名称</td>        <td><?php echo $info['name']; ?></td>    </tr>    <tr>        <td>排序</td>        <td> <?php echo $info['sort']; ?></td>    </tr>    <tr>        <td>价格</td>        <td><?php echo $info['price']; ?></td>    </tr>    <tr>        <td>会员卡使用获得积分</td>        <td><?php echo $info['points']; ?></td>    </tr>    <tr>        <td>会员卡折扣</td>        <td><?php echo $info['discount']; ?></td>    </tr>    <tr>        <td>满送方式</td>        <td>            <?php if(($info['full_send_way'] == 0)): ?><span class="green">不使用</span><?php endif; if(($info['full_send_way'] == 1)): ?><span class="green">必须一次购买满多少送</span><?php endif; if(($info['full_send_way'] == 2)): ?><span class="green">从第一次在商家购买的总和</span><?php endif; ?>     </tr>    <tr>        <td>购买满多少送卡</td>        <td><?php echo $info['full_send']; ?></td>    </tr>    <tr>        <td>介绍</td>        <td><?php echo $info['description']; ?></td>    </tr>    <tr>        <td>状态</td>        <td><?php if(($info['status'])): ?><span class="green">启用</span><?php endif; if(($info['status'] == 0)): ?><span class="red">停用</span><?php endif; ?></td>    </tr>    <tr>        <td>创建时间</td>        <td><?php echo $info['create_time']; ?></td>    </tr>    <tr>        <td colspan="2" style="text-align: center">            <a href="<?php echo url('edit',array('id'=>$info['id'])); ?>" class="layui-btn layui-btn-xs">编辑</a>        </td>    </tr></table></div></div></div></div></div>


<!--js结束-->
<script type="text/javascript">    layui.use(['form','jquery'], function () {        var form = layui.form,$ = layui.jquery;        form.on('submit(submit)', function (data) {            $.post("<?php echo url(''); ?>", data.field, function (res) {                if (res.code > 0) {                    layer.msg(res.msg, {time: 1800, icon: 1}, function () {                        window.location.href="<?php echo url('index'); ?>"                    });                } else {                    layer.msg(res.msg, {time: 1800, icon: 2});                }            });        });    });</script>


</body>

</html>

