<?php
// 后台订单控制器
// 命名空间
namespace Admin\Controller;

class OrderController extends BaseController{
	//显示订单
	public function orderList() {
		$orderModel = new \Admin\Model\OrderModel();
		$data = $orderModel->getAllOrder();
		// dump($data);die;
		$this->assign(array(
			'data' => $data,
			'_page_title' => '订单列表',
			'_page_btn_name' => '订单列表',
			'_page_btn_link' => U('orderList'),
			));
		$this->display();
	}

	public function orderDetail() {

	}

	public function orderDelete() {
		$orderModel = new \Admin\Model\OrderModel();
		$orderModel->delete();
	}
}