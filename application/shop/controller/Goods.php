<?php
namespace app\shop\controller;
use think\Db;
use think\Request;
use think\View;
use app\shop\controller\Common;
class Goods extends Common{
    protected  $model,$mod_cate;
    public function _initialize(){
        parent::_initialize();
        $this->model = model('goods');
        $this->mod_cate=model('goodsCategory');
        $attachmark    = get_attachmark();    //上传标示
        $this->assign('moduleid',115);
        $this->assign('attachmark',$attachmark);
    }
    //商品列表
    public function index(){
         $way=input('way/s');
         if(Request::instance()->isAjax()){
            $catid=input('catid');
            $page =input('page')?input('page'):1;
            $pageSize =input('limit')?input('limit'):config('pageSize');
            $map=[];
            switch ($way) {
                case 1: //上架
                    $map['a.status']=1;
                    $map['a.check_status']=1;
                    break;
                case 2://待审核
                    $map['a.check_status']=0;
                    break;
                case 3://违规商品
                    $map['a.check_status']=-1;
                    break;
                case 4://仓库中
                    $map['a.status']=0;
                    $map['a.check_status']=1;
                    break;        
            }
            $keyword=input('key');
            $map['a.shopid']=SHID;
            if(!empty($keyword)){$map['a.title']=array('like','%'.$keyword.'%');}
            $list = $this->model->alias('a')
                ->join('goodsCategory c','c.id = a.catid','LEFT')
                ->join('shop s','s.id = a.shopid','LEFT')
                ->field('a.*,c.catname,s.name as shopname')
                ->where($map)
                ->order("sorts desc,id desc")
                ->paginate(array('list_rows'=>$pageSize,'page'=>$page))
                ->each(function($row,$key){
                    $row['headimg'] = explode(',',$row['headimg'])[0];
                })
                ->toArray();
            return ['code'=>0,'msg'=>"获取成功",'data'=>$list['data'],'count'=>$list['total'],'rel'=>1];
        }
        $this->assign('way',$way);
        return $this->fetch();
    }

    /*
       编辑商品
     */
    public function edit(){
        if(Request::instance()->isAjax()){
             $data = input('post.');
            unset($data['upfile']);
            $data['userid'] = URID;
            $data['createtime']=time();
            $data['status']=0;
            $data['check_status']=0;
            $data['shopid']=SHID;
            $data['bigshopid']=db('shop')->where(['id'=>SHID])->value('bshopid');
            if (isset($data['parameter'])) {
                $parameter=[];
                foreach ($data['parameter'] as $key => $value) {
                    if ($value!='' and  $data['parameter_value'][$key]!='') {
                        $parameter[$value]=$data['parameter_value'][$key];
                    }
                }
                unset($data['parameter_value']);
                unset($data['parameter']);
                if (!empty($parameter)) {
                   
                   $data['parameter']=json_encode($parameter);
                }
            }
            
            if (!empty($data['headimg'])) {
                $data['headimg']=implode(',',$data['headimg']);
            }
            if (!empty($data['label'])) {
                $data['label']=implode(',',$data['label']);
            }
            $msg = $this->validate($data,'Goods');
            if($msg!='true'){
                return $result = ['code'=>0,'msg'=>$msg];
            }
            if($this->model->where(array('id'=>$data['id']))->update($data)){
                return $this->resultmsg('修改成功');
            }
            return $this->resultmsg('修改失败',0);
        }
        $id = input('id');
        $info = $this->model->where('id',$id)->find();
        $info['headimg']=explode(',',$info['headimg']);
        $info['parameter']=json_decode($info['parameter'],true);
        $info['label']=explode(',',$info['label']);
        $cat_tree=$this->mod_cate->get_category_tree('',1,$info['catid']);
        $label=Db::name('GoodsLabel')->select();
        $this->assign('label',$label);
        $brand=Db::name('GoodsBrand')->select();
        $this->assign('brand',$brand);
        $this->assign('cat_tree',$cat_tree);
        $this->assign ('info', $info );
        $this->assign('brandlist','');
        return $this->fetch();
    }
   
    
    /*
       添加商品
     */
    public function add(){
        if(Request::instance()->isAjax()){
            $data = input('post.');
            unset($data['upfile']);
            $data['userid'] = URID;
            $data['createtime']=time();
            $data['status']=0;
            $data['check_status']=0;
            $data['shopid']=SHID;
            $data['bigshopid']=db('shop')->where(['id'=>SHID])->value('bshopid');
            $data['goodsn']=GetGoodsNo();
            if (isset($data['parameter'])) {
                $parameter=[];
                foreach ($data['parameter'] as $key => $value) {
                    if ($value!='' and  $data['parameter_value'][$key]!='') {
                        $parameter[$value]=$data['parameter_value'][$key];
                    }
                }
                unset($data['parameter_value']);
                unset($data['parameter']);
                if (!empty($parameter)) {
                   
                   $data['parameter']=json_encode($parameter);
                }
            }
            
            if (!empty($data['headimg'])) {
                $data['headimg']=implode(',',$data['headimg']);
            }
            if (!empty($data['label'])) {
                $data['label']=implode(',',$data['label']);
            }
            $msg = $this->validate($data,'Goods');
            if($msg!='true'){
                return $result = ['code'=>0,'msg'=>$msg];
            }
            $insert=$this->model->insert($data);
            if($insert){
                return $this->resultmsg('添加成功');
            }
            return $this->resultmsg('添加失败',0);
        }
        $brand=Db::name('GoodsBrand')->select();
        $this->assign('brandlist',$brand);
        $label=Db::name('GoodsLabel')->field('title')->select();
        $this->assign('label',$label);
        $catemodel=$this->mod_cate;
        $cat_tree=$catemodel->get_category_tree('',1,0);

        $this->assign('cat_tree',$cat_tree);
        return $this->fetch();
    }


