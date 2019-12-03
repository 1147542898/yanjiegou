<?php
<<<<<<< HEAD
namespace app\api\controller;
=======

namespace app\api\controller;

>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
use app\api\model\Comment;
use app\api\model\Report;
use app\api\model\Shop as ShopModel;
use think\Db;
use think\Request;
// 商家
class Shop extends Base
{
    public function index()
    {
        $shop_id = input('post.shop_id');
<<<<<<< HEAD
        if(null===$shop_id){
=======
        if (null === $shop_id) {
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
            $this->json_error('请传过来商家编号');
        }


        $tnum = Db::name('comment')->count();



<<<<<<< HEAD
        $res = Db::name('comment')->where(['shop_id'=>$shop_id])->field('sum(logistics) as logistics,sum(manner) as manner')->group('shop_id')->select();



        $num = Db::name('comment')->where(['shop_id'=>$shop_id])->count();
=======
        $res = Db::name('comment')->where(['shop_id' => $shop_id])->field('sum(logistics) as logistics,sum(manner) as manner')->group('shop_id')->select();



        $num = Db::name('comment')->where(['shop_id' => $shop_id])->count();
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3


        //物流服务  logistics
        //服务态度  manner
        //liu
<<<<<<< HEAD
        $shop = Db::name("shop")->where('id',$shop_id)->field('id,name,shoplogo,intro,province,city,area,address,description,quality,service')->find();
        if(empty($shop)){
            $this->json_error('商家不存在！');
        }
        $shop['shop_fans']=ShopModel::get($shop_id)->shopFans()->count();
        $shop['shop_goods_num']=ShopModel::get($shop_id)->shopGoodsNum()->count();
        $shop['shoplogo'] = $this->domain().$shop['shoplogo'];       
        $shop['sale_num']=ShopModel::shopOrderNum($shop_id);
        if($res!=null){
            $res = $res[0];
            if($num>0){
                $shop['scomment'] = $num/$tnum;
                $shop['logistics'] = $res['logistics'] /$num;
                $shop['manner'] = $res['manner'] /$num;
            }else{
                $shop['scomment'] = $num/$tnum;
                $shop['logistics'] = 0;
                $shop['manner'] = 0;
            }
        }else{
            $shop['scomment'] = $num/$tnum;
=======
        $shop = Db::name("shop")->where('id', $shop_id)->field('id,name,shoplogo,intro,province,city,area,address,description,quality,service')->find();
        if (empty($shop)) {
            $this->json_error('商家不存在！');
        }
        $shop['shop_fans'] = ShopModel::get($shop_id)->shopFans()->count();
        $shop['shop_goods_num'] = ShopModel::get($shop_id)->shopGoodsNum()->count();
        $shop['shoplogo'] = $this->domain() . $shop['shoplogo'];
        $shop['sale_num'] = ShopModel::shopOrderNum($shop_id);
        if ($res != null) {
            $res = $res[0];
            if ($num > 0) {
                $shop['scomment'] = $num / $tnum;
                $shop['logistics'] = $res['logistics'] / $num;
                $shop['manner'] = $res['manner'] / $num;
            } else {
                $shop['scomment'] = $num / $tnum;
                $shop['logistics'] = 0;
                $shop['manner'] = 0;
            }
        } else {
            $shop['scomment'] = $num / $tnum;
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
            $shop['logistics'] = 0;
            $shop['manner'] = 0;
        }



        $user_id = input('post.user_id');
<<<<<<< HEAD
        if(null!=$user_id){
            //登录了
            $collectionshop = db('collectionshop')->where(['user_id'=>$user_id,'shop_id'=>$shop_id])->find();
            if(null!=$collectionshop){
                //代表收藏了
                $shop['is_collectionshop'] = 1;
            }else{
                //没有收藏
                $shop['is_collectionshop'] = 0;
            }
        }else{
=======
        if (null != $user_id) {
            //登录了
            $collectionshop = db('collectionshop')->where(['user_id' => $user_id, 'shop_id' => $shop_id])->find();
            if (null != $collectionshop) {
                //代表收藏了
                $shop['is_collectionshop'] = 1;
            } else {
                //没有收藏
                $shop['is_collectionshop'] = 0;
            }
        } else {
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
            //没有登录
            $shop['is_collectionshop'] = 0;
        }
        //收藏商家数量
<<<<<<< HEAD
        $collectionshop = Db::name('collectionshop')->where('shop_id',$shop_id)->count();
=======
        $collectionshop = Db::name('collectionshop')->where('shop_id', $shop_id)->count();
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
        $shop['collectionshop'] = $collectionshop;

        $data = [];

        //商家信息
        $data['shop'] = $shop;

        //筛选type   1 最新    2全部   3高价格    4低价格

        //每页显示的数量
<<<<<<< HEAD
        $type = empty(input('post.type'))?1:input('post.type');

        //当前的页码
        $p = empty(input('post.p')) ?1:input('post.p');


        //每页显示的数量
        $rows = empty(input('post.rows'))?30:input('post.rows');


        switch($type){
            case 1:
                //1 最新
                $goods = \app\api\model\Goods::where('shopid',$shop_id)
                    ->field('id,title,headimg,price')
                    ->order('id','desc')
                    ->page($p,$rows)
=======
        $type = empty(input('post.type')) ? 1 : input('post.type');

        //当前的页码
        $p = empty(input('post.p')) ? 1 : input('post.p');


        //每页显示的数量
        $rows = empty(input('post.rows')) ? 30 : input('post.rows');


        switch ($type) {
            case 1:
                //1 最新
                $goods = \app\api\model\Goods::where('shopid', $shop_id)
                    ->field('id,title,headimg,price')
                    ->order('id', 'desc')
                    ->page($p, $rows)
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                    ->select();
                break;
            case 2:
                //2全部
<<<<<<< HEAD
                $goods = \app\api\model\Goods::where('shopid',$shop_id)
                    ->field('id,title,headimg,price')
                    ->order('id','desc')
                    ->page($p,$rows)
=======
                $goods = \app\api\model\Goods::where('shopid', $shop_id)
                    ->field('id,title,headimg,price')
                    ->order('id', 'desc')
                    ->page($p, $rows)
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                    ->select();
                break;
            case 3:
                //3高价格
<<<<<<< HEAD
                $goods = \app\api\model\Goods::where('shopid',$shop_id)
                    ->field('id,title,headimg,price')
                    ->order('price','desc')
                    ->page($p,$rows)
=======
                $goods = \app\api\model\Goods::where('shopid', $shop_id)
                    ->field('id,title,headimg,price')
                    ->order('price', 'desc')
                    ->page($p, $rows)
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                    ->select();
                break;
            case 4:
                //4低价格
<<<<<<< HEAD
                $goods = \app\api\model\Goods::where('shopid',$shop_id)
                    ->field('id,title,headimg,price')
                    ->order('price','asc')
                    ->page($p,$rows)
=======
                $goods = \app\api\model\Goods::where('shopid', $shop_id)
                    ->field('id,title,headimg,price')
                    ->order('price', 'asc')
                    ->page($p, $rows)
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                    ->select();
                break;
            default:
                //1 最新
<<<<<<< HEAD
                $goods = \app\api\model\Goods::where('shopid',$shop_id)
                    ->field('id,title,headimg,price')
                    ->order('id','desc')
                    ->page($p,$rows)
=======
                $goods = \app\api\model\Goods::where('shopid', $shop_id)
                    ->field('id,title,headimg,price')
                    ->order('id', 'desc')
                    ->page($p, $rows)
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                    ->select();
                break;
        }



        $myimgs = [];
<<<<<<< HEAD
        foreach($goods as $k=>$v){
            $headimg = explode(',',$v['headimg']);
            $goods[$k]['headimg'] = $this->domain().$headimg[0];
            $collectiongoods = Db::name('collectiongoods')->where('goods_id',$v['id'])->count();
            $goods[$k]['collectiongoods'] = $collectiongoods;
            if(null!=$user_id){
                //登录了
                $collectiongoods = db('collectiongoods')->where(['user_id'=>$user_id,'goods_id'=>$v['id']])->find();
                if(null!=$collectiongoods){
                    //代表收藏了
                    $goods[$k]['is_collectiongoods'] = 1;
                }else{
                    //没有收藏
                    $goods[$k]['is_collectiongoods'] = 0;
                }
            }else{
=======
        foreach ($goods as $k => $v) {
            $headimg = explode(',', $v['headimg']);
            $goods[$k]['headimg'] = $this->domain() . $headimg[0];
            $collectiongoods = Db::name('collectiongoods')->where('goods_id', $v['id'])->count();
            $goods[$k]['collectiongoods'] = $collectiongoods;
            if (null != $user_id) {
                //登录了
                $collectiongoods = db('collectiongoods')->where(['user_id' => $user_id, 'goods_id' => $v['id']])->find();
                if (null != $collectiongoods) {
                    //代表收藏了
                    $goods[$k]['is_collectiongoods'] = 1;
                } else {
                    //没有收藏
                    $goods[$k]['is_collectiongoods'] = 0;
                }
            } else {
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                //没有登录
                $goods[$k]['is_collectiongoods'] = 0;
            }
        }

        $data['goods'] = $goods;


        $this->json_success($data);
    }

    //商家举报
    public function report()
    {
        $shop_id = input('post.shop_id');
<<<<<<< HEAD
        if(null===$shop_id){
            $this->json_error('请传过来商家编号');
        }
        $rule=[
            'reason'=> 'require',
            'describe'=>'require'
        ];
        $msg=[
            'reason.require'=>'举报原因不能为空',
            'describe.require'=>'举报描述不能为空'
        ];
        $result=$this->validate(input('post.'),$rule,$msg);
        if(true !== $result){
            // 验证失败 输出错误信息
            $this->json_error($result);
            die;
        }else{
            if(!empty(input('post.imgsrc'))){
                $data = [
                    'shop_id'=>$shop_id,
                    'reason'=>input('post.reason'),
                    'describe'=>input('post.describe'),
                    'imgsrc'=>input('post.imgsrc'),
                    'add_time'=>time()
                ];

            }else{
                $data = [
                    'shop_id'=>$shop_id,
                    'reason'=>input('post.reason'),
                    'describe'=>input('post.describe'),
                    'add_time'=>time()
=======
        if (null === $shop_id) {
            $this->json_error('请传过来商家编号');
        }
        $rule = [
            'reason' => 'require',
            'describe' => 'require'
        ];
        $msg = [
            'reason.require' => '举报原因不能为空',
            'describe.require' => '举报描述不能为空'
        ];
        $result = $this->validate(input('post.'), $rule, $msg);
        if (true !== $result) {
            // 验证失败 输出错误信息
            $this->json_error($result);
            die;
        } else {
            if (!empty(input('post.imgsrc'))) {
                $data = [
                    'shop_id' => $shop_id,
                    'reason' => input('post.reason'),
                    'describe' => input('post.describe'),
                    'imgsrc' => input('post.imgsrc'),
                    'add_time' => time()
                ];
            } else {
                $data = [
                    'shop_id' => $shop_id,
                    'reason' => input('post.reason'),
                    'describe' => input('post.describe'),
                    'add_time' => time()
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                ];
            }

            $id = Report::insertGetId($data);
<<<<<<< HEAD
            if($id){
                $info = Report::find($id);
                $this->json_success($info,'举报成功');
            }else{
                $this->json_error('举报失败');
            }

        }

    }
    //商家信息
    public function shopinfos(){
        $shop_id=input("post.shop_id");
        $shopInfo=Db::name("shop")
                        ->field("shoplogo,name,intro,content,longitude,latitude,addtime,star,province,city,area,street,quality,service,address,yyzz,headimg,description,quality,service")
                        ->where(['id'=>$shop_id])
                        ->find();
        $shopInfo['shop_fans']=ShopModel::get($shop_id)->shopFans()->count();
        $shopInfo['shop_goods_num']=ShopModel::get($shop_id)->shopGoodsNum()->count();
        $shopInfo['shoplogo'] = $this->domain().$shopInfo['shoplogo'];       
        $shopInfo['sale_num']=ShopModel::shopOrderNum($shop_id);
        $shopInfo['shop_address']=$shopInfo['province'].$shopInfo['city'].$shopInfo['street'].$shopInfo['address'];
        if($shopInfo['yyzz']){
            $yyzz=explode(',',$shopInfo['yyzz']);
            for($i=0; $i<count($yyzz); $i++){
                $yyzz[$i]=$this->domain().$yyzz[$i];
            }
            $shopInfo['yyzz']=$yyzz;
        }
        $count=Db::name('shop')->count();
        $shops=Db::name('shop')->field("SUM(description) description,SUM(quality) quality,SUM(service) service")->find();
        $description=$shops['description']/$count;//平均描述
        $quality=$shops['quality']/$count;//平均质量
        $service=$shops['service']/$count;//平均服务
        if($description==0){
            $shopinfo['description']=array(
                'description'=>0,
                'rate'=>0
            );
        }else{
            $shopInfo['description']=array(
                'description'=>$shopInfo['description'],
                'rate'=>round((($shopInfo['description']-$description)/$description*100),2)."%",
            );
        }       
        
       
        if($quality==0){
            $shopInfo['quality']=array(
                'quality'=>0,
                'rate'=>0
            );
        }else{
            $shopInfo['quality']=array(
                'quality'=>$shopInfo['quality'],
                'rate'=>round((($shopInfo['quality']-$quality)/$quality*100),2)."%",
            );
        }
        if($service==0){
            $shopInfo['quality']=array(
                'quality'=>0,
                'rate'=>0
            );
        }else{
            $shopInfo['service']=array(
                'service'=>$shopInfo['service'],
                'rate'=>round((($shopInfo['service']-$service)/$service*100),2)."%",
            );
        }
        
        $shop_order_count=Db::name('order')->where(['shop_id'=>$shop_id,''])->select();
        var_dump($shopInfo);       
        exit;
    }
    
    

}
=======
            if ($id) {
                $info = Report::find($id);
                $this->json_success($info, '举报成功');
            } else {
                $this->json_error('举报失败');
            }
        }
    }
    //商家信息
    public function shopinfos()
    {
        $shop_id = input("post.shop_id");
        $shopInfo = Db::name("shop")
            ->field("shoplogo,name,intro,content,longitude,latitude,addtime,star,province,city,area,street,quality,service,address,yyzz,headimg,description,quality,service,tag")
            ->where(['id' => $shop_id])
            ->find();
        $shopInfo['shop_fans'] = ShopModel::get($shop_id)->shopFans()->count();
        $shopInfo['shop_goods_num'] = ShopModel::get($shop_id)->shopGoodsNum()->count();
        $shopInfo['shoplogo'] = $this->domain() . $shopInfo['shoplogo'];
        $shopInfo['sale_num'] = ShopModel::shopOrderNum($shop_id);
        $shopInfo['shop_address'] = $shopInfo['province'] . $shopInfo['city'] . $shopInfo['street'] . $shopInfo['address'];
        if ($shopInfo['yyzz']) {
            $yyzz = explode(',', $shopInfo['yyzz']);
            for ($i = 0; $i < count($yyzz); $i++) {
                $yyzz[$i] = $this->domain() . $yyzz[$i];
            }
            $shopInfo['yyzz'] = $yyzz;
        }
        $shopInfo['tag'] = json_decode($shopInfo['tag'], true);
        $this->json_success($shopInfo, '获取数据成功！');
        die;
    }
}
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
