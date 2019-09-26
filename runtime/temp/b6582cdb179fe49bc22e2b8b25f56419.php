<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"/www/wwwroot/svn.yanjiegou.com/public/../application/admin/view/recommend/shop.html";i:1562558749;s:72:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/common.html";i:1561105812;s:68:"/www/wwwroot/svn.yanjiegou.com/application/admin/view/Public/js.html";i:1562165964;}*/ ?>
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
<div class="layui-card">
<div class="layui-card-body ">
    <div class="layui-input-inline">
        <cascader id="demo1"></cascader>
        <button class="layui-btn">提交</button>
    </div>
    <div class="layui-container" style="margin-top: 15px;">
        <div id="root"></div>
        <div id="root1"></div>
    </div>
    <div class="layui-input-block" style="text-align: center;margin-top: 50px">
            <a class="layui-btn right">提交数据</a>
    </div>
</div>
</div>
</div>
</div>



<!--js结束-->

<script>
    layui.config({
        base: '/static/admin/lib/layui/extend/'
    }).use(['transfer','jquery','upload','layer','ajaxCascader'], function () {
        var transfer = layui.transfer;
            $ = layui.jquery;
            cascader = layui.ajaxCascader;
        //数据源=======================================================
        // var data1 = [{'id':'10001','name':'杜甫','sex':'男'},{'id':'10002','name':'李白','sex':'男'},{'id':'10003','name':'王勃','sex':'男'},{'id':'10004','name':'李清照','sex':'男'},{'id':'10001','name':'杜甫','sex':'男'},{'id':'10002','name':'李白','sex':'男'},{'id':'10003','name':'王勃','sex':'男'},{'id':'10004','name':'李清照','sex':'男'},{'id':'10001','name':'杜甫','sex':'男'},{'id':'10002','name':'李白','sex':'男'},{'id':'10003','name':'王勃','sex':'男'},{'id':'10004','name':'李清照','sex':'男'},{'id':'10001','name':'杜甫','sex':'男'},{'id':'10002','name':'李白','sex':'男'},{'id':'10003','name':'王勃','sex':'男'},{'id':'10004','name':'李清照','sex':'男'},{'id':'10001','name':'杜甫','sex':'男'},{'id':'10002','name':'李白','sex':'男'},{'id':'10003','name':'王勃','sex':'男'},{'id':'10004','name':'李清照','sex':'男'},{'id':'10001','name':'杜甫','sex':'男'},{'id':'10002','name':'李白','sex':'男'},{'id':'10003','name':'王勃','sex':'男'},{'id':'10004','name':'李清照','sex':'男'},{'id':'10001','name':'杜甫','sex':'男'},{'id':'10002','name':'李白','sex':'男'},{'id':'10003','name':'王勃','sex':'男'},{'id':'10004','name':'李清照','sex':'男'}];
        // var data2 = [{'id':'10005','name':'白居易','sex':'男'}];
        //表格列
        var cols = [{type: 'checkbox', fixed: 'left'},{field: 'id', title: 'ID', width: 80, sort: true},{field: 'name', title: '用户名'},{field: 'sex', title: '性别'}]
        //表格配置文件
        var tabConfig = {'page':true,'limits':[10,50,100],'height':700}
        var tb1 = transfer.render({
            elem: "#root", //指定元素
            cols: cols, //表格列  支持layui数据表格所有配置
            data: [], //[左表数据,右表数据[非必填]]
            tabConfig: tabConfig //表格配置项 支持layui数据表格所有配置
        })
        //transfer.get(参数1:初始化返回值,参数2:获取数据[all,left,right,l,r],参数:指定数据字段)
        //获取数据
        $('.alls').on('click',function() {
            var data = transfer.get(tb1,'all');
            layer.msg(data)
        });
        $('.left').on('click',function () {
            var data = transfer.get(tb1,'left','id');
            layer.msg(data)
        });
        $('.right').on('click',function () {
            var data = transfer.get(tb1,'right','');
            layer.msg(data)
        });

        //=================================多级联动=========================================
            // 直接赋值模式
            cascader.load({
                elem:'#demo1'                          
                ,value:0  
                ,getChildren:function(value,callback){  
                    var data = [];                  
                    $.ajax({                         
                        url:'<?php echo url("getcate"); ?>?pid='+value,
                        type:'get',
                        success:function(res){
                            data = res.data;
                            for(var i in data){
                                data[i].value = data[i].id;
                                data[i].label = data[i].name;
                                delete data[i].id;
                                delete data[i].name;
                                data[i].hasChild = true;
                            }
                            callback(data);
                        }
                    });
                }      
            });
            // 监听选中的事件
            cascader.on('click','#demo2',function(){
                // 获取当前已选中的数据,可单独使用
                console.log(cascader.getChooseData('#demo2'))
            });
    });
</script>



</body>

</html>

