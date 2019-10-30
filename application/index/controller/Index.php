<?php

namespace app\index\controller;

use think\Request;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架1</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ad_bd568ce7058a1091"></think>';
    }



    //注册申请
    public function apply()
    {
        $appid = "wx4d7fa47003d86b9e";
        $appsecret="3721c1001b3163f514fdcbe6fa748864";
        if(input('code')){
            $code=input('code');
            $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
            $data=$this->httpUtil($oauth2Url);                
            $getInfo=json_decode($data,true);                     
            $access_token = $getInfo['access_token'];
            $openid = $getInfo['openid'];  
            var_dump($getInfo);
            $get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            $data=$this->httpUtil($get_user_info_url);
            var_dump($data);
            exit;
        }else{
            $redirect_uri = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid . "&redirect_uri=" . $redirect_uri . "&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect";
            header("Location:" . $url);
        }
        
        exit;
       
    }
    public function httpUtil($url, $data = '', $method = 'GET')
    {
        try {

            $curl = curl_init(); // 启动一个CURL会话
            curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
            curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
            if ($method == 'POST') {
                curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
                if ($data != '') {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
                }
            }
            curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
            curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
            $tmpInfo = curl_exec($curl); // 执行操作
            curl_close($curl); // 关闭CURL会话
            return $tmpInfo; // 返回数据
        } catch (Exception $e) { }
    }
}
