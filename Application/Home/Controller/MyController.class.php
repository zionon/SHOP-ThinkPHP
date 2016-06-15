<?php
//个人中心控制器
//命名空间
namespace Home\Controller;
use Think\Controller;

class MyController extends Controller{
	public function __construct() {
		parent::__construct();
		$memberId = session('m_id');
		if (!$memberId) {
			 session('returnUrl', U('My/'.ACTION_NAME));
			 redirect(U('Member/login'));
		}
	}

	public function order() {
		$orderModel = new \Admin\Model\OrderModel();
		$data = $orderModel->search();

		$this->assign(array(
			'data' => $data,
			'_page_title' => '个人中心-我的定单',
			));
		$this->display();
	}
}