<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"D:\phpstudy_pro\WWW\yanjiegou\public/../application/admin\view\index\main.html";i:1569466684;s:71:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\common.html";i:1569466684;s:67:"D:\phpstudy_pro\WWW\yanjiegou\application\admin\view\Public\js.html";i:1569466684;}*/ ?>
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
    
<style>
.layuiadmin-card-text .layui-text-top a,.layuiadmin-big-font {
    line-height: 24px;
    font-size: 18px;
    vertical-align: top;
}
.fa{margin-right: 10px;
    font-size: 24px;
    color: #009688;}
</style>    


</head>
<body>

<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
      <div class="layui-card">
        <div class="layui-card-body ">
          <blockquote class="layui-elem-quote">欢迎管理员：
            <span class="x-red"><?php echo \think\Session::get('seadmininfo.username'); ?></span>！当前时间:  <span id="clock" class="red"></span>
          </blockquote>
        </div>
      </div>
    </div>
    <div class="layui-col-md12">
      <div class="layui-card">
        <div class="layui-card-header">今日统计</div>
        <div class="layui-card-body ">
          <ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
            <li class="layui-col-md2 layui-col-xs6 " >
              <a href="javascript:;" class="x-admin-backlog-body bkcolor_orange">
                <h3>上架商品 / 待审核</h3>
                <p>
                  <cite><?php echo $data['tody']['goods1']; ?> / <?php echo $data['tody']['goods0']; ?></cite></p>
              </a>
            </li>
            <li class="layui-col-md2 layui-col-xs6">
              <a href="javascript:;" class="x-admin-backlog-body bkcolor_qing">
                <h3>今日新增订单</h3>
                <p>
                  <cite><?php echo $data['tody']['order']; ?></cite></p>
              </a>
            </li>
            <li class="layui-col-md2 layui-col-xs6">
              <a href="javascript:;" class="x-admin-backlog-body bkcolor_red">
                <h3>今日新增商圈</h3>
                <p>
                  <cite><?php echo $data['tody']['bshop']; ?></cite></p>
              </a>
            </li>
            <li class="layui-col-md2 layui-col-xs6">
              <a href="javascript:;" class="x-admin-backlog-body bkcolor_green">
                <h3>今日开店申请</h3>
                <p>
                  <cite><?php echo $data['tody']['shop1']; ?></cite></p>
              </a>
            </li>
            <li class="layui-col-md2 layui-col-xs6">
              <a href="javascript:;" class="x-admin-backlog-body bkcolor_purple">
                <h3>今日新增商家</h3>
                <p>
                  <cite><?php echo $data['tody']['shop2']; ?></cite></p>
              </a>
            </li>
            <li class="layui-col-md2 layui-col-xs6 ">
              <a href="javascript:;" class="x-admin-backlog-body bkcolor_blue">
                <h3>今日新增会员</h3>
                <p>
                  <cite><?php echo $data['tody']['users']; ?></cite></p>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="layui-col-sm6 layui-col-md2">
      <div class="layui-card">
        <div class="layui-card-header">
          <span class="layui-badge layui-bg-cyan layuiadmin-badge bkcolor_red">商圈</span></div>
        <div class="layui-card-body  ">
          <p class="layuiadmin-big-font red">总计：<?php echo $data['count']['bshop']; ?></p>
        </div>
      </div>
    </div>
    <div class="layui-col-sm6 layui-col-md2">
      <div class="layui-card">
        <div class="layui-card-header">
          <span class="layui-badge layui-bg-cyan layuiadmin-badge bkcolor_purple">商家</span></div>
        <div class="layui-card-body ">
          <p class="layuiadmin-big-font purple">总计：<?php echo $data['count']['shop2']; ?></p>
        </div>
      </div>
    </div>
    <div class="layui-col-sm6 layui-col-md2">
      <div class="layui-card">
        <div class="layui-card-header">
          <span class="layui-badge layui-bg-cyan layuiadmin-badge bkcolor_blue">商品</span></div>
        <div class="layui-card-body ">
          <p class="layuiadmin-big-font blue">总计：<?php echo $data['count']['goods1']; ?></p>
        </div>
      </div>
    </div>
    <div class="layui-col-sm6 layui-col-md2">
      <div class="layui-card">
        <div class="layui-card-header">
          <span class="layui-badge layui-bg-cyan layuiadmin-badge bkcolor_green">用户</span></div>
        <div class="layui-card-body ">
          <p class="layuiadmin-big-font green">总计：<?php echo $data['count']['users']; ?></p>
        </div>
      </div>
    </div>
    <div class="layui-col-sm6 layui-col-md2">
      <div class="layui-card">
        <div class="layui-card-header">
          <span class="layui-badge layui-bg-cyan layuiadmin-badge bkcolor_qing">订单</span></div>
        <div class="layui-card-body ">
          <p class="layuiadmin-big-font qing">总计：<?php echo $data['count']['order']; ?></p>
        </div>
      </div>
    </div>
    <div class="layui-col-sm6 layui-col-md2">
      <div class="layui-card">
        <div class="layui-card-header">
          <span class="layui-badge layui-bg-cyan layuiadmin-badge bkcolor_orange">交易额</span></div>
        <div class="layui-card-body ">
          <p class="layuiadmin-big-font orange">总计：<?php echo $data['count']['order_money']; ?></p>
        </div>
      </div>
    </div>
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-body ">
               
                <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
                <div id="main" style="width: 100%;height:400px;"></div>
               
            </div>
        </div>
    </div>

    <!-- <div class="layui-col-md12">
      <div class="layui-card">
        <div class="layui-card-header">系统信息</div>
        <div class="layui-card-body ">
          <table class="layui-table">
            <tbody>
            <tr>
              <th>xxx版本</th>
              <td>1.0.180420</td></tr>
            <tr>
              <th>服务器地址</th>
              <td>x.xuebingsi.com</td></tr>
            <tr>
              <th>操作系统</th>
              <td>WINNT</td></tr>
            <tr>
              <th>运行环境</th>
              <td>Apache/2.4.23 (Win32) OpenSSL/1.0.2j mod_fcgid/2.3.9</td></tr>
            <tr>
              <th>PHP版本</th>
              <td>5.6.27</td></tr>
            <tr>
              <th>PHP运行方式</th>
              <td>cgi-fcgi</td></tr>
            <tr>
              <th>MYSQL版本</th>
              <td>5.5.53</td></tr>
            <tr>
              <th>ThinkPHP</th>
              <td>5.0.18</td></tr>
            <tr>
              <th>上传附件限制</th>
              <td>2M</td></tr>
            <tr>
              <th>执行时间限制</th>
              <td>30s</td></tr>
            <tr>
              <th>剩余空间</th>
              <td>86015.2M</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="layui-col-md12">
      <div class="layui-card">
        <div class="layui-card-header">开发团队</div>
        <div class="layui-card-body ">
          <table class="layui-table">
            <tbody>
            <tr>
              <th>版权所有</th>
              <td>沿街购
                <a href="http://www.yanjiegou.com/" target="_blank">访问官网</a></td>
            </tr>
            <tr>
              <th>开发者</th>
              <td>沿街购技术团队</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <style id="welcome_style"></style>
    <div class="layui-col-md12">
      <blockquote class="layui-elem-quote layui-quote-nm">本系统由沿街购技术团队提供技术支持。</blockquote></div>
  </div> -->
</div>
</div>




<!--js结束-->

<script src="https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
          setInterval(function(){
              $("#clock").html("");
              var date=new Date();
              var month,dates,hours,min,seconds;
              month=(date.getMonth()+1);
              dates=date.getDate();
              hours=date.getHours();
              min=date.getMinutes();
              seconds=date.getSeconds();
              if(month<10){
                  month="0"+month;
              }
              if(dates<10){
                  dates="0"+dates;
              }
              if(hours<10){
                  hours="0"+hours;
              }
              if(min<10){
                  min="0"+min;
              }
              if(seconds<10){
                  seconds="0"+seconds;
              }
              week=new Array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
              var clocks=date.getFullYear()+"年"+month+"月"+dates+"日"+hours+":"+min+":"+seconds+" "+week[date.getDay()];
              $("#clock").append(clocks);
          },1000)
      })
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('main'));

        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '订单统计'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['交易额','订单数量']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: { 
                  show: true, 
                  feature: {saveAsImage: {},dataView: {show: true, readOnly: false}, magicType: {show: true, type: ['line', 'bar']}, } },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: [<?php echo $top; ?>]
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name:'交易额',
                    type:'line',
                    stack: '交易额',
                    color:'#DD4B39',
                    label: {
                        normal: {
                            show: true,
                            position: 'top'
                        }
                    },
                    //areaStyle: {normal: {}},
                    data:[<?php echo $bottom1; ?>]
                },
                {
                    name:'订单数量',
                    type:'line',
                    stack: '订单数量',
                    color:'#00CA6D',
                    label: {
                        normal: {
                            show: true,
                            position: 'top'
                        }
                    },
                    //areaStyle: {normal: {}},
                    data:[<?php echo $bottom2; ?>]
                },
            ]
        };


        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);

        
    </script>
   
    


</body>

</html>

