<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"/www/wwwroot/svn.yanjiegou.com/public/../application/bigshop/view/login/index.html";i:1561644920;}*/ ?>
<!doctype html>
<html  class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>沿街购登录页</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/static/admin/css/font.css">
    <link rel="stylesheet" href="/static/admin/css/login.css">
      <link rel="stylesheet" href="/static/admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-bg">
    
    <div class="login layui-anim layui-anim-up">
        <div class="message" style="font-size: 24px; background-color: #f35343">沿街购-商圈端登录</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form" >
            <input name="username" placeholder="用户名" value="" type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" value="123123" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <div class="layui-form-item">
                <input type="text" name="vercode" id="captcha" lay-verify="required" placeholder="验证码" autocomplete="off" class="layui-input">
                <div class="captcha">
                    <img src="<?php echo url('verify'); ?>" alt="captcha" onclick="this.src='<?php echo url("verify"); ?>?'+'id='+Math.random()"/>
                </div>
            </div>
            <input value="登录"  lay-submit id="btn" lay-filter="login" style="width:100%; background-color: #f35343" type='button'>
            <hr class="hr20" >
        </form>
    </div>

    <script>
        $(function  () {
            layui.use('form', function(){
              var form = layui.form;
              form.on('submit(login)', function (data) {
                var loading = layer.load(1, {shade: [0.1, '#fff']});
                $.post("<?php echo url("","",true,false);?>", data.field, function (res) {
                    layer.close(loading);
                    if (res.code > 0) {
                        layer.msg(res.msg, {time: 1800, icon: 1}, function () {
                            location.href = "<?php echo url('bigshop/index/index'); ?>";
                        });
                    } else {
                        layer.msg(res.msg, {time: 1800, icon: 2}, function () {
                            location.reload();
                        });
                    }
                });
            });
            });
        })
        $(document).keydown(function (e) {
            if (e.keyCode === 13) {
                    $("#btn").trigger("click");
                }
        });
    </script>
    <!-- 底部结束 -->
</body>
</html>