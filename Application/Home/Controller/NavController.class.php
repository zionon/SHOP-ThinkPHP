<?php
//前台导航条控制器
//命名空间
namespace Home\Controller;
use Think\Controller;

class NavController extends Controller {
	public function __construct(){
		//必须先调用父类的构造函数
		parent::__construct();
		$catModel = new \Admin\Model\CategoryModel();
		$catData = $catModel->getNavData();
		$this->assign('catData',$catData);
	}
}