<?php
namespace app\shop\controller;
use think\Db;
use think\Request;
use think\View;
use app\shop\model\Order as Od;
use app\shop\controller\Common;
class Order extends Common{
    protected  $model;
    public function _initialize(){
        parent::_initialize();
        $this->model = model('order');
    }
    //订单列表
    public function lists()
    {
        $status=input('status/d');
        if(Request::instance()->isAjax()){
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            $keyword=input('key');
            $where = [];
            if(!empty($keyword)){
               $where['o.order_sn|u.mobile|s.name'] = ['like','%'.$keyword.'%'];
            }
            if(!empty($status)){
                $where['o.status']=$status;
            }
            $where['o.shop_id']=SHID;
            $list = $this->model->alias('o')
                ->join('users u','u.id = o.user_id','LEFT')
                ->join('shop s','s.id = o.shop_id','LEFT')
                ->field('o.*,u.id as uid,u.mobile as umobile,s.id as sid,s.name as sname')
                ->order("o.id desc")
                ->where($where)
                ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                ->each(function($row){
                    $row['statusname']=get_status($row['status'],'order_status');
                    $row['pay_type']=get_status($row['pay_type'],'pay_type');
                    $row['add_time']=date('Y-m-d H:i:s',$row['add_time']);
                })->toArray();    
            return ['code'=>0,'msg'=>"获取成功",'data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
           
        }
        return $this->fetch();
    }
    /**
     * 发货
     **/
    function send(){
        if (Request::instance()->isAjax()) {
            $data=input('post.');
          
            if($data['send_type']==1 && !$data['expresscom']){
               return $this->resultmsg('请选择快递公司',0); 
            }
            if(empty($data['expresssn']) && $data['send_type']==1) {
                return $this->resultmsg('请填写有效快递单号',0);
            }
            $data['status']=3;
            $data['sendtime']=time();
            if($this->model->update($data)){
                return $this->resultmsg('提交成功',1);
            }
            return $this->resultmsg('提交失败',0);
        }
        $id=input('id/d');
        $info=$this->model->where(['id'=>$id])->field('mobile,address,id')->find();
        $this->assign('info',$info);
        return $this->fetch();
    }
    /**
     * 详情
     **/
    function info(){
        $id=input('id/d');
        $info=$this->model->where(['id'=>$id])->find();
        if ($info['status'] == 7) {
            $info['shtime']=Db::name('orderrefund')->where(['order_id'=>$id])->value('add_time');            
        }
        // $info['express_company']=config('system.express_company')[$info['expresscom']]['statusname'];
        $info['pay_type']=get_status($info['pay_type'],'pay_type');
        $goods=Db::name('orderGoods')->alias('og')
              ->join('goods g','g.id = og.goodsid','left')
              ->field('og.*,g.title,g.headimg')
              ->where(['og.order_sn'=>$info['order_sn']])
              ->select(); 
        $counts=0;      
        foreach ($goods as $k => $v) {
            $goods[$k]['headimg']=explode(',',$v['headimg'])[0];
            $goods[$k]['count']=$v['num']*$v['price'];
            $counts+=$goods[$k]['count'];
        }
        $info['counts']=$counts;
        $this->assign('goods',$goods);
        $this->assign('info',$info);
        return $this->fetch();
    }

    /**
     * 售后订单
     **/
    public function refund(){
        $model=model('orderrefund');
        if(Request::instance()->isAjax()){
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            $keyword=input('key');
            $where = [];
            if(!empty($keyword)){
               $where['o.order_sn|a.mobile|u.username'] = ['like','%'.$keyword.'%'];
            }
            if(!empty($status)){
                $where['o.status']=7;
            }
            $where['o.shop_id']=SHID;
            $list = $model->alias('a')
                ->join('order o','o.id = a.order_id','LEFT')
                ->join('users u','u.id = o.user_id','LEFT')
                ->join('shop s','s.id = o.shop_id','LEFT')
                ->join('goods g','g.id = a.goods_id','LEFT')
                ->field('a.*,o.pay_type,o.add_time oadd_time,o.status as ostatus,u.username,s.id as sid,s.name as sname,g.title,g.headimg')
                ->order("o.id desc")
                ->where($where)
                ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                ->each(function($row){
                    $row['pay_type']=get_status($row['pay_type'],'pay_type');
                    $row['add_time']=date('Y-m-d H:i:s',$row['add_time']);
                    $row['oadd_time']=date('Y-m-d H:i:s',$row['oadd_time']);
                    $row['headimg'] = '/'.explode(',',$row['headimg'])[0];
                    $row['statusname'] = get_status($row['status'],'check');
                })->toArray();    
            return ['code'=>0,'msg'=>"获取成功",'data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
            return $result;
        }
        return $this->fetch();
    }

    //设置商品审核状态
    public function setrefundstatus(){
        $map['id'] =array('in',input('post.id/a'));
        $data['status']=input('post.status/d');
        $data['shop_remark']=input('post.text/s');
        $data['do_time']=time();
        if(model('orderrefund')->where($map)->update($data)!==false){
            return $this->resultmsg('设置成功！',1);
        }
        return $this->resultmsg('设置失败！',0);
    }

    /**
     * 售后详情
     **/
    function refundinfo(){
        $id=input('id/d');
        $info=model('orderrefund')->where(['id'=>$id])->find();
        $goods=Db::name('orderGoods')->alias('og')
              ->join('goods g','g.id = og.goodsid','left')
              ->field('og.*,g.title,g.headimg')
              ->where(['og.id'=>$info['og_id']])
              ->select(); 
        $counts=0; 
        $info['imgs']=explode(',',$info['imgs']);
        $info['counts']=$goods[0]['num']*$goods[0]['price'];
        $this->assign('goods',$goods);
        $this->assign('info',$info);
        return $this->fetch();
    }
}
