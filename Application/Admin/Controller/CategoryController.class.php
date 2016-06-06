<?php
//无限级分类管理器
//命名空间
namespace Admin\Controller;
use Think\Controller;

class CategoryController extends Controller{
	//列表页
	public function categoryList() {
		$model = new \Admin\Model\CategoryModel();
		$data = $model->getTree();
		//设置页面信息
		$this->assign(array(
			'data' => $data,
			'_page_title' => '商品列表',
			'_page_btn_name' => '添加新商品',
			'_page_btn_link' => U('categoryAdd'),
		));
		$this->display();
	}

	//删除
	public function delete() {
		$model = new \Admin\Model\CategoryModel();
		if ($model->delete(I('get.id')) !== FALSE) {
			$this->success('删除成功!!',U('categoryList'));
		} else {
			$this->error('删除失败！原因:'.$model->getError());
		}
	}
	
}