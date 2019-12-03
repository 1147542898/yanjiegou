<?php

namespace app\api\controller;

use think\Db;
use think\Request;

class Brand extends Base
{
    //品牌全部
    public function lists()
    {
        if (Request::instance()->isPost()) {
            $list = Db::name('goodsBrand')->field('etitle')->order('etitle asc')->group('etitle')->select();
            foreach ($list as $k => $v) {
                $son = [];
                $son = Db::name('goodsBrand')->field('id,title,pic')->where(['etitle' => $v['etitle']])->select();
                foreach ($son as $ks => $vs) {
                    $son[$ks]['pic'] = $this->domain() . $vs['pic'];
                }
                $list[$k]['son'] = $son;
            }

            $this->json_success($list, '请求数据成功');
        } else {
            $this->json_error('请求方式有问题');
            die;
        }
    }

    //品牌精品
    public function jxlists()
    {
        if (Request::instance()->isPost()) {

            $list = Db::name('goodsBrand')->where(['jx' => 1])->select();
            foreach ($list as $k => $v) {
                $list[$k]['pic'] = $this->domain() . $v['pic'];
<<<<<<< HEAD
                // $goods = Db::name('goods')->field('id,headimg,title,price,original_price,cost_price,zk_price')->where(['brandid' => $v['id']])->limit(3)->select();
=======
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                $goods = Db::name('goods')->alias('g')
                        ->join('shy_shop s','s.id = g.shopid','LEFT') 
                        ->field('g.id,g.headimg,g.title,g.price,g.original_price,g.cost_price,g.zk_price')
                        ->where(['g.brandid' => $v['id']])
                        ->where('s.is_lock', 0)
                        ->limit(3)
                        ->select();
                if(empty($goods)){
                    unset($list[$k]);
                }else{
                    foreach ($goods as $gk => $gv) {
                        $headimg = explode(',', $gv['headimg']);
                        $goods[$gk]['headimg'] = $this->domain() . $headimg[0];
                    }
                    $list[$k]['goods'] = $goods;
                }
                
            }
            $this->json_success($list, '请求数据成功');
        } else {
            $this->json_error('请求方式有问题');
            die;
        }
    }
    //品牌页面限制展示品牌
    public function bandsAdv()
    {
        if (Request::instance()->isPost()) {

            $list = Db::name('goodsBrand')->order(['sort'=>'desc'])->limit(7)->select();
            foreach ($list as $k => $v) {
                $list[$k]['pic'] = $this->domain() . $v['pic'];                
            }
            $this->json_success($list, '请求数据成功');
        } else {
            $this->json_error('请求方式有问题');
            die;
        }
    }
    //断码单品
    public function dmgoods()
    {
        //当前的页码
        $p = empty(input('post.p')) ? 1 : input('post.p');
        //每页显示的数量
        $rows = empty(input('post.rows')) ? 10 : input('post.rows');
        $goodsmodel = new \app\api\model\Goods();
        $goods = $goodsmodel->alias('g')
<<<<<<< HEAD
=======
            ->join('shy_shop s','s.id = g.shopid','LEFT')
            ->where('s.is_lock', 0)
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
            ->where(['g.isqc' => 1])
            ->field('g.id,g.headimg,g.title,g.price,g.original_price')
            ->page($p, $rows)
            ->select();

        foreach ($goods as $k => $v) {
            $headimg = explode(',', $v['headimg']);
            $goods[$k]['headimg'] = $this->domain() . $headimg[0];
        }

        $this->json_success($goods);
    }

