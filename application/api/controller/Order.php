<?php
namespace app\api\controller;
use think\Db;
use think\Request;

class Order extends Base
{
    ////确认订单第一步，还没有生成订单
    public function index()
    {
        $user_id = input('post.user_id');
        if(null===$user_id){
            $this->json_error('请传过来用户编号');
        }
        $cart_id = input('post.cart_id');
        if(null===$cart_id){
            $this->json_error('请传过来购物车编号');
        }
        $carts = Db::name('shopcart')->alias('c')
            ->join('goods g','g.id=c.goods_id','LEFT')
            ->whereIn('c.id',$cart_id)
            ->where(['user_id'=>$user_id])
            ->field('c.*,g.shopid,g.headimg,g.title,g.price')
            ->select();


        $shop_ids = array_unique(array_column($carts,'shopid'));
        $shop_ids = implode(',',$shop_ids);
        //获取当前用户领取的商家优惠券
        $coupons = Db::name('couponlog')->alias('clog')
            ->join('coupon c','c.id=clog.coupon_id')
            ->where(['clog.user_id'=>$user_id,'clog.is_use'=>0,'c.type_id'=>2,'c.is_expire'=>0])
            ->field('clog.id as clogid,clog.user_id,clog.is_use,clog.receive_time,c.*')
            ->order('clog.id desc')
            ->select();
        $time = time();
        foreach($coupons as $cck=>$ccv){
            if($time>$ccv['end_time']){
                //说明过期了
                Db::name('coupon')->where(['id'=>$ccv['id']])->update(['is_expire'=>1]);
            }
        }



        $shops = Db::name('shop')->where('id','in',$shop_ids)->field('id,name,shoplogo')->select();
        $data = [];
        $order_goods = [];
        $mycoupons = [];
        foreach($shops as $k=>$v){
            $shops[$k]['shoplogo'] = $this->domain().$v['shoplogo'];
            $cart_ids = [];
            $totalnum = 0;
            $totalprice = 0;
            foreach($carts as $ck=>$cv){
                if($v['id']==$cv['shopid']){
                    array_push($cart_ids,$cv['id']);
                    $data['id'] = $cv['id'];
                    $data['goods_id'] = $cv['goods_id'];
                    $data['num'] = $cv['num'];
                    $totalnum+=$cv['num'];
                    $data['goods_attr'] = json_decode($cv['goods_attr'],true);
                    $data['title'] = $cv['title'];
                    $data['price'] = $cv['price'];
                    $totalprice+=($cv['num']*$cv['price']);
                    $headimgs = explode(',',$cv['headimg']);
                    $data['headimg'] = $this->domain().$headimgs[0];
                    $shops[$k]['goods'][] = $data;
                }
            }
            $shops[$k]['cart_id'] = implode(',',$cart_ids);
            $shops[$k]['remark_member'] = "";
            $shops[$k]['totalnum'] = $totalnum;
            $shops[$k]['totalprice'] = $totalprice;
            foreach($coupons as $kk=>$vv){
                if($v['id']==$vv['shop_id']){

                    if($vv['min_price']<$shops[$k]['totalprice']){
                        $mycoupons['clogid'] = $vv['clogid'];
                        $mycoupons['user_id'] = $vv['user_id'];
                        $mycoupons['is_use'] = $vv['is_use'];
                        $mycoupons['receive_time'] = date('Y-m-d H:i:s',$vv['receive_time']);
                        $mycoupons['id'] = $vv['id'];
                        $mycoupons['type_id'] = $vv['type_id'];
                        $mycoupons['name'] = $vv['name'];
                        $mycoupons['min_price'] = $vv['min_price'];
                        $mycoupons['sub_price'] = $vv['sub_price'];
                        $mycoupons['begin_time'] = date('Y-m-d H:i:s',$vv['begin_time']);
                        $mycoupons['end_time'] = date('Y-m-d H:i:s',$vv['end_time']);
                        $mycoupons['add_time'] = date('Y-m-d H:i:s',$vv['add_time']);
                        $mycoupons['total_count'] = $vv['total_count'];
                        $mycoupons['sort'] = $vv['sort'];
                        $mycoupons['is_expire'] = $vv['is_expire'];
                        $mycoupons['shop_id'] = $vv['shop_id'];
                        $mycoupons['shop_name'] = $vv['shop_name'];
                        $mycoupons['special'] = $vv['special'];
                        $shops[$k]['coupons'][] = $mycoupons;
                    }

                }
            }
        }


        //查看当前用户是否有默认的收货地址
        $recvaddr = Db::name('recvaddr')->where(['user_id'=>$user_id,'is_delete'=>0])->field('consignee,phone,province,city,area,address')->find();

        if(null===$recvaddr){
            $myinfo['shop'] = $shops;
            $this->json_success($myinfo,'您还没有设置收货地址',-1);
            die;
        }

        $info = [
            'recvaddr'=>$recvaddr,
            'shop'=>$shops
        ];
        $this->json_success($info);
    }

