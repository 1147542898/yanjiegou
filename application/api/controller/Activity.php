<?php
namespace app\api\controller;
use app\admin\controller\Link;
use app\api\model\Goods;
use think\Db;
use think\Request;
use think\Config;
class Activity extends Base
{


    //活动
    public function index()
    {

        if (Request::instance()->isPost()){
            //当前的页码
            $p = empty(input('post.p')) ?1:input('post.p');


            //每页显示的数量
            $rows = empty(input('post.rows'))?10:input('post.rows');
            $goodsmodel = new Goods();

            //check_status--审核状态  -1:违规 0:未审核 1:已审核
            $where = [
                //0否1上架
                'g.status'=>1,
                //是否显示该商品0否1是
                'g.check_status'=>1

            ];

            //活动类型筛选
            $type = empty(input('post.type')) ?1:input('post.type');

            //isrecommand--商品属性推荐
            //isnew--商品属性新品
            //ishot--商品属性热卖
            //issendfree--商品属性包邮
            //isdiscount--商品属性促销
            switch($type){
                case 1:
                    //推荐
                    $where['isrecommand'] = 1;
                    break;
                case 2:
                //新品
                $where['isnew'] = 1;
                    break;
                case 3:
                    //热卖
                    $where['ishot'] = 1;
                    break;
                case 4:
                    //包邮
                    $where['issendfree'] = 1;
                    break;
                case 5:
                    //促销
                    $where['isdiscount'] = 1;
                    break;
                default:
                    //推荐
                    $where['isrecommand'] = 1;
            }


			
            $goods = $goodsmodel->alias('g')
                ->join('__SHOP__ s','s.id=g.shopid','LEFT')
                ->order('g.sorts asc,g.id desc')
                ->where($where)
                ->field('g.id,g.headimg,g.title,g.price,s.id as sid,s.name,s.shoplogo')
                ->page($p,$rows)
                ->select();

            foreach($goods as $k=>$v){
                $headimg = explode(',',$v['headimg']);
                $goods[$k]['headimg'] = $this->domain().$headimg[0];
                $goods[$k]['shoplogo'] = $this->domain().$v['shoplogo'];
            }
            $this->json_success($goods,'请求数据成功');

        }else{
            $this->json_error('请求方式有问题');
            die;
        }
    }


    //团购列表
    public function groupbuy()
    {
        //当前的页码
        $p = empty(input('post.p')) ?1:input('post.p');
        //每页显示的数量
        $rows = empty(input('post.rows'))?10:input('post.rows');

        $where = [
            'gb.is_expire'=>1
        ];
        $data = Db::name('groupbuy')->alias('gb')
            ->join('__SHOP__ s','s.id=gb.shop_id','LEFT')
            ->where($where)
            ->field('gb.*,s.id as sid,s.name,s.shoplogo')
            ->page($p,$rows)
            ->select();
        foreach($data as $k=>$v){
            $data[$k]['shoplogo'] = $this->domain().$v['shoplogo'];
        }
        $this->json_success($data);
    }

    //用户开团
    public function ogroupbuy()
    {
        $user_id = input('post.user_id');
        if(null===$user_id){
            $this->json_error('请传过来用户编号');
        }
        $groupbuy_id = input('post.groupbuy_id');
        if(null===$groupbuy_id){
            $this->json_error('请传过来开团编号');
        }
        $goods_id = input('post.goods_id');
        if(null===$goods_id){
            $this->json_error('请传过来商品编号');
        }
        $groupbubylog = Db::name('groupbubylog')->where(['groupbuy_id'=>$groupbuy_id,'ouid'=>$user_id,'goods_id'=>$goods_id])->find();
        if($groupbubylog!=null){
            $this->json_error('你已经开过团了，不能重复开团');
            die;
        }

        //根据开团编号，查看开团信息
        $groupbuy = Db::name('groupbuy')->where(['id'=>$groupbuy_id])->find();

        if($groupbuy==null){
            $this->json_error('该开团信息不存在');
            die;
        }

        $goods_id = $groupbuy['goods_id'];
        $shop_id = $groupbuy['shop_id'];

        $info = [
            'groupbuy_id'=>$groupbuy_id,
            'ouid'=>$user_id,//开团人用户编号
            'goods_id'=>$goods_id,
            'shop_id'=>$shop_id,
            'jnum'=>1,
            'stime'=>time()
        ];

    }

    //用户参与团购
    public function uigroupbuy()
    {
        $user_id = input('post.user_id');
        if(null===$user_id){
            $this->json_error('请传过来用户编号');
        }
        $groupbuy_id = input('post.groupbuy_id');
        if(null===$groupbuy_id){
            $this->json_error('请传过来团购编号');
        }
        $goods_id = input('post.goods_id');
        if(null===$user_id){
            $this->json_error('请传过来商品编号');
        }

        //查看是否有团购商品信息
        $groupbuy = Db::name('groupbuy')->where(['id'=>$groupbuy_id,'goods_id'=>$goods_id])->find();
        if($groupbuy==null){
            $this->json_error('不能参与该团购商品');
            die;
        }else{
            if($groupbuy['is_expire']==0){
                $this->json_error('该团购商品已经失效');
                die;
            }
            if($groupbuy['gnum']==0){
                $this->json_error('团购名额已经没有了');
                die;
            }
        }

    }

    // 物流实时查询
    public function getExpress() { 
        $user_id = input('post.user_id');
        if(null===$user_id){
            $this->json_error('请传过来用户编号');
        }

        $com = input('post.expresscom');
        $num = input('post.expresssn');
        $key = Config::get('kuaidi')['key'];                      //客户授权key
        $customer = Config::get('kuaidi')['cus'];                 //查询公司编号
        $param = array (
            'com' => $com,           //快递公司编码
            'num' => $num,   //快递单号
            'phone' => '',              //手机号
            'from' => '',               //出发地城市
            'to' => '',                 //目的地城市
            'resultv2' => '1'           //开启行政区域解析
        );
    
        //请求参数
        $post_data = array();
        $post_data["customer"] = $customer;
        $post_data["param"] = json_encode($param);
        $sign = md5($post_data["param"].$key.$post_data["customer"]);
        $post_data["sign"] = strtoupper($sign);
        
        $url = 'http://poll.kuaidi100.com/poll/query.do';   //实时查询请求地址
        
        $params = "";
        foreach ($post_data as $k=>$v) {
            $params .= "$k=".urlencode($v)."&";     //默认UTF-8编码格式
        }
        $post_data = substr($params, 0, -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $data = str_replace("\"", '"', $result );
        $data = json_decode($data);
      	$this->json_success($data);
    }
  	
  	// 关于我们
    public function about()
    {
        $data = Db::name('system')->field('logo,tel,name')->find();
        $this->json_success($data);
    }
}