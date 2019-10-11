<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:82:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\users_card\edit.html";i:1569466684;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
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
        <legend>编辑会员卡</legend>
    </fieldset>
    <form class="layui-form" method="post">
        <table class="layui-table">
            <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
            <tr>
                <td>名称<span class="red">*</span></td>
                <td><input type="text" class="layui-input"   lay-verify="required" name="name" value="<?php echo $info['name']; ?>" /></td>
                <td></td>
            </tr>
            <!-- <tr>
                <td>排序</td>
                <td> <input type="text" class="layui-input"   lay-verify="defaul" name="sort" value="<?php echo $info['sort']; ?>" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
                <td><div class="layui-form-mid layui-word-aux">数字越小越排前</div></td>
            </tr> -->
            <tr>
                <td>价格<span class="red">*</span></td>
                <td><input type="text" class="layui-input"   lay-verify="defaul" name="price" value="<?php echo $info['price']; ?>" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
                <td><div class="layui-form-mid layui-word-aux">价格免费发放价格为0即可</div></td>
            </tr>
            <tr>
                <td>会员卡使用获得积分<span class="red">*</span></td>
                <td><input type="text" class="layui-input"   lay-verify="defaul" name="points" value="<?php echo $info['points']; ?>" /></td>
                <td><div class="layui-form-mid layui-word-aux">获得积分请填写 比例：100元1积分填写100:1；（冒号用英文冒号）</div></td>
            </tr>
            <tr>
                <td>会员卡折扣<span class="red">*</span></td>
                <td><input type="text" class="layui-input"   lay-verify="defaul" name="discount" value="<?php echo $info['discount']; ?>" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
                <td><div class="layui-form-mid layui-word-aux">折扣范围0-100；例如：九五折请填写95</div></td>
            </tr>
            <tr>
                <td>满送方式<span class="red">*</span></td>
                <td>
                    <input name="full_send_way" id="full_send_way" <?php if(($info['status'] == 0)): ?>checked<?php endif; ?> value="0" type="radio" class="ace" title="不使用" />
                    <input name="full_send_way" id="full_send_way" <?php if(($info['status'] == 1)): ?>checked<?php endif; ?> value="1" type="radio" class="ace" title="必须一次购买满多少送" />
                    <input name="full_send_way" id="full_send_way" <?php if(($info['status'] == 2)): ?>checked<?php endif; ?> value="2" type="radio" class="ace" title="从第一次在商家购买的总和" /></td>
                <td></td>
            </tr>
            <tr>
                <td>购买满多少送卡<span class="red">*</span></td>
                <td><input type="text" class="layui-input"   lay-verify="defaul" name="full_send" value="<?php echo $info['full_send']; ?>" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"/></td>
                <td><div class="layui-form-mid layui-word-aux">会员购买多少商品可以免费领取此卡。</div></td>
            </tr>
            <tr>
                <td>介绍<span class="red">*</span></td>
                <td><textarea name="description" id="" cols="30" rows="10"><?php echo $info['description']; ?></textarea></td>
                <td><div class="layui-form-mid layui-word-aux">介绍会员卡使用方法和领取方法</div></td>
            </tr>
            <tr>
                <td>状态<span class="red">*</span></td>
                <td><input name="status" id="status" <?php if(($info['status'])): ?>checked<?php endif; ?> value="1" type="radio" class="ace" title="发放" />
                    <input name="status" id="status" <?php if(($info['status'] == 0)): ?>checked<?php endif; ?> value="0" type="radio" class="ace" title="停发" /></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center"><button type="button" class="layui-btn" lay-submit="" lay-filter="submit">提交</button>
                    <a href="<?php echo url('index'); ?>" class="layui-btn layui-btn-primary">返回列表</a></td>
            </tr>
        </table>

    </form>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script type="text/javascript">
    layui.use(['form','jquery'], function () {
        var form = layui.form,$ = layui.jquery;
        form.on('submit(submit)', function (data) {
            $.post("<?php echo url(''); ?>", data.field, function (res) {
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

