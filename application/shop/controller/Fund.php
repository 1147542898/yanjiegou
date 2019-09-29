<?php

namespace app\shop\controller;

use think\Db;
use think\Request;
use think\View;
use app\shop\controller\Common;

class Fund extends Common {

    protected $now, $log;

    public function _initialize() {
        parent::_initialize();
        $this->now = model('ShopFundNow');
        $this->log = model('ShopFundLog');
        $this->order = model('Order');
    }

    //申请列表
    public function nows() {
        if (Request::instance()->isAjax()) {
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $map['a.shopid'] = SHID;
            $list = $this->now->alias('a')
                            ->join('shop s', 's.id = a.shopid', 'LEFT')
                            ->join('admin ad', 'ad.admin_id = a.douid', 'LEFT')
                            ->field('a.*,s.name as shopname,ad.username as dousername')
                            ->where($map)
                            ->order("id desc")
                            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                            ->each(function($row) {
                                        $row['status'] = get_status($row['status'], 'check');
                                        $row['addtime'] = date('Y-m-d H:i:s', $row['addtime']);
                                        $row['dotime'] = $row['dotime'] ? date('Y-m-d H:i:s', $row['dotime']) : '-';
                                    })->toArray();
            return ['code' => 0, 'msg' => "获取成功", 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        return $this->fetch();
    }

    //添加申请
    public function add() {
        if (Request::instance()->isAjax()) {
            $data = input('post.');
            $data['shopid'] = SHID;
            $data['addtime'] = time();
            $data['status'] = 0;
            $res = $this->now->insert($data);
            if ($res) {
                $result['code'] = 1;
                $result['msg'] = '添加成功!';
                return $result;
            } else {
                $result['code'] = 0;
                $result['msg'] = '添加失败!';
                return $result;
            }
        } else {
            return $this->fetch();
        }
    }

    //资金列表
    public function logs() {
        if (Request::instance()->isAjax()) {
            $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : config('pageSize');
            $map['shopid'] = SHID;
            $list = $this->log
                            ->where($map)
                            ->order("id desc")
                            ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                            ->each(function($row) {
                                        $row['addtime'] = date('Y-m-d H:i:s', $row['addtime']);
                                        $row['type'] = get_status($row['type'], 'shop_fund_log_type');
                                    })->toArray();
            return ['code' => 0, 'msg' => "获取成功", 'data' => $list['data'], 'count' => $list['total'], 'rel' => 1];
        }
        return $this->fetch();
    }

    //订单结算列表
    public function order() {
//        if (Request::instance()->isAjax()) {
            $where['shop_id'] = SHID;
             $page = input('page') ? input('page') : 1;
            $pageSize = input('limit') ? input('limit') : 5;
            $list =$this->order
                    ->where($where)
                    ->paginate(array('list_rows' => $pageSize, 'page' => $page))
                    ->toArray();
              return ['code'=>0,'msg'=>'获取成功！','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
//        } else {
//            return $this->fetch();
//        }
    }
    
    //资金账户列表
    public  function bank(){
        if(Request::instance()->isAjax()){
            $banks=Db::name('shop_bank')
                    ->where(['shop_id'=>SHID])                    
                    ->select();
            foreach($banks as &$v){
                if($v['type']==0){
                    $v['type']="银行卡";
                }
            }
            return ['code'=>0,'msg'=>'获取成功','data'=>$banks];
        }else{
            return $this->fetch(); 
        }       
       
    }
    //添加账户列表
    public function addBank(){
        if(Request::instance()->isAjax()){
            $data=input("post.");
            $data['shop_id']=SHID;
            $result=Db::name('shop_bank')->insert($data);
            if($result){
                return ['code'=>1,'msg'=>"添加成功！"];
            }else{
                return ['code'=>0,'msg'=>"添加失败！"];
            }
        }else{
            return $this->fetch();
        }
        
    }
    //编辑账户信息
    public function editBank(){
        if(Request::instance()->isAjax()){
            $data=input("post.");
            $result=Db::name("shop_bank")->update($data);
            if($result){
                return ['code'=>1,'msg'=>"修改成功！"];
            }else{
                return ['code'=>0,'msg'=>'修改失败'];
            }
        }else{
          $id=input('id');
          $banks=Db::name('shop_bank')->find($id);
          $this->assign('banks',$banks);
          return $this->fetch();
        }
    }
    //删除账户
    public function deleteBank(){
        $result=Db::name("shop_bank")->where(['id'=>input('id'),'shop_id'=>SHID])->delete();        
        if($result){
            return ['code'=>1,'msg'=>'删除成功！'];
        }else{
            return ['code'=>0,'msg'=>'删除失败！'];
        }
    }
    

}