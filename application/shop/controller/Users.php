<?php
namespace app\shop\controller;
use think\request;
use app\shop\controller\Common;
class Users extends Common{
    public function _initialize(){
        parent::_initialize();
    }
    //会员列表
    public function index(){
        if(request()->isPost()){
            $key=input('post.key');
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            $where['g.shop_id']=SHID;
            $list=model('UsersCardGet')->alias('g')
                ->join('users u','u.id = g.user_id','left')
                ->join('shop s','s.id = g.shop_id','left')
                ->field('u.username,u.mobile,u.sex,g.addtime')
                ->where($where)
                ->order('g.id desc')
                ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                ->each(function($row){
                    $row['addtime']=date('Y-m-d',$row['addtime']);
                })
                ->toArray();
            return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
        }
        return $this->fetch();
    }
    
    public function usersDel(){
        db('users')->delete(['id'=>input('id')]);
        db('user_oauth')->delete(['uid'=>input('id')]);
        return $result = ['code'=>1,'msg'=>'删除成功!'];
    }
    public function delall(){
        $map[] =array('id','IN',input('param.ids/a'));
        db('users')->where($map)->delete();
        $result['msg'] = '删除成功！';
        $result['code'] = 1;
        $result['url'] = url('index');
        return $result;
    }

    
}