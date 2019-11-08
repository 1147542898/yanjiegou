<?php

namespace app\index\controller;

use think\Request;
use think\Db;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        $this->assign('logomoduleid', 111);
        $this->assign('albummoduleid', 112);
        return view();
    }



    //注册申请
    public function apply()
    {
        
        $appid=config("wchat.appid");
        $appsecret=config("wchat.appsecret");       
        if(input('code')){
            $code=input('code');
            $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
            $data=$this->httpUtil($oauth2Url);                
            $getInfo=json_decode($data,true);                     
            $access_token = $getInfo['access_token'];
            $openid = $getInfo['openid']; 
            $get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            $data=$this->httpUtil($get_user_info_url);
            $openid=$data['openid'];
            $shopinfo=Db::name("shop")->where(['openid'=>$openid])->find();
            if(empty($shopinfo)){

            }else{
                $this->ajax_error('已申请提交等待审核！');
            }
            $this->assign('openid',$openid);
            var_dump($data);
            exit;
        }else{
            $redirect_uri = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid . "&redirect_uri=" . $redirect_uri . "&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect";
            header("Location:" . $url);
        }
        
        exit;
       
    }
    //提交申请
    public function addapply(){
        $identity_photo=implode(',',input('identity_photo'));
        $yyzz=implode(',',input('yyzz'));
        $data=array(
            'name'=>input('name'),//商家名称
            'phone'=>input('phone'),//紧急联系人
            'shoplogo'=>input('shoplogo'),//商家logo
            'province'=>input('province'),//商家省份
            'city'=>input('city'),//商家城市
            'area'=>input('area'),//商家区域
            'street'=>input('street'),//街道
            'address'=>input('address'),//商家详细地址
            'longitude'=>input('longitude'),//经度
            'latitude'=>input('latitude'),//纬度
            'intro'=>input('intro'),//商家简介
            'identity_photo'=>$identity_photo,//商家身份证
            'yyzz'=>$yyzz,//商家营业执照
            'shortname'=>GetShortName(input('name')),//商家短名字
            'status'=>1,//申请状态      
            'openid'=>input('openid'),//商家openid      
            
        );
        $result=Db::name('shop')->insert($data);
        if($result){
            return $this->ajax_success('申请成功！');
        }else{
            return $this->ajax_error('申请失败');
        }
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