    //立即购买
    public function ordernow()
    {
        $user_id = input('post.user_id');
        if(null===$user_id){
            $this->json_error('请传过来用户编号');
        }
        //pay_type支付方式   1支付宝  2微信  3银联
        $pay_type = input('post.pay_type');
        if(null===$pay_type){
            $this->json_error('请传过来支付方式');
        }
        $ptype = [1,2,3];
        if(!in_array($pay_type,$ptype)){
            $this->json_error('支付方式有问题');
        }
        //查看当前用户是否有默认的收货地址
        $recvaddr = Db::name('recvaddr')->where(['user_id'=>$user_id,'is_default'=>1,'is_delete'=>0])->field('consignee,phone,province,city,area,address')->find();
        if(null===$recvaddr){
            $this->json_error('您还没有设置收货地址');
            die;
        }
        $goods_id = input('post.goods_id');
        if(null===$goods_id){
            $this->json_error('请传过来商品编号');
        }

        $num = input('post.num');
        if(null===$num){
            $this->json_error('请传过来购买数量');
        }
        if($num<=0){
            $this->json_error('数量不合法');
            die;
        }

        //查看库存是否够
        $goods = Db::name('goods')->where('id','=',$goods_id)->find();
        $total = $goods['total'];
        if($num>$total){
            $this->json_error('库存不足');
            die;
        }
        $goods_attr = input('post.goods_attr');
        if(null===$goods_attr){
            $this->json_error('请传过来商品属性');
        }
        if(!is_json($goods_attr)){
            $this->json_error('商品属性格式不对');
            die;
        }

        if($goods==null){
            $this->json_error('非法操作');
            die;
        }

        $shop_id = $goods['shopid'];

        $price = $goods['price'];

        //订单号
        $ordersn = makeordersn();

        $totalmoney = $num*$price;
        $order['shop_id'] = $shop_id;
        $order['order_sn'] = $ordersn;
        $order['user_id'] = $user_id;
        $order['money'] = $totalmoney;
        $order['oldmoney'] = $totalmoney;
        $order['total_num'] = $num;
        $order['status'] = 1;  //订单状态 1.待付款   2.待发货    3.已发货   4.待评价 5.已完成  6.已关闭 7售后
        $order['add_time'] = time();
        $order['getusername'] = $recvaddr['consignee'];
        $order['mobile'] = $recvaddr['phone'];
        $order['address'] = $recvaddr['address'];
        $order['province'] = $recvaddr['province'];
        $order['city'] = $recvaddr['city'];
        $order['area'] = $recvaddr['area'];
        $order['pay_type'] = $pay_type;


        $order_goods['order_sn'] = $ordersn;
        $order_goods['goodsid'] = $goods_id;
        $order_goods['price'] = $price;
        $order_goods['num'] = $num;
        $order_goods['specification'] = $goods_attr;
        $order_goods['addtime'] = time();

        //开启事务
        Db::startTrans();

        $order_id = Db::name('order')->insertGetId($order);
        $order_goods = Db::name('order_goods')->insertGetId($order_goods);

        $myorders = Db::name('order')->where(['id'=>$order_id,'user_id'=>$user_id])->field('id,order_sn')->select();
        $order_sns = json_encode(array_column($myorders,'order_sn'));
        $myorder_ids  = implode(',',array_column($myorders,'id'));

        $order_trades = [
            'out_trade_no'=>makeordersn(),
            'order_sns'=>$order_sns,
            'order_ids'=>$myorder_ids,
            'total_amount'=>$totalmoney
        ];
        $trade_id = Db::name('order_trade')->insertGetId($order_trades);

        //判断条件
        if($order_id && $trade_id && $order_goods){
            //如果全部成功,提交事务
            Db::commit();

            //--0拍下减库存   1付款减库存   2永不减库存
            Db::name('goods')->where(['id'=>$goods_id,'totalcnf'=>0])->setDec('total',$num);



            $orders =Db::name('order')->order('id','desc')
                ->where(['user_id'=>$user_id,'status'=>1])  //订单状态 1.待付款   2.待发货    3.已发货   4.待评价 5.已完成  6.已关闭 7售后
                ->whereIn('id',$order_id)
                ->select();

            //订单编号，去查找订单商品
            $order_sn = array_column($orders,'order_sn');
            $orders_goods = Db::name('order_goods')->alias('og')
                ->join('goods g','g.id=og.goodsid')
                ->join('shop s','s.id=g.shopid','left')
                ->field('og.price as ogprice,og.num,og.specification,og.order_sn as ogorder_sn,g.id as gid,g.title as gtitle,g.headimg,s.id as sid,s.name as sname,s.shoplogo')
                ->whereIn('og.order_sn',$order_sn)
                ->select();


            foreach($orders_goods as $gk=>$gv){
                foreach($orders as $kkk=>$vvv){
                    if($gv['ogorder_sn']==$vvv['order_sn']){
                        $orders_goods[$gk]['status'] = $vvv['status'];
                        $orders_goods[$gk]['oid'] = $vvv['id'];
                    }
                }
            }
            $shop_ids = array_column($orders,'shop_id');
            $shop_ids = implode(',',$shop_ids);
            $shops = Db::name('shop')->where('id','in',$shop_ids)->field('id,name,shoplogo')->select();
            $data2 = [];
            foreach($shops as $k=>$v){
                $shops[$k]['shoplogo'] = $this->domain().$v['shoplogo'];
                foreach($orders as $kkk=>$vvv){
                    if($v['id']==$vvv['shop_id']){
                        $shops[$k]['order_sn'] = $vvv['order_sn'];
                        $shops[$k]['status'] = $vvv['status'];
                        $shops[$k]['pay_type'] = $vvv['pay_type'];
                    }
                }
                foreach($orders_goods as $ok=>$ov){
                    if($v['id']==$ov['sid']){
                        $data2['gitle'] = $ov['gtitle'];
                        $data2['status'] = $ov['status'];
                        $data2['oid'] = $ov['oid'];
                        $data2['gid'] = $ov['gid'];
                        $data2['ogprice'] = $ov['ogprice'];
                        $data2['num'] = $ov['num'];
                        $data2['specification'] = json_decode($ov['specification'],true);
                        $headimgs = explode(',',$ov['headimg']);
                        $data2['headimg'] = $this->domain().$headimgs[0];
                        $shops[$k]['goods'][] = $data2;
                    }
                }
            }

            $info = [
                'recvaddr'=>$recvaddr,
                'shop'=>$shops
            ];

            $trandeinfo = Db::name('order_trade')->where('id',$trade_id)->field('out_trade_no,total_amount')->find();

            $info['out_trade_no'] = $trandeinfo['out_trade_no'];
            $info['total_amount'] = $trandeinfo['total_amount'];

            $this->json_success($info,'生成订单成功');

        }else{
            //如果失败,回滚事务
            Db::rollback();
            $this->json_error('生成订单失败');
        }


    }