    //断码清仓品牌
    public function dmbrandgoods()
    {
        if (Request::instance()->isPost()) {
            //当前的页码
            $p = empty(input('post.p')) ? 1 : input('post.p');
            //每页显示的数量
            $rows = empty(input('post.rows')) ? 10 : input('post.rows');
            $list = Db::name('goodsBrand')->page($p, $rows)->select();
            foreach ($list as $k => $v) {
                $list[$k]['pic'] = $this->domain() . $v['pic'];
<<<<<<< HEAD
                $goods = Db::name('goods')
                    ->where(['brandid' => $v['id'], 'isqc' => 1])
                    ->field('id,headimg,title,price,original_price')
=======
                $goods = Db::name('goods')->alias('g')
                    ->join('shy_shop s','s.id = g.shopid','LEFT')
                    ->where('s.is_lock', 0)
                    ->where(['g.brandid' => $v['id'], 'g.isqc' => 1])
                    ->field('g.id,g.headimg,g.title,g.price,g.original_price')
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                    ->limit(3)->select();
                if(empty($goods)){
                        unset($list[$k]);
                }else{
                    foreach ($goods as $gk => $gv) {
                        $headimg = explode(',', $gv['headimg']);
                        $goods[$gk]['headimg'] = $this->domain() . $headimg[0];
                    }
                    $list[$k]['goods'] = $goods;
                }
            }
            $this->json_success($list, '请求数据成功');
        } else {
            $this->json_error('请求方式有问题');
            die;
        }
    }

    //特价商品
    public function tjgoods()
    {
        if (Request::instance()->isPost()) {

            /*
                //当前的页码
            $p = empty(input('post.p')) ?1:input('post.p');
            //每页显示的数量
            $rows = empty(input('post.rows'))?10:input('post.rows');
            $goodsmodel = new \app\api\model\Goods();
            $goods = $goodsmodel->alias('g')
                ->where(['g.istj'=>1])
                ->field('g.id,g.headimg,g.title,g.price,g.original_price')
                ->page($p,$rows)
                ->select();

            foreach($goods as $k=>$v){
                $headimg = explode(',',$v['headimg']);
                $goods[$k]['headimg'] = $this->domain().$headimg[0];
            }

            $this->json_success($goods);
            */

            //当前的页码
            $p = empty(input('post.p')) ? 1 : input('post.p');
            //每页显示的数量
            $rows = empty(input('post.rows')) ? 10 : input('post.rows');
            $list = Db::name('goodsBrand')->page($p, $rows)->select();
            foreach ($list as $k => $v) {
                $list[$k]['pic'] = $this->domain() . $v['pic'];
<<<<<<< HEAD
                $goods = Db::name('goods')
                    ->where(['brandid' => $v['id'], 'istj' => 1])
                    ->field('id,headimg,title,price,original_price')
=======
                $goods = Db::name('goods')->alias('g')
                    ->join('shy_shop s','s.id = g.shopid','LEFT')
                    ->where('s.is_lock', 0)
                    ->where(['g.brandid' => $v['id'], 'g.istj' => 1])
                    ->field('g.id,g.headimg,g.title,g.price,g.original_price')
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                    ->select();
                if(empty($goods)){
                        unset($list[$k]);
                }else{
                    foreach ($goods as $gk => $gv) {
                        $headimg = explode(',', $gv['headimg']);
                        $goods[$gk]['headimg'] = $this->domain() . $headimg[0];
                    }
                    $list[$k]['goods'] = $goods;
                }
                
            }         
            $this->json_success($list, '请求数据成功');
        } else {
            $this->json_error('请求方式有问题');
            die;
        }
    }