    //设置商品审核状态
    public function SetCheckStatus(){
        $map['id'] =array('in',input('post.id/a'));
        $status=input('post.status');
        if ($status=='-1') {
           $data['illegal_text']=input('post.text/s');
           $data['status']=0;
        }
        $data['check_status']=$status;
        if($this->model->where($map)->update($data)!==false){
            return $this->resultmsg('设置成功！',1);
        }
        return $this->resultmsg('设置失败！',0);
    }

     //设置商品上下架状态
    public function SetStatus(){
        $map['id'] =array('in',input('post.id/a'));
        $status=input('post.status');
        $this->model->where($map)->update(['status'=>$status]);
        return $this->resultmsg('设置成功！',1);
    }

    /*
       回收站
     */
    public function listDel(){
        $id = input('post.id');
        $model = $this->model;
        $model->where(array('id'=>$id))->delete();//转入回收站
        return ['code'=>1,'msg'=>'删除成功！'];
    }
    /*
      批量删除
     */
    public function delAll(){
        $map['id'] =array('in',input('post.ids/a'));
        if($this->model->where($map)->delete()){
           return $this->resultmsg('删除成功！',1);
        }
        return $this->resultmsg('删除失败！',0);
    }
    /*
      排序设置
     */
    public function listorder(){
        $model = $this->model;
        $catid = input('catid');
        $data = input('post.');
        $model->update($data);
        $result = ['msg' => '排序成功！','url'=>url('index',array('catid'=>$catid)), 'code' => 1];
        return $result;
    }
    public function delImg(){
        if(!input('post.url')){
            return ['code'=>0,'请指定要删除的图片资源'];
        }
        $file = ROOT_PATH.__PUBLIC__.input('post.url');
        if(file_exists($file) && trim(input('post.url'))!=''){
            is_dir($file) ? dir_delete($file) : unlink($file);
        }
        if(input('post.id')){
            $picurl = input('post.picurl');
            $picurlArr = explode(':',$picurl);
            $pics = substr(implode(":::",$picurlArr),0,-3);
            $model = $this->model;
            $map['id'] =input('post.id');
            $model->where($map)->update(array('pics'=>$pics));
        }
        $result['msg'] = '删除成功!';
        $result['code'] = 1;
        return $result;
    }


    public function getRegion(){
        $Region=db("region");
        $map['pid']=$_REQUEST["pid"];
        $map['type']=$_REQUEST["type"];
        $list=$Region->where($map)->select();
        echo json_encode($list);
    }

    /**
     * 修改属性
     *
     * @return void
     * @author 
     **/
    public function sttredit(){
        $data=input('post.');
        $updata[$data['sttr']]=$data['val'];

        $result=$this->model->where(array('id'=>$data['id']))->update($updata);
        if ($result) {
           return $this->resultmsg('操作成功',1);
        }
        return $this->resultmsg('操作失败',0);
    }
}