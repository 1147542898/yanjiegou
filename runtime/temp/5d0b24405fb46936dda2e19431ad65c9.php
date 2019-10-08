<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:88:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/shop\view\statistic\membertrend.html";i:1569466684;s:70:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\common.html";i:1569466684;s:66:"D:\phpstudy_pro\WWW\yanjiegou\application\shop\view\Public\js.html";i:1569466684;}*/ ?>
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
    
<style>
.layui-table tr td:nth-child(1){width:100px;text-align:right;font-weight: bold;}
.layui-table,tr,td{border:0;}
</style>


</head>
<body>

<div class="layui-fluid">
<div class="layui-row layui-col-space15">
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-body">
     <div class="layui-card">
        <form action="<?php echo url(); ?>" method="get">
        <div class="layui-inline layui-show-xs-block">
          <label class="layui-form-label">选择时间</label>
        </div>  
        <div class="layui-inline layui-show-xs-block">
            <input type="text" class="layui-input" name="date" id="test-laydate-format-range1" value="<?php echo $date; ?>" placeholder=" ~ ">        
        </div>
        <div class="layui-inline layui-show-xs-block">
            <button class="layui-btn" id="search" data-type="reload" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </div>
        </form>
    </div>
	<!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
	<div id="main" style="width: 100%;height:400px;"></div>
	<blockquote class="layui-elem-quote">
	    
	</blockquote>



<!--js结束-->

<script type="text/javascript">
    layui.use(['form','laydate','jquery'], function () {
        var form = layui.form,
            laydate = layui.laydate,
            $ = layui.jquery
            laydate.render({
              elem: '#test-laydate-format-range1'
              ,range: '~'
            });
    });
</script>
<script src="https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script>
<script type="text/javascript">
// 基于准备好的dom，初始化echarts实例
var myChart = echarts.init(document.getElementById('main'));
// 指定图表的配置项和数据
var option = {
    title: {
        text: '会员增长趋势'
    },
    tooltip: {
        trigger: 'axis'
    },
    legend: {
        data:['邮件营销',]
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    toolbox: { show: true, feature: {saveAsImage: {},dataView: {show: true, readOnly: false}, magicType: {show: true, type: ['line', 'bar']}, } },
    xAxis: {
        type: 'category',
        boundaryGap: false,
        data: [<?php echo $top; ?>]
    },
    yAxis: {
        type: 'value',
        minInterval: 1
    },
    series: [
        {
            name:'总计',
            type:'line',
            stack: '总价',
            label: {
                normal: {
                    show: true,
                    position: 'top'
                }
            },
            areaStyle: {normal: {}},
            data:[<?php echo $bottom; ?>]
        },
    ]
};
// 使用刚指定的配置项和数据显示图表。
myChart.setOption(option);
</script>



</body>

</html>

