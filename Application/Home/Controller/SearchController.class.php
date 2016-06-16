<?php
//前台搜索控制器
//命名空间
namespace Home\Controller;
// use Think\Controller;

class SearchController extends NavController{
	//分类搜索
	public function catSearch() {

		$catId = I('get.catId');

		//取出商品和翻页
		$goodsModel = new \Admin\Model\GoodsModel();
		$data = $goodsModel->catSearch($catId);

		//根据上面搜索出来的商品计算筛选条件
		$catModel = new \Admin\Model\CategoryModel();
		$searchFilter = $catModel->getSearchConditionByGoodsId($data['goods_id']);
		//设置页面信息
		$this->assign(array(
			'data' => $data['data'],
			'page' => $data['page'],
			'searchFilter' => $searchFilter,
			'_page_title' => '分类搜索页',
			'_page_keywords' => '分类搜索页',
			'_page_description' => '分类搜索页',
			));
		$this->display();
	}
}