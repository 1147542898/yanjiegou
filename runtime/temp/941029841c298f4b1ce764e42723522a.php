<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\fsale\share_order.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
    
<style type="text/css">
.layui-table tr td{
    border;solid 1px #CCC
}
.layui-table tr td .layui-row{
    border:solid 1px #EEE;
}
.layui-table tr td div img{
    height:50px;
    width:50px;
    margin: 5px;
}
.red{margin-right: 20px}
</style>


</head>
<body>

<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-body">
    <fieldset class="layui-elem-field layui-field-title">
        <legend><?php echo lang('shareorder'); ?>管理</legend>
    </fieldset>
    <div class="demoTable">
        <div class="layui-inline">
            <input class="layui-input" name="key" id="key" placeholder="<?php echo lang('pleaseEnter'); ?>关键字">
        </div>
        <button class="layui-btn" id="search" data-type="reload"><?php echo lang('search'); ?></button>
        <a href="<?php echo url('type'); ?>" class="layui-btn">显示全部</a>
        <div style="clear: both;"></div>
    </div>
    <table class="layui-table">
       <tr><th>商品信息</th><th>金额</th><th>订单状态</th><th>分销情况</th></tr>
    </table>
    <table class="layui-table">
        <tr>
            <td>
                <div class="layui-row">
                    <div class="layui-col-md2"><img src="/uploads/20190313/e1a73ec370cc30e147e7755eace02ee3.jpg"></div>
                    <div class="layui-col-md10">
                       <span class="red">纳元液</span><br/>
                       规格： <span class="red">规格 :默认</span> 数量： <span class="red">1件</span><br/>
                       小计： <span class="red">998.00元</span><br/>
                    </div>
                </div>
            </td>
            <td>
                下单时间：<span class="red">2019-05-15 09:16:00</span><br/>
                状态：<span class="red">已付款</span> <span class="red">已收货</span><br/>
                订单号：<span class="red">20190515091600583692</span><br/>
                用户：<span class="red">心在江湖 </span><br/>
                订单类型：<span class="red">商城订单</span><br/>
                实际付款：<span class="red">998.00元</span><br/>
            </td>
            <td>
                快递单号：<span class="red">123123123123</span><br/>
                快递公司：<span class="red">申通</span><br/>
                收货人：<span class="red">王五【13211114422】</span> <br/>
                地址：<span class="red">北京市北京市朝阳区地址不详</span></td>
            <td>
                <p>昵称：<span class="red">codeHero</span>姓名：<span class="red">王五</span>一级佣金：<span class="red">50元</span></p>
                <p>昵称：<span class="red">codeHero</span>姓名：<span class="red">王五</span>二级佣金：<span class="red">50元</span></p>
        </td></tr>
        <tr><td colspan="4">备注：asdfkasdklfajsldfaskldfasdklfjaskldfjaskldfjaklsdjfklasjdkl</td></tr>
    </table>
</div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script>
    layui.use('table', function() {
        var table = layui.table, $ = layui.jquery;
       
        //搜索
        $('#search').on('click', function () {
            var key = $('#key').val();
            if ($.trim(key) === '') {
                layer.msg('<?php echo lang("pleaseEnter"); ?>关键字！', {icon: 0});
                return;
            }
            tableIn.reload({
                where: {key: key}
            });
        });
        //排序
        $('body').on('blur','.list_order',function() {
            var type_id = $(this).attr('data-id');
            var sort = $(this).val();
            var loading = layer.load(1, {shade: [0.1, '#fff']});
            $.post('<?php echo url("typeOrder"); ?>',{type_id:type_id,sort:sort},function(res){
                layer.close(loading);
                if(res.code === 1){
                    layer.msg(res.msg, {time: 1000, icon: 1});
                    tableIn.reload();
                }else{
                    layer.msg(res.msg,{time:1000,icon:2});
                }
            })
        });
        table.on('tool(list)', function(obj) {
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('您确定要删除该广告分类吗？', function(index){
                    var loading = layer.load(1, {shade: [0.1, '#fff']});
                    $.post("<?php echo url('delType'); ?>",{type_id:data.type_id},function(res){
                        layer.close(loading);
                        if(res.code===1){
                            layer.msg(res.msg,{time:1000,icon:1});
                            tableIn.reload();
                        }else{
                            layer.msg('操作失败！',{time:1000,icon:2});
                        }
                    });
                    layer.close(index);
                });
            }
        });
    });
</script>



</body>

</html>
