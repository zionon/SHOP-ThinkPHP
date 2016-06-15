<?php
//前台定单控制器
//命名空间
namespace Home\Controller;
use Think\Controller;

class OrderController extends Controller{
	//下单
	public function orderAdd() {
		//如果会员没有登录就跳转到登录界面，登录成功之后再跳回这个界面
		$memberId = session('m_id');
		if (!$memberId) {
			//先把登录成功之后要跳回的地址存到SESSION
			session('returnUrl', U('Order/orderAdd'));
			redirect('请先登录!',U('Member/login'));
		}
		if (IS_POST) {
			$orderModel = new \Admin\Model\OrderModel();
			if ($orderModel->create(I('post.'), 1)) {
				if ($orderId = $orderModel->add()) {
					$this->success('下单成功!',U('order_success?order_id='.$orderId));
					exit;
				}
			} else {
				$this->error($orderModel->getError());
			}
		} else {
			//先取出购物车中的所有的商品
			$cartModel = new \Home\Model\CartModel();
			$data = $cartModel->cartList();

			//设置页面信息
			$this->assign(array(
				'data' => $data,
				'_page_title' => '定单确认页',
				'_page_keywords' => '定单确认页',
				'_page_description' => '定单确认页',
				));
			$this->display();
		}
	}
}