    //提交订单
    public function ordersub()
    {
        $user_id = input('post.user_id');
        if(null===$user_id){
            $this->json_error('请传过来用户编号');
        }
        $myshop = input('post.myshop');
        if(!is_json($myshop)){
            $this->json_error('格式不对');
            die;
        }
        $myshop = json_decode($myshop,true);
        if(null===$myshop){
            $this->json_error('请传过来店铺编号和购物车id信息和备注信息');
        }
        $cart_id = array_column($myshop,'cart_id');

        $cart_id = implode(',',$cart_id);

        //pay_type支付方式   1支付宝  2微信  3银联
        $pay_type = input('post.pay_type');
        if(null===$pay_type){
            $this->json_error('请传过来支付方式');
        }
        $ptype = [1,2,3];
        if(!in_array($pay_type,$ptype)){
            $this->json_error('支付方式有问题');
        }

        $carts = Db::name('shopcart')->alias('c')
            ->join('goods g','g.id=c.goods_id','LEFT')
            ->whereIn('c.id',$cart_id)
            ->where(['user_id'=>$user_id])
            ->field('c.*,g.shopid,g.headimg,g.title,g.price')
            ->select();




        //查看当前用户是否有默认的收货地址
        $recvaddr = Db::name('recvaddr')->where(['user_id'=>$user_id,'is_default'=>1,'is_delete'=>0])->field('consignee,phone,province,city,area,address')->find();
        if(null===$recvaddr){
            $this->json_error('您还没有设置收货地址');
            die;
        }


        $shop_ids = array_column($myshop,'shop_id');

        //有多少个商家就生成多少个订单
        //$shop_ids = array_unique(array_column($carts,'shopid'));
        $shop_ids = implode(',',$shop_ids);
        $shops = Db::name('shop')->where('id','in',$shop_ids)->field('id,name,shoplogo')->select();

        //优惠券
        $coupon_id = array_column($myshop,'coupon_id');

        $coupons = Db::name('coupon')->whereIn('id',$coupon_id)->where(['is_expire'=>0])->select();

        $cid = array_column($coupons,'id');

        Db::name('couponlog')->whereIn('coupon_id',$cid)->where(['user_id'=>$user_id])->update(['is_use'=>1,'use_time'=>time()]);

        $data = [];
        $order_goods = [];
        foreach($shops as $k=>$v){
            $shops[$k]['shoplogo'] = $this->domain().$v['shoplogo'];
            //订单号
            $ordersn = makeordersn();
            $shops[$k]['order_sn'] = $ordersn;
            $total = 0;
            $total_num = 0;
            foreach($carts as $ck=>$cv){
                if($v['id']==$cv['shopid']){
                    $data['id'] = $cv['id'];
                    $data['goods_id'] = $cv['goods_id'];
                    $data['num'] = $cv['num'];
                    $data['goods_attr'] = json_decode($cv['goods_attr'],true);
                    $data['title'] = $cv['title'];
                    $data['price'] = $cv['price'];
                    //统计商品价格
                    $data['tprice'] = $cv['num']*$data['price'];
                    $total+=$data['tprice'];
                    $total_num+=$data['num'];
                    $headimgs = explode(',',$cv['headimg']);
                    $data['headimg'] = $this->domain().$headimgs[0];
                    $shops[$k]['goods'][] = $data;

                    $order_goods[$ck]['order_sn'] = $ordersn;
                    $order_goods[$ck]['goodsid'] = $cv['goods_id'];
                    $order_goods[$ck]['price'] = $cv['price'];
                    $order_goods[$ck]['num'] = $cv['num'];
                    $order_goods[$ck]['specification'] = $cv['goods_attr'];
                    $order_goods[$ck]['addtime'] = time();

                }
            }
            $shops[$k]['totalprice'] = $total;
            $shops[$k]['total_num'] = $total_num;
        }



        $order = [];
        $total_amount = 0;
        foreach($shops as $k=>$v){
            $order[$k]['shop_id'] = $v['id'];
            $order[$k]['order_sn'] = $v['order_sn'];
            $order[$k]['user_id'] = $user_id;
            $order[$k]['money'] = $v['totalprice'];
            $order[$k]['oldmoney'] = $v['totalprice'];
            $order[$k]['total_num'] = $v['total_num'];
            $order[$k]['status'] = 1;  //订单状态 1.待付款   2.待发货    3.已发货   4.待评价 5.已完成  6.已关闭 7售后
            $order[$k]['add_time'] = time();
            $order[$k]['getusername'] = $recvaddr['consignee'];
            $order[$k]['mobile'] = $recvaddr['phone'];
            $order[$k]['address'] = $recvaddr['address'];
            $order[$k]['province'] = $recvaddr['province'];
            $order[$k]['city'] = $recvaddr['city'];
            $order[$k]['area'] = $recvaddr['area'];
            $order[$k]['pay_type'] = $pay_type;

            foreach($myshop as $mmk=>$mmv){
                if($mmv['shop_id']==$v['id']){
                    $order[$k]['remark_member'] = $mmv['remark_member'];
                }
            }

            foreach($coupons as $ck=>$cv){
                if($cv['shop_id']==$v['id']){
                    $order[$k]['couponid'] = $cv['id'];
                    $order[$k]['couponprice'] = $cv['sub_price'];
                }
            }

            $total_amount+=$v['totalprice'];

        }




        //开启事务
        Db::startTrans();
        //数据操作
        $order = Db::name('order')->insertAll($order);
        $order_id = Db::name('order')->getLastInsID();
        $order_ids = [];
        for ($i=0; $i<$order; $i++) {
            $order_ids[] = (int)$order_id++;
        }
        $order_goods = Db::name('order_goods')->insertAll($order_goods);

        $myorders = Db::name('order')->whereIn('id',$order_ids)->where(['user_id'=>$user_id])->field('id,order_sn')->select();


        $order_sns = json_encode(array_column($myorders,'order_sn'));


        $myorder_ids  = implode(',',array_column($myorders,'id'));

       if($total_amount<=0){
           $this->json_error('金额不合法');
           die;
       }

        $order_trades = [
            'out_trade_no'=>makeordersn(),
            'order_sns'=>$order_sns,
            'order_ids'=>$myorder_ids,
            'total_amount'=>$total_amount
        ];



        $trade_id = Db::name('order_trade')->insertGetId($order_trades);


        //判断条件
        if($order && $trade_id && $order_ids){
            //如果全部成功,提交事务
            Db::commit();

            //--0拍下减库存   1付款减库存   2永不减库存
            foreach($carts as $mk=>$mv){
                Db::name('goods')->where(['id'=>$mv['goods_id'],'totalcnf'=>0])->setDec('total',$mv['num']);
            }

            //删除购物车shopcart
            Db::name('shopcart')->where('user_id','=',$user_id)->where("id in ($cart_id)")->delete();


            $orders =Db::name('order')->order('id','desc')
                ->where(['user_id'=>$user_id,'status'=>1])  //订单状态 1.待付款   2.待发货    3.已发货   4.待评价 5.已完成  6.已关闭 7售后
                ->whereIn('id',$order_ids)
                ->select();

            //订单编号，去查找订单商品
            $order_sn = array_column($orders,'order_sn');
            $orders_goods = Db::name('order_goods')->alias('og')
                ->join('goods g','g.id=og.goodsid')
                ->join('shop s','s.id=g.shopid','left')
                ->field('og.price as ogprice,og.num,og.specification,og.order_sn as ogorder_sn,g.id as gid,g.title as gtitle,g.headimg,s.id as sid,s.name as sname,s.shoplogo')
                ->whereIn('og.order_sn',$order_sn)
                ->select();


            foreach($orders_goods as $gk=>$gv){
                foreach($orders as $kkk=>$vvv){
                    if($gv['ogorder_sn']==$vvv['order_sn']){
                        $orders_goods[$gk]['status'] = $vvv['status'];
                        $orders_goods[$gk]['oid'] = $vvv['id'];
                    }
                }
            }
            $shop_ids = array_column($orders,'shop_id');
            $shop_ids = implode(',',$shop_ids);
            $shops = Db::name('shop')->where('id','in',$shop_ids)->field('id,name,shoplogo')->select();
            $data2 = [];
            foreach($shops as $k=>$v){
                $shops[$k]['shoplogo'] = $this->domain().$v['shoplogo'];
                foreach($orders as $kkk=>$vvv){
                    if($v['id']==$vvv['shop_id']){
                        $shops[$k]['order_sn'] = $vvv['order_sn'];
                        $shops[$k]['status'] = $vvv['status'];
                    }
                }
                foreach($orders_goods as $ok=>$ov){
                    if($v['id']==$ov['sid']){
                        $data2['gitle'] = $ov['gtitle'];
                        $data2['status'] = $ov['status'];
                        $data2['oid'] = $ov['oid'];
                        $data2['gid'] = $ov['gid'];
                        $data2['ogprice'] = $ov['ogprice'];
                        $data2['num'] = $ov['num'];
                        $data2['specification'] = json_decode($ov['specification'],true);
                        $headimgs = explode(',',$ov['headimg']);
                        $data2['headimg'] = $this->domain().$headimgs[0];
                        $shops[$k]['goods'][] = $data2;
                    }
                }
            }

            $info = [
                'recvaddr'=>$recvaddr,
                'shop'=>$shops
            ];

            $trandeinfo = Db::name('order_trade')->where('id',$trade_id)->field('out_trade_no,total_amount')->find();

            $info['out_trade_no'] = $trandeinfo['out_trade_no'];
            $info['total_amount'] = $trandeinfo['total_amount'];

            $this->json_success($info,'生成订单成功');

        }else{
            //如果失败,回滚事务
            Db::rollback();
            $this->json_error('生成订单失败');
        }

    }

