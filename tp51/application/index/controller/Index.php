<?php
namespace app\index\controller;



use app\common\model\Goods;

class Index
{
    /*
     *登录主页
     */
    public function index()
    {
        return view();
    }
    /*
     * 所有商品页面
     */
    public function prolist()
    {
        $goods = \app\common\model\Goods::field('goods_name,price,pro_price,id,solid_num,img_dir,image')
            ->select();
        return view('',compact('goods'));
    }
    /*
     * 商品详情页
     */
        public function proinfo($id)
        {
            $goods = Goods::alias('g')
                ->join('zb_goods_image gi','g.id=gi.gid')
                ->field('g.goods_name,g.price,g.pro_price,g.detail,g.img_dir,g.image,gi.img_dir,gi.image,g.add_time')
                ->where('g.id',$id)->select();

            return view('',compact('goods','id'));
        }
    /*
     * 购物车页面
     */
    public function car()
    {
        $buy_num = input('param.buy_num');
        $gid = input('param.gid');
        $add_time = time();
        if (session('member_id'))
        {


        }else
        {
            $cart = session('cart');
            if ($cart['gid'])
            {
                $cart['buy_num'] +=$buy_num;
                $cart['add_time'] = $add_time;
            }else
            {
                $cart['gid'] = $gid;
                $cart['buy_num'] =$buy_num;
                $cart['add_time'] = $add_time;
            }
        }

        if (request()->isPost()) {

            return json(['status'=>'ok']);
        }
        return view();
    }
}
