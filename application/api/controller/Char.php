<?php
namespace app\api\controller;
use think\Controller;
use think\Db;

//加载GatewayClient。关于GatewayClient参见本页面底部介绍
require_once __DIR__ . '/../../../vendor/GatewayClient/Gateway.php';
// GatewayClient 3.0.0版本开始要使用命名空间
use GatewayClient\Gateway;
// 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值(ip不能是0.0.0.0)
Gateway::$registerAddress = '127.0.0.1:1238';



class Index extends Base
{
    // public function index()
    // {
    //     return $this->fetch();
    // }
    public function msglog()
    {
		$uid = input('uid');
    	$infouid = input('infouid');
    	
    	if (empty($infouid) || empty($uid)) {
    		return json_encode(['code'=>100,'msg'=>'缺少条件']);
    	}



    	$data = Db::name('chatLog')
    			->where("(`uid` = '$uid' AND `infouid` = '$infouid') OR (`uid` = '$infouid' AND `infouid` = '$uid')")
				->whereTime('add_time','-3 month')
    			->select();
    	$arr = ['code'=>0,'data'=>$data];
    	return json($arr);
    }
	public function info()
    {
        return $this->fetch();
    }
    /**
	* 绑定uid
    */
    public function bind()
    {
    	$client_id = input('client_id');
    	$uid = input('uid');

    	if (empty($client_id) || empty($uid)) {
    		return json(['code'=>100,'msg'=>'缺少条件','data'=>'','url'=>'']);
    		die();
    	};
    	Gateway::bindUid($client_id, $uid);
    	$message = json_encode(['code'=>0,'msg'=>'绑定成功']);
    	Gateway::sendToUid($uid, $message);
    }

    public function sendmsg()
    {
    	$uid = input('uid');
    	$infouid = input('infouid');


		$msg = input('msg');
    	if (empty($infouid) || empty($uid)) {
    		Gateway::sendToUid($uid,json_encode(['code'=>100,'msg'=>'缺少条件','type'=>'message','data'=>['uid'=>$uid,'infouid'=>$infouid]]));
    		die();
    	};

    	$data = [
    		'code'	=>	0,
    		'data'	=>	['uid'=>$uid,'infouid'=>$infouid],
    		'msg'	=>	htmlspecialchars($msg),
    		'type'	=>	'message',
    	];
		Gateway::sendToUid($infouid, json_encode($data));

		$res = $this->chat_log($uid,$infouid,$msg);
		if ($res) {
			return json(['code'=>0,'msg'=>'已发送']);
		}
    }
    private function chat_log($uid,$infouid,$text)
    {
    	$data = [
    		'uid'	=>	$uid, 
    		'infouid'	=>	$infouid,
    		'content'		=>	$text,
    		'add_time'	=>	time(),
    	];

		$res = Db::name('chatLog')->insert($data);
		return $res;
    }
    
}
