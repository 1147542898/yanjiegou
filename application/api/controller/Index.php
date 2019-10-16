<?php
namespace app\api\controller;
use app\api\model\Ad;
use app\api\model\Bigshop;
use app\api\model\Goods;
use think\Db;
use think\Request;

class Index extends Base
{

    //首页轮播图
    public function adv()
    {
        $type_id = input('get.type_id') ? input('get.type_id') : 1;
/*分支修改*/
        $where['type_id'] = $type_id;
        $where['open'] = 1;

        $data = Ad::where($where)->order('sort desc,ad_id')->field('name,ad_id,pic,url')->select();
        foreach ($data as $k => $v) {
            $data[$k]['pic'] = $this->domain(). $v['pic'];
        }
        $this->json_success($data);
    }

    //首页三张商家图
    public function bigshop()
    {
        $limit = input('get.num') ? input('get.num') : 3;
        $where = [
            'is_home' => 1,

        ];
        $bigshops = Bigshop::where($where)->limit($limit)->order('sort asc,id desc')->field('id,name,headimg,intro')->select();
        $data = [];
        foreach ($bigshops as $k => $v) {
            $headimg = explode(',',$v['headimg']);
            $data[$k]['id'] = $v['id'];
            $data[$k]['name'] = $v['name'];
            $data[$k]['intro'] = $v['intro'];
            $data[$k]['headimg'] = $this->domain().$headimg[0];
        }

        $this->json_success($data,'请求数据成功');
    }

    //首页商品显示
    public function goods()
    {
        if (Request::instance()->isPost()){
            //当前的页码
            $p = empty(input('post.p')) ?1:input('post.p');


            //每页显示的数量
            $rows = empty(input('post.rows'))?10:input('post.rows');
            $user_id =empty(input('post.user_id')) ? "" : input('post.user_id');

            $goodsmodel = new Goods();

            $where = [
                //status  0否1上架
                'g.status'=>1,
                //check_status   --审核状态  -1:违规 0:未审核 1:已审核
                'g.check_status'=>1

            ];

            $goods = $goodsmodel->alias('g')
                ->join('__SHOP__ s','s.id=g.shopid','LEFT')
                ->order('g.readpoint desc,g.id asc')
                ->where($where)
                ->field('g.id,g.headimg,g.title,g.price,s.id as sid,s.name,s.shoplogo')
                ->page($p,$rows)
                ->select();

            foreach($goods as $k=>$v){
                $headimg = explode(',',$v['headimg']);
                $goods[$k]['headimg'] = $this->domain().$headimg[0];
                $goods[$k]['shoplogo'] = $this->domain().$v['shoplogo'];
                $goods[$k]['collection_num']=$goodsmodel::get($v['id'])->collectiongoods()->count();
                if($user_id){
                 $goods[$k]['is_collection']=$goodsmodel->if_collection($v['id'],$user_id);               
                }else{
                    $goods[$k]['is_collection']=0;
                }
            }



            $this->json_success($goods,'请求数据成功');

        }else{
            $this->json_error('请求方式有问题');
            die;
        }


    }
    
}