    //申请退款
    public function refund()
    {
        $user_id = input('post.user_id');
        if (null === $user_id) {
            $this->json_error('请传过来用户编号');
        }
        $order_id = input('post.order_id');
        if (null === $order_id) {
            $this->json_error('请传过来订单编号');
        }

        $goods_id = input('post.goods_id');
        if (null === $goods_id) {
            $this->json_error('请传过来商品编号');
        }

        $og_id = input('post.og_id');
        if (null === $og_id) {
            $this->json_error('请传过来订单商品编号');
        }
        //判断当前订单是否存在
        $order = Db::name('order')->where(['id'=>$order_id])->find();
        if(null === $order){
            $this->json_error('非法操作');
            die;
        }

        //操作   otype=1  显示    otype=2  提交
        $otype = input('post.otype') ? input('post.otype') : 1;

        $order_sn = $order['order_sn'];
        $orders_goods = Db::name('order_goods')->alias('og')
            ->join('goods g','g.id=og.goodsid','LEFT')
            ->field('og.price as ogprice,og.num,og.specification,og.order_sn as ogorder_sn,og.id as og_id,g.id as gid,g.title as gtitle,g.headimg')
            ->where(['og.goodsid'=>$goods_id,'og.order_sn'=>$order_sn,'og.id'=>$og_id])
            ->find();

        if($otype==1){
            $headimgs = explode(',',$orders_goods['headimg']);
            $orders_goods['headimg'] = $this->domain().$headimgs[0];
            $this->json_success($orders_goods);
            die;
        }else{
            $rid = input('post.rid');
            if (null === $rid) {
                $this->json_error('请传过来退款原因编号');
            }
            $rule = [
                'mobile' => 'require|max:11|regex:/^1[3-8]{1}[0-9]{9}$/',
                //'imgs' => 'require'
            ];
            $msg = [
                'mobile.require' => '手机号码不能为空',
                'mobile.max' => '手机号码不符合长度',
                'mobile.regex' => '手机号码格式不正确',
                'imgs.require' => '上传凭证不能为空'
            ];

            $result = $this->validate(input('post.'), $rule, $msg);

            if (true !== $result) {
                // 验证失败 输出错误信息
                $this->json_error($result);
                die;
            }else {
                $mobile = input('post.')['mobile'];
                $imgs = $result['imgs'];
                $money = $orders_goods['ogprice'];
                //申请过了不让重新申请
                $orderrefund = Db::name('orderrefund')->where(['user_id'=>$user_id,'og_id'=>
                    $og_id])->find();
                if(null!=$orderrefund){
                    $this->json_error('你已经申请过了，请不要重复申请');
                    die;
                }

                $data = [
                    'rid'=>$rid,
                    'order_id'=>$order_id,
                    'order_sn'=>$order_sn,
                    'og_id'=>$og_id,
                    'money'=>$money,
                    'mobile'=>$mobile,
                    'imgs'=>$imgs,
                    'goods_id'=>$goods_id,
                    'user_id'=>$user_id,
                    'add_time'=>time()
                ];

                $remark = input('post.remark');
                if(null!=$remark){
                    $data['remark'] = $remark;
                }




                $id = Db::name('orderrefund')->insertGetId($data);
                if($id){
                    $this->json_success([],'申请成功，请耐心等待结果');
                    die;
                }else{
                    $this->json_error([],'申请失败，请重新申请');
                    die;
                }
            }
        }




    }