    //折扣商品
    public function zkgoods()
    {
        if (Request::instance()->isPost()) {

            /*
                //当前的页码
            $p = empty(input('post.p')) ?1:input('post.p');
            //每页显示的数量
            $rows = empty(input('post.rows'))?10:input('post.rows');
            $goodsmodel = new \app\api\model\Goods();
            $goods = $goodsmodel->alias('g')
                ->where(['g.iszk'=>1])
                ->field('g.id,g.headimg,g.title,g.price,g.original_price,zk_price')
                ->page($p,$rows)
                ->select();

            foreach($goods as $k=>$v){
                $headimg = explode(',',$v['headimg']);
                $goods[$k]['headimg'] = $this->domain().$headimg[0];
            }

            $this->json_success($goods);

            */
            //当前的页码
            $p = empty(input('post.p')) ? 1 : input('post.p');
            //每页显示的数量
            $rows = empty(input('post.rows')) ? 10 : input('post.rows');
            $list = Db::name('goodsBrand')->page($p, $rows)->select();
            foreach ($list as $k => $v) {
                $list[$k]['pic'] = $this->domain() . $v['pic'];
<<<<<<< HEAD
                $goods = Db::name('goods')
                    ->where(['brandid' => $v['id'], 'iszk' => 1])
                    ->field('id,headimg,title,price,original_price,zk_price')
=======
                $goods = Db::name('goods')->alias('g')
                    ->join('shy_shop s','s.id = g.shopid','LEFT')
                    ->where('s.is_lock', 0)
                    ->where(['g.brandid' => $v['id'], 'g.iszk' => 1])
                    ->field('g.id,g.headimg,g.title,g.price,g.original_price,g.zk_price')
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                    ->select();
                if(empty($goods)){
                        unset($list[$k]);
                }else{
                    foreach ($goods as $gk => $gv) {
                        $headimg = explode(',', $gv['headimg']);
                        $goods[$gk]['headimg'] = $this->domain() . $headimg[0];
                    }
                    $list[$k]['goods'] = $goods;
                }
                // foreach ($goods as $gk => $gv) {
                //     $headimg = explode(',', $gv['headimg']);
                //     $goods[$gk]['headimg'] = $this->domain() . $headimg[0];
                // }
                // $list[$k]['goods'] = $goods;
            }
            $this->json_success($list, '请求数据成功');
        } else {
            $this->json_error('请求方式有问题');
            die;
        }
    }

    //商品排行
    public function phgoods()
    {
        if (Request::instance()->isPost()) {
            //当前的页码
            $p = empty(input('post.p')) ? 1 : input('post.p');
            //每页显示的数量
            $rows = empty(input('post.rows')) ? 10 : input('post.rows');
            $goodsmodel = new \app\api\model\Goods();
            $goods = $goodsmodel->alias('g')
<<<<<<< HEAD
=======
                ->join('shy_shop s','s.id = g.shopid','LEFT')
                ->where('s.is_lock', 0)
>>>>>>> 71b458708778358bd6f4184a3f8a6f45ba5cd4c3
                ->field('g.id,g.headimg,g.title,g.price,g.original_price,zk_price,g.sold')
                ->page($p, $rows)
                ->order('sold desc')
                ->select();

            foreach ($goods as $k => $v) {
                $headimg = explode(',', $v['headimg']);
                $goods[$k]['headimg'] = $this->domain() . $headimg[0];
            }

            $this->json_success($goods);
        } else {
            $this->json_error('请求方式有问题');
            die;
        }
    }
    //商家排行
    public function phshops()
    {
        if (Request::instance()->isPost()) {
            //当前的页码
            $p = empty(input('post.p')) ? 1 : input('post.p');
            //每页显示的数量
            $rows = empty(input('post.rows')) ? 10 : input('post.rows');
            $shops = Db::name('shop')->alias('g')
                ->join('order o', 'o.shop_id=g.id', 'LEFT')
                ->field('g.id,g.headimg,g.name,g.shoplogo,sum(o.total_num) num')
                ->page($p, $rows)
                ->order('num desc')
                ->select();

            foreach ($shops as $k => $v) {
                $headimg = explode(',', $v['headimg']);
                $shops[$k]['headimg'] = $this->domain() . $headimg[0];
                $shops[$k]['shoplogo'] = $this->domain() . $v['shoplogo'];
            }

            $this->json_success($shops);
        } else {
            $this->json_error('请求方式有问题');
            die;
        }
    }
    
    
}
