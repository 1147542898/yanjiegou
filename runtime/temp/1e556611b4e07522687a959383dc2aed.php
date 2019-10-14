<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:83:"D:\phpstudy_pro\WWW\www.yanjie.com\public/../application/shop\view\index\index.html";i:1571023845;s:75:"D:\phpstudy_pro\WWW\www.yanjie.com\application\shop\view\Public\common.html";i:1571023845;s:71:"D:\phpstudy_pro\WWW\www.yanjie.com\application\shop\view\Public\js.html";i:1571023845;s:72:"D:\phpstudy_pro\WWW\www.yanjie.com\application\shop\view\Public\top.html";i:1571023845;s:77:"D:\phpstudy_pro\WWW\www.yanjie.com\application\shop\view\Public\leftmenu.html";i:1571023845;}*/ ?>
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

    <!-- 顶部开始 -->
    <div class="container">
    <div class="logo">
        <a href="./index.html"><img style="width: 20%" src="<?php echo \think\Session::get('sinfo.shlogo'); ?>"/> <?php echo \think\Session::get('sinfo.shname'); ?></a></div>
    <div class="left_open">
        <a><i title="展开左侧栏" class="iconfont">&#xe699;</i></a>
    </div>
    <!-- <ul class="layui-nav left fast-add" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">+新增</a>
            <dl class="layui-nav-child"> -->
                <!-- 二级菜单 -->
                <!-- <dd>
                    <a onclick="xadmin.open('最大化','http://www.baidu.com','','',true)">
                        <i class="iconfont">&#xe6a2;</i>弹出最大化</a></dd>
                <dd>
                    <a onclick="xadmin.open('弹出自动宽高','http://www.baidu.com')">
                        <i class="iconfont">&#xe6a8;</i>弹出自动宽高</a></dd>
                <dd>
                    <a onclick="xadmin.open('弹出指定宽高','http://www.baidu.com',500,300)">
                        <i class="iconfont">&#xe6a8;</i>弹出指定宽高</a></dd>
                <dd>
                    <a onclick="xadmin.add_tab('在tab打开','member-list.html')">
                        <i class="iconfont">&#xe6b8;</i>在tab打开</a></dd>
                <dd>
                    <a onclick="xadmin.add_tab('在tab打开刷新','member-del.html',true)">
                        <i class="iconfont">&#xe6b8;</i>在tab打开刷新</a></dd>
            </dl>
        </li>
    </ul> -->
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;"><?php echo \think\Session::get('sinfo.ursname'); ?></a>
            <dl class="layui-nav-child">
                <!-- 二级菜单 -->
                <dd>
                    <a onclick="xadmin.add_tab('个人信息','<?php echo url("auth/adminEdit"); ?>?admin_id=<?php echo \think\Session::get('sinfo.ursid'); ?>')">个人信息</a></dd>
                <dd>
                    <a href="<?php echo url('shop/index/logout'); ?>">切换帐号</a></dd>
                <dd>
                    <a href="<?php echo url('shop/index/logout'); ?>">退出</a></dd>
            </dl>
        </li>
        <!-- <li class="layui-nav-item to-index">
            <a href="/">前台首页</a></li> -->
        <li class="layui-nav-item to-clear">
            <a href="javascript:;" id="cache">清除缓存</a></li>    
    </ul>
</div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
    <!-- 左侧菜单开始 -->
    <div class="left-nav" style="top:0px;padding-top: 0px">
    <div class="layui-card" style="background:linear-gradient(to top,rgba(111, 111, 111, 1), rgba(4, 94, 82, 1));text-align: center">
        <div class="layui-card-body ">
         <div class="layui-block">
            <img style="width: 50%;border-radius: 50%;background:rgb(215, 228, 233)" src="<?php echo \think\Session::get('sinfo.shlogo'); ?>"/>
         </div>
         <div class="layui-block" style="line-height: 30px;height:30px;color:#FFF;font-size: 16px"><?php echo \think\Session::get('sinfo.shname'); ?></div>
         <div id="test-rate-dome9" class="layui-block"></div>
        </div>
    </div>
    <div id="side-nav">
        <ul id="nav">
            <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): if( count($menus)==0 ) : echo "" ;else: foreach($menus as $key=>$val): ?>
            <li>
                <a href="javascript:;">
                    <i class="fa <?php echo $val['icon']; ?>" lay-tips="<?php echo $val['title']; ?>"></i>
                    <cite><?php echo $val['title']; ?></cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <?php if(is_array($val['children']) || $val['children'] instanceof \think\Collection || $val['children'] instanceof \think\Paginator): if( count($val['children'])==0 ) : echo "" ;else: foreach($val['children'] as $key=>$vals): ?>
                    <li>
                        <a onclick="xadmin.add_tab('<?php echo $vals['title']; ?>','<?php echo $vals['href']; ?>')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite><?php echo $vals['title']; ?></cite></a>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</div>
<script>
  layui.use(['rate'], function(){
    var rate = layui.rate;

//只读
    rate.render({
      elem: '#test-rate-dome9'
      ,value: 4
      ,readonly: true
    });
})    
</script>
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
            <ul class="layui-tab-title">
                <li class="home">
                    <i class="layui-icon">&#xe68e;</i>我的桌面</li></ul>
            <div class="layui-unselect layui-form-select layui-form-selected" id="tab_right">
                <dl>
                    <dd data-type="this">关闭当前</dd>
                    <dd data-type="other">关闭其它</dd>
                    <dd data-type="all">关闭全部</dd></dl>
            </div>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <iframe src='<?php echo url('shop/index/main'); ?>' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
                </div>
            </div>
            <div id="tab_show"></div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <style id="theme_style"></style>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->



<!--js结束-->





</body>

</html>

