<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:82:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\recommend\shop.html";i:1569550119;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
                    <button class="layui-btn btns">提交</button>
                </div>
                <div class="layui-container" style="margin-top: 15px;">
                    <div id="test1"></div>
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
        transfer = layui.transfer;
        $ = layui.jquery;
        cascader = layui.ajaxCascader;
        var data=<?php echo $list; ?>;
        var value=<?php echo $arr; ?>;         
        var options={
            elem:'#test1',
            title:['未推荐','已推荐'],
            showSearch:true,
            data:data,
            value:value,
            onchange:function(obj,index){
                var ids=[];
                for(var i=0 in obj){
                    ids +=obj[i]['value']+",";
                }
                $.post("<?php echo url('shop'); ?>",{data:ids,status:index}, function (res) {
                    if (res.code) {
                        layer.msg(res.msg, {time: 1800, icon: 1});
                    } else {
                        layer.msg(res.msg, {time: 1800, icon: 2});
                    }
                });   
            }
        };
        transfer.render(options);      
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
        $(".btns").on('click',function(){    
            var category=cascader.getChooseData('#demo1');                
            $.ajax({                         
                url:'<?php echo url("recommend/getShopByCategory"); ?>',
                type:'post',
                dataType:'json',
                async: false,
                data:{
                    data:category.join(",")
                },
                success:function(res){
                    if(res.code){                                          
                        data=res.list;                       
                        value=res.arr; 
                        var options={
                            elem:'#test1',
                            title:['未推荐','已推荐'],
                            showSearch:true,
                            data:data,
                            value:value,
                            onchange:function(obj,index){
                                var ids=[];
                                for(var i=0 in obj){
                                    ids +=obj[i]['value']+",";
                                }
                                $.post("<?php echo url('shop'); ?>",{data:ids,status:index}, function (res) {
                                    if (res.code) {
                                        layer.msg(res.msg, {time: 1800, icon: 1});
                                    } else {
                                        layer.msg(res.msg, {time: 1800, icon: 2});
                                    }
                                });   
                            }
                        };
                        transfer.render(options)
                    }else{
                        layer.msg(res.msg, {time: 1800, icon: 2});
                    }
                }
            });
        });
    });   
  
</script>



</body>

</html>

