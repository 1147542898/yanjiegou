<?php

namespace app\index\controller;

use think\Request;
use think\Db;
use think\Controller;
use think\Session;

class Index extends Controller
{
    public function index()
    {
        $this->assign('logomoduleid', 111);
        $this->assign('albummoduleid', 112);
        if(!Session::get('openid')){
            $openid=$this->getShopUserOpenid();
            Session::set('openid',$openid);
        }
        $openid=Session::get('openid'); //获取openid
        $shop_info=Db::name("shop")->where(['openid'=>$openid])->find();
        if(!empty($info)){
            $this->assign('is_apply',1);//已申请           
        }else{
            $this->assign('is_apply',0);
        }
        $this->assign('openid',$openid);      
        return view();
    }



    //获取用户openid
    public function getShopUserOpenid()
    {
        
        $appid=config("wchat.appid");
        $appsecret=config("wchat.appsecret");       
        if(input('code')){
            $code=input('code');
            $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
            $data=$this->httpUtil($oauth2Url);                
            $getInfo=json_decode($data,true);       
            $openid = $getInfo['openid'];            
            return $openid;
          
        }else{
            $redirect_uri = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid . "&redirect_uri=" . $redirect_uri . "&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect";
            header("Location:" . $url);
        }
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
            'bphone'=>input('bphone'),//备用电话  
            
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
