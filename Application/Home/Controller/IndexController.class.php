<?php
//前台首页控制器
namespace Home\Controller;

class IndexController extends NavController {

	//显示首页
    public function index() {

    	//取出疯狂抢购的商品
    	$goodsModel = new \Admin\Model\GoodsModel();
    	$goods1 = $goodsModel->getPromoteGoods();
    	$goods2 = $goodsModel->getRecGoods('is_new');	//新品
    	$goods3 = $goodsModel->getRecGoods('is_hot');	//热卖
    	$goods4 = $goodsModel->getRecGoods('is_best');	//精品
    	// dump($goods1);die;
    	//设置页面信息
  		$this->assign(array(
  			'goods1' => $goods1,
  			'goods2' => $goods2,
  			'goods3' => $goods3,
  			'goods4' => $goods4,
  			'_show_nav' => 1,
  			'_page_title' => '首页',
  			'_page_keywords' => '首页',
  			'_page_description' => '首页',
  		));
    	$this->display();
    }

    public function goods() {

    	//设置页面信息
    	$this->assign(array(
    		'_show_nav' => 0,
    		'_page_title' => '商品详情页',
    		'_page_keywords' => '商品详情页',
    		'_page_description' => '商品详情页',
    		));
    	$this->display();
    }
        
}










