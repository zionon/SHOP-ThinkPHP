<?php
//前台搜索控制器
//命名空间
namespace Home\Controller;
// use Think\Controller;

class SearchController extends NavController{
	//分类搜索
	public function catSearch() {
		//设置页面信息
		$this->assign(array(
			'_page_title' => '分类搜索页',
			'_page_keywords' => '分类搜索页',
			'_page_description' => '分类搜索页',
			));
		$this->display();
	}
}