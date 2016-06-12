<?php
//后台首页控制器
//命名空间
namespace Admin\Controller;
// use \Think\Controller;

class IndexController extends BaseController{
	//后台主页框架显示
	public function index() {
		$this->display();
	}

	//后台头部显示
	public function top() {
		$this->display();
	}

	//后台菜单栏显示
	public function menu() {
		$this->display();
	}

	//后台详情显示
	public function main() {
		$this->display();
	}
}