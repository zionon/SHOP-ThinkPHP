<?php
//前台购物车控制器
//命名空间
namespace Home\Controller;
use Think\Controller;

class CartController extends Controller {
	public function add() {
		if (IS_POST) {
			$cartModel = new \Home\Model\CartModel();
			if ($cartModel->create(I('post.'),1)) {
				if ($cartModel->add()) {
					$this->success('添加成功!',U('/'));
					exit;
				}
			} else {
				$this->error('添加失败，原因：'.$cartModel->getError());
			}
		}
	}
}