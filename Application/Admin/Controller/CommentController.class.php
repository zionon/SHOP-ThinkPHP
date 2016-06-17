<?php
//后台评论控制器
//命名空间
namespace Admin\Controller;

class CommentController extends BaseController{
	//显示列表
	public function commentList() {
		if (IS_GET) {
			$goodsId = I('get.id');
			$cmModel = new \Admin\Model\CommentModel();
			$data = $cmModel->search($goodsId);
			$this->assign(array(
				'data' => $data,
				'_page_title' => '评论列表',
				'_page_btn_name' => '返回',
				'_page_btn_link' => U('commentList'),
			));
			$this->display();
		}
		$goodsModel = new \Admin\Model\GoodsModel();
		$data = $goodsModel->search();
		$this->assign(array(
			'data' => $data['data'],
			'page' => $data['page'],
			'_page_title' => '商品列表',
			'_page_btn_name' => '查看评论',
			'_page_btn_link' => U('commentList'),
		));
		$this->display();
	}
}