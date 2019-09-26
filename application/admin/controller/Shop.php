<?php
namespace app\admin\Controller;
use think\Db;
use think\Request;
use ensh\Leftnav;
use app\api\controller\Base;
use app\admin\controller\Common;
class Shop extends Common{
    protected  $model;
    public function _initialize(){
        parent::_initialize();
        $this->model=model('shop');
        $this->assign('logomoduleid',111);
        $this->assign('albummoduleid',112);
    }
    /*
     * 商家列表
     */
    public function index(){
        if(Request::instance()->isAjax()){
            $keyword=input('key');
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            $map=[];
            if(!empty($keyword) ){
                $map['s.name']=array('like','%'.$keyword.'%');
            }
            $list = $this->model->alias('s')
                    ->join('bigshop bs','bs.id = s.bshopid','LEFT')
                    ->where($map)
                    ->order('s.sort desc')
                    ->field('s.*,bs.name as bname')
                    ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                    ->each(function($row){
                        $row['statusname']=get_status($row['status'],'check');
                        $row['lock_name']=get_status($row['is_lock'],'shop_is_lock');
                        $row['myaddress'] = $row['province'].$row['city'].$row['area'].$row['street'].$row['address'];
                    }) 
                    ->toArray();
            $rsult['code'] = 0;
            $rsult['msg'] = "获取成功";
            $lists = $list['data'];
            $rsult['data'] = $lists;
            $rsult['count'] = $list['total'];
            $rsult['rel'] = 1;
            return $rsult;
        }else{
            return $this->fetch();
        }
    }
    public function add(){
        if(Request::instance()->isAjax()){
            $data = input('post.');
            $msg = $this->validate($data,'Shop');
            if($msg!='true'){
                return $result = ['code'=>0,'msg'=>$msg];
            }
            $ad_data=['username'=>$data['admin_name'],'pwd'=>$data['admin_pwd']];
            $msg = $this->validate($ad_data,'ShopAdmin');
            if($msg!='true'){
                return $result = ['code'=>0,'msg'=>$msg];
            }
            $data['shortname']=GetShortName($data['name']);
            $res = model('shop')::creatadmin($data);
            if($res){
                $result['code'] = 1;
                $result['msg'] = '添加商家成功!';
                $result['url'] = url('admin/shop/index');
                return $result;
            }else{
                $result['code'] = 0;
                $result['msg'] = '添加商家失败!';
                $result['url'] = url('admin/shop/index');
                return $result;
            }
        }else{
            $arealist = Base::provice();
            $this->assign('arealist',$arealist);
            $bshop=model('bigshop')->field('id,name')->select();
            $this->assign('bshop',$bshop);
            return $this->fetch();
        }
    }
    //获取子地区
    public function getchildarea(){
        $parent_id = request()->post('parent_id');
        $putype = request()->post('putype');
        Base::getchildareamy($parent_id,$putype);
    }
    //商家审核
    public function uncheck()
    {
        if(Request::instance()->isAjax()){
            $keyword=input('key');
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            $map=[];
            //状态  1 审核中   2 审核通过  3  审核失败
            $map['status'] = 1;
            if(!empty($keyword) ){
                $map['name']=array('like','%'.$keyword.'%');
            }
            //$list=db('bigshop')->where($map)->order('sort desc')->paginate(array('list_rows'=>$pageSize,'page'=>$page))->toArray();
            $list = $this->model->where($map)->order('sort desc')->paginate(array('list_rows'=>$pageSize,'page'=>$page))->toArray();
            foreach($list['data'] as $k=>$v){
                $list['data'][$k]['shoplogo'] = '/'.$v['shoplogo'];
                $list['data'][$k]['myaddress'] = $v['province'].$v['city'].$v['area'].$v['street'].$v['address'];
            }
            $rsult['code'] = 0;
            $rsult['msg'] = "获取成功";
            $lists = $list['data'];
            //dump($list);
            $rsult['data'] = $lists;
            $rsult['count'] = $list['total'];
            $rsult['rel'] = 1;
            return $rsult;
        }else{
            return $this->fetch();
        }
    }
    //审核原因
    public function verify()
    {
        $result = [];
        if(Request::instance()->isAjax()){
            $id = input('post.id');
            $verify_reason = input('post.verify_reason');
            $status = input('post.status');
            $data = [
                'verify_reason'=>$verify_reason,
                'status'=>$status
            ];
            $res = $this->model->save($data,['id' => $id]);
            if($res){
                $result['code'] = 200;
                $result['msg'] = 'ok';
                echo json_encode($result,true);
            }else{
                $result['code'] = 0;
                $result['msg'] = 'no';
                echo json_encode($result,true);
            }
        }
    }
    public function edit(){
        if(Request::instance()->isAjax()){
            $data = input('post.');
            unset($data['upfile']);
            
            $count = count($data['headimg']);//获取传过来有几张图片
            if($count){
                $data['headimg'] = implode(',',$data['headimg']);
            }
            $data['shortname']=GetShortName($data['name']);
            $msg = $this->validate($data,'Shop');
            if($msg!='true'){
                return $result = ['code'=>0,'msg'=>$msg];
            }
            $res = $this->model->save($data,['id' => input('post.id')]);
            if($res){
                $result['code'] = 1;
                $result['msg'] = '修改商家成功!';
                $result['url'] = url('admin/shop/index');
                return $result;
            }else{
                $result['code'] = 0;
                $result['msg'] = '修改商家失败!';
                $result['url'] = url('admin/shop/index');
                return $result;
            }
        }else{
            $id=input('id');
            $info=$this->model->where(array('id'=>$id))->find()->toArray();
            $headimg = explode(',',$info['headimg']);
            foreach($headimg as $k=>$v){
                if(!is_object($v)){
                    $info['src'][] = $v;
                }
            }
            $this->assign('info',$info);
            $arealist = Base::provice();
            $this->assign('arealist',$arealist);
            $bshop=model('bigshop')->field('id,name')->select();
            $this->assign('bshop',$bshop);
            return $this->fetch();
        }
    }
    /*
     * 设置商家状态
     */
    public function bigshopState(){
        $id=input('post.id');
        $status=input('post.status');
        $info=db('bigshop')->where('id='.$id)->update(['status'=>$status]);
        if($info){
            $result['code'] = 1;
            $result['msg'] = '设置成功!';
        }else{
            $result['code'] = 0;
            $result['msg'] = '设置失败!';
        }
        return $result;
    }
    /*
     * 排序
     */
    public function listorder(){
        $model =db('bigshop');
        $data = input('post.');
        $model->update($data);
        $result = ['msg' => '排序成功！','url'=>url('shop/index'), 'code' => 1];
        return $result;
    }
    /*
     * 单个删除
     */
    public function listDel(){
        $id = input('post.id');
       $res = $this->model->where('id',$id)->delete();
       if($res){
           return ['code'=>1,'msg'=>'删除成功！'];
       }else{
           return ['code'=>0,'msg'=>'删除失败！'];
       }
    }
    /*
     * 多个删除
     */
    public function delAll(){
        $id=input('post.ids/a');
        $id=implode(",",$id);
        $model = db('shop');
        $model->where("id in ($id)")->delete();
        $result['code'] =1;
        $result['msg'] ='删除成功！';
        return $result;
    }
   //申请列表
    public function nows(){
        if(Request::instance()->isAjax()){
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            $map=[];
            $list = model('ShopFundNow')->alias('a')
                ->join('shop s','s.id = a.shopid','LEFT')
                ->join('admin ad','ad.admin_id = a.douid','LEFT')
                ->field('a.*,s.name as shopname,ad.username as dousername')
                ->where($map)
                ->order("id desc")
               ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                ->each(function($row){
                    $row['statusname']=get_status($row['status'],'check');
                    $row['addtime']=date('Y-m-d H:i:s',$row['addtime']);
                    $row['dotime']=$row['dotime']?date('Y-m-d H:i:s',$row['dotime']):'-';
                })->toArray();
            return ['code'=>0,'msg'=>"获取成功",'data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
        }
        return $this->fetch();
    }
    public function fundnowdo(){
        $data['id']=input('post.id/d');
        $data['status']=input('post.status/d');
        if ($data['status']==1) {
            $data['info']=input('post.info/s');
        }
        $data['douid']=session('aid');
        $data['dotime']=time();
        if(model('ShopFundNow')->update($data)){
            $result['code'] =1;
            $result['msg'] ='成功！';
            return $result;
        }
        $result['code'] =0;
        $result['msg'] ='失败！';
        return $result;
    }

    /**
     * 商家管理员
     **/
    public function admin(){
        if (request()->isPost()) {
            $data=input('post.');
            $admin_data=[
                'username'=>$data['admin_name'],
                'pwd'=>authcode($data['admin_pwd']),
            ];
            $map=[
                'type'=>2,
                'sid'=>$data['sid'],
                'admin_id'=>$data['aid'],
            ];
            if(Db::name('ShopAdmin')->where($map)->update($admin_data)){
                $result['code'] =1;
                $result['msg'] ='成功！';
                return $result;
            }
            $result['code'] =0;
            $result['msg'] ='失败！';
            return $result;
        }
        $sid=input('get.id/d');
        $info=Db::name('ShopAdmin')->alias('a')
            ->join('ShopAuthGroup s','s.group_id = a.group_id','LEFT')
            ->where(['a.type'=>2,'sid'=>$sid,'is_super'=>1])->field('a.admin_id,a.sid,s.group_id,username,rules')->find(); 
        $this->assign('info',$info);
        return $this->fetch();
    }

    
}