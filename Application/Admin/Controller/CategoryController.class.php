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
			'_page_title' => '分类列表',
			'_page_btn_name' => '添加新分类',
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

	//添加分类
	public function categoryAdd() {
		$model = new \Admin\Model\CategoryModel();
		if (IS_POST) {
			if ($model->create(I('post.'),1)) {
				if ($id = $model->add()) {
					$this->success('添加成功!',U('categoryList?p='.I('get.p')));
					exit;
				} else {
					$this->error($model->getError());
				}
			}
		} else {
			//取出所有的分类做下拉框
			$catData = $model->getTree();
			//设置页面中的信息
			$this->assign(array(
				'catData' => $catData,
				'_page_title' => '添加分类',
				'_page_btn_name' => '分类列表',
				'_page_btn_link' => U('categoryList'),
			));
			$this->display();
		}
	}

	//修改分类
	public function categoryEdit() {
		$model = new \Admin\Model\CategoryModel();
		$id = I('get.id');
		if (IS_POST) {
			
		} else {
			//取出所有的分类做下拉框
			$catData = $model->getTree();
			//取出当前分类的子分类
			$children = $model->getChildren($id);
		}
	}
}