    //退款原因
    public function reason()
    {
        $data = Db::name('orderreason')->order('id desc')->select();
        $this->json_success($data);

    }

    //我的申请退款售后列表
    public function aftersale()
    {
        $user_id = input('post.user_id');
        if(null===$user_id){
            $this->json_error('请传过来用户编号');
        }
        //当前的页码
        $p = empty(input('post.p')) ?1:input('post.p');
        //每页显示的数量
        $rows = empty(input('post.rows'))?10:input('post.rows');

        $data = Db::name('orderrefund')->alias('of')
            ->join('goods g','g.id=of.goods_id','LEFT')
            ->join('shop s','s.id=g.shopid','LEFT')
            ->field('of.id,of.status,of.order_sn,of.goods_id,of.add_time,g.id as gid,g.headimg,g.title,s.id as sid,s.name,s.shoplogo')
            ->where(['of.user_id'=>$user_id])
            ->order('of.id','desc')
            ->page($p,$rows)
            ->select();
        $order_sns = array_column($data,'order_sn');

        $order_goods = Db::name('order_goods')->whereIn('order_sn',$order_sns)->select();

        foreach($data as $k=>$v){
            $data[$k]['shoplogo'] = $this->domain().$v['shoplogo'];
            $headimg = explode(',',$v['headimg']);
            $data[$k]['headimg'] = $this->domain().$headimg[0];
            $data[$k]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
            foreach($order_goods as $kk=>$vv){
                if($vv['goodsid']==$v['goods_id'] && $vv['order_sn']==$v['order_sn']){
                    $data[$k]['price'] = $vv['price'];
                    $data[$k]['num'] = $vv['num'];
                    $data[$k]['specification'] = json_decode($vv['specification']);
                }
            }
        }

        $this->json_success($data);
    }

