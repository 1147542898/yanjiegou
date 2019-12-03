<?php
namespace app\common\model;
use think\Model;
use think\Db;
class Shop extends Model{
     /**
      * 创建超级管理员
      **/
     public static function creatadmin($data){
     	//开启事务
        Db::startTrans();
	        unset($data['upfile']);
	        $admin_name=$data['admin_name'];
	        $admin_pwd=$data['admin_pwd'];
	        unset($data['admin_name']);
	        unset($data['admin_pwd']);
	        if (isset($data['headimg'])) {
	        	 $count = count($data['headimg']);//获取传过来有几张图片
		        if($count){
		            $data['headimg'] = implode(',',$data['headimg']);
		        }
	        }
	        $data['addtime']=time();
	        $res = self::insertGetId($data);
	        $list=Db::name('ShopAuthRule')->where('type=2')->field('id')->column('id','id');
	        $group_data=[
	            'shopid'=>$res,
	            'is_super'=>1,
	            'type'=>2,
	            'addtime'=>time(),
	            'rules'=>'0,'.implode(',',$list),
	            'title'=>'超级管理员',    
	     	];
	     	$group_id=Db::name('ShopAuthGroup')->insertGetId($group_data);
	     	$admin_data=[
	            'type'=>2,
	            'sid'=>$res,
	            'username'=>$admin_name,
	            'pwd'=>authcode($admin_pwd),
	            'group_id'=>$group_id,
	            'is_open'=>1,
	     	];
	     	$adminres=Db::name('ShopAdmin')->insert($admin_data);
     	if ($res && $group_id && $adminres){
     		 //如果全部成功,提交事务
            Db::commit();
            return true;
     	}else{
     		//如果失败,回滚事务
            Db::rollback();
            return false;
     	}
<<<<<<< HEAD
     }
=======
	 }
	 //资金流水变动
	 public function moneyChange($shop_id,$money,$type,$note){
		 $shop=self::get($shop_id);
		 if($type==0){
			$yue=$shop->shop_money+$money;
		 }else{
			$yue=$shop->shop_money-$money;
		 }
		//获取类型
		$data=array(
			'shopid'=>$shop_id,
			'addtime'=>time(),
			'money'=>$$money,
			'note'=>$note,
			'type'=>$type,
			'yue'=>$yue
		);
		$result=Db::name('shop_fund_log')->insert($data);
		if($result){
			$shop->save();
		}
	 }
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
}