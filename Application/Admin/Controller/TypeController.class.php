<?php
//类型控制器
//命名空间
namespace Admin\Controller;
// use Think\Controller;

class TypeController extends BaseController{
	//显示列表
	public function typeList() {
		$model = new \Admin\Model\TypeModel();
		$data = $model->select();
		$this->assign(array(
			'data' => $data,
			'_page_title' => '类型列表',
			'_page_btn_name' => '添加类型',
			'_page_btn_link' => U('typeAdd')
		));
		$this->display();
	}

	//添加类型
	public function typeAdd() {
		if (IS_POST) {
			$model = new \Admin\Model\TypeModel();
			if ($model->create(I('post.'),1)) {
				if ($model->add()) {
					$this->success('添加类型成功!!',U('typeList'));
					exit;
				}
			} else {
				$this->error($model->getError());
			}
		} else {
			$this->assign(array(
				'_page_title' => '添加类型',
				'_page_btn_name' => '类型列表',
				'_page_btn_link' => U('typeList'),
			));
			$this->display();
		}
	}

	//修改类型
	public function typeEdit() {
		$model = new \Admin\Model\TypeModel();
		if (IS_POST) {
			if ($model->create(I('post.'), 2)) {
				if ($model->save()) {
					$this->success('修改成功!!',U('typeList'));
				} else {
					$this->error($model->getError());
				}
			}
		} else {
			$data = $model->find(I('get.id'));
			$this->assign(array(
				'data' => $data,
				'_page_title' => '修改类型',
				'_page_btn_name' => '类型列表',
				'_page_btn_link' => U('typeList'),
			));
			$this->display();
		}
	}

	//删除类型
	public function delete() {
		$model = new \Admin\Model\TypeModel();
		if ($model->delete(I('get.id')) !== FALSE) {
			$this->success('删除成功', U('typeList'));
			exit;
		} else {
			$this->error($model->getError());
		}
	}
}