    //删除订单，假删除
    public function delorder()
    {
        $user_id = input('post.user_id');
        if(null===$user_id){
            $this->json_error('请传过来用户编号');
        }
        $order_id = input('post.order_id');
        if(null===$order_id){
            $this->json_error('请传过来订单编号');
        }

        $order = Db::name('order')->where(['user_id'=>$user_id,'id'=>$order_id])->find();

        if(null==$order){
            $this->json_error('非法操作');
        }
        $res = Db::name('order')->where('id',$order_id)->update(['is_del' => 1]);
        if($res){
            $this->json_success([],'删除订单成功');
        }else{
            $this->json_error('删除订单失败');
        }
    }

    //确认收货
    public function orderok()
    {
        $user_id = input('post.user_id');
        if(null===$user_id){
            $this->json_error('请传过来用户编号');
        }
        $order_id = input('post.order_id');
        if(null===$order_id){
            $this->json_error('请传过来订单编号');
        }

        $order = Db::name('order')->where(['user_id'=>$user_id])->whereIn('id',$order_id)->find();

        if(null==$order){
            $this->json_error('非法操作');
        }
        $res = Db::name('order')->whereIn('id',$order_id)->update(['status' => 4,'affirmtime'=>time(),'overtime'=>time()]);
        if($res){
            $this->json_success([],'确认收货成功');
        }else{
            $this->json_error('确认收货失败');
        }
    }

