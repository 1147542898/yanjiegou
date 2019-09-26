<?php
namespace app\admin\controller;
use think\Db;
use app\admin\controller\Common;
class Recommend extends Common{
    public function _initialize(){
        parent::_initialize();
        $this->assign('moduleid',116);
    }

    /**
     * 推荐商圈
     **/
    public  function  bshop(){
    	$list=Db::name('bigshop')->field('id,name title,is_home')->select();
    	$arr=[];
        foreach ($list as $key => $value) {
        	if ($value['is_home']) {
        		$arr[]=$value['id'];
        		unset($list[$key]);
        	}
        }
        dump(implode(',', $arr));
        $this->assign('list',json_encode($list));
        $this->assign('arr',json_encode($arr));
        return $this->fetch();
    }

    public function getcate(){
    	$pid=input('pid');
    	$cate=Db::name('GoodsCategory')->where('parentid='.$pid)->field('id,catname name')->select();
        return json(['data'=>$cate]);
    }
    /**
     * 推荐商家
     **/
    public  function  shop(){
    	return $this->fetch();
    }
    /**
     * 推荐商品
     **/
    public  function  goods(){
    	return $this->fetch();
    }
}
