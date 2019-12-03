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
class Char extends Base
{
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
    /*已读*/
    public function yesread(){
        $id = input('id');
        if (!empty($id)) {
            Db::name('chat')->where('id',$id)->update(['no_read' => 0]);
        }
        
    }
    public function sendmsg()
    {
    	$uid = input('uid');
    	$infouid = input('infouid');
		$msg = input('msg')?input('msg'):'';
<<<<<<< HEAD
		$type = input('type')?input('type'):0;
=======
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
    	if (empty($infouid) || empty($uid)) {
    		Gateway::sendToUid($uid,json_encode(['code'=>100,'msg'=>'缺少条件','type'=>'message','data'=>['uid'=>$uid,'infouid'=>$infouid]]));
    		die();
    	};
        if (strpos($uid,'user') !== false) {
            $user_id = str_replace('user','',$uid);
            $user = Db::name('users')->field('id as uid,username,avatar')->where('id',$user_id)->find();
            if (!$user) {
                return json(['code'=>100,'msg'=>'账号错误']);
            }
            $arr = [
                'uid'   =>  'user'.$user['uid'],
                'shopid'=>  $infouid,
                'name'  =>  $user['username'],
                'headimg'=> $user['avatar'],
            ];
        }
        if (strpos($uid,'shop') !== false) {
            $user_id = str_replace('shop','',$uid);
            $shop = Db::name('shop')->field('id as shopid,name,shoplogo')->where('id',$user_id)->find();
            if (!$shop) {
                return json(['code'=>100,'msg'=>'账号错误']);
            }
            $arr = [
                'uid'   =>  $infouid,
                'shopid'=>  'shop'.$shop['shopid'],
                'name'  =>  $shop['name'],
                'headimg'=> $shop['shoplogo'],
            ];
        }
// 聊天记录
<<<<<<< HEAD
        $info = $this->chat_log($uid,$infouid,$msg,$type);
=======
        $info = $this->chat_log($uid,$infouid,$msg);
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
        
        if ($info['chatlog_id']) {
            $arr['chat_id'] = $info['chat_id'];
            $arr['chatlog_id'] = $info['chatlog_id'];
            $arr['chat_noread'] = $info['chat_noread'];
            $data = [
                'code'  =>  0,
                'data'  =>  $arr,
                'msg'   =>  htmlspecialchars($msg),
                'type'  =>  'message',
            ];
            Gateway::sendToUid($infouid, json_encode($data));
			return json(['code'=>0,'msg'=>'已发送']);
		}
    }
<<<<<<< HEAD
    private function chat_log($uid,$infouid,$text,$type)
=======
    private function chat_log($uid,$infouid,$text)
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
    {
        $data = [
            'uid'   =>  $uid, 
            'infouid'   =>  $infouid,
            'content'       =>  $text,
            'add_time'  =>  time(),
<<<<<<< HEAD
            'type'	=>	$type
=======
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
        ];
        $info['chatlog_id'] = Db::name('chatLog')->insertGetId($data);
        
        $find = Db::name('chat')->where('uid',$uid)->where('infouid',$infouid)->find();
        if (!$find) {
            $list = [
                'uid'  =>  $uid,
                'infouid'=> $infouid,
                'no_read'=> 1
            ];
            $info['chat_id']=Db::name('chat')->insertGetId($list);
            $info['chat_noread'] = 1;
        }else{
            Db::name('chat')->where('id',$find['id'])->setInc('no_read');
            $info['chat_id'] = $find['id'];
            $info['chat_noread'] = $find['no_read']+1;
        }
		return $info;
    }
    
}