    //取消订单
    public function cancleorder()
    {
        $user_id = input('post.user_id');
        if(null===$user_id){
            $this->json_error('请传过来用户编号');
        }
        $order_id = input('post.order_id');
        if(null===$order_id){
            $this->json_error('请传过来订单编号');
        }

        $order = Db::name('order')->where(['user_id'=>$user_id,'id'=>$order_id])->find();

        if(null==$order){
            $this->json_error('非法操作');
        }
        //没有付款的订单可以取消
        //status 订单状态 1.待付款   2.待发货    3.已发货   4.待评价 5.已完成  6.已关闭 7.售后 8.取消订单
        if($order['status']==6){
            $this->json_error('您已经取消了订单，请不要重复取消');
            die;
        }
        if($order['status']!=1){
            $this->json_error('不能取消订单，请申请售后');
            die;
        }

        $res = Db::name('order')->where('id',$order_id)->update(['canceltime' => time(),'status'=>6]);
        if($res){
            //库存在加回去
            $order_sn = $order['order_sn'];
            $ordegoods = Db::name('order_goods')->whereIn('order_sn',$order_sn)->select();

            //--0拍下减库存   1付款减库存   2永不减库存
            foreach($ordegoods as $mk=>$mv){
                Db::name('goods')->where(['id'=>$mv['goodsid'],'totalcnf'=>0])->setInc('total',$mv['num']);

            }

            $this->json_success([],'取消订单成功');
        }else{
            $this->json_error('取消订单失败');
        }
    }

}