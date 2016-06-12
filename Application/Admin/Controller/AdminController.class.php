<?php 
//后台管理员控制器
//命名空间
namespace Admin\Controller;
use Think\Controller;

class AdminController extends Controller{
	//添加管理员
	public function adminAdd() {
		if (IS_POST) {
			$model = new \Admin\Model\AdminModel();
			if ($model->create(I('post.'), 1)) {
				if ($model->add()) {
					$this->success('添加成功!',U('adminList'));
					exit;
				}
			} else {
				$error = $this->error($model->getError());
			}
		} else {
			$this->assign(array(
				'_page_title' => '添加管理员',
				'_page_btn_name' => '返回管理员列表',
				'_page_btn_link' => U('adminList'),
			));
			$this->display();
		}
	}

	//显示管理员列表
	public function adminList() {
		$model = new \Admin\Model\AdminModel();
		$data = $model->select();
		$this->assign(array(
			'data' => $data,
			'_page_title' => '管理员列表',
			'_page_btn_name' => '添加管理员',
			'_page_btn_link' => U('adminAdd'),
		));
		$this->display();
	}

	//修改管理员列表
	public function adminEdit() {
		$id = I('get.id');
		$model = new \Admin\Model\AdminModel();
		if (IS_POST) {
			// dump($_POST);die;
			if($model->create(I('post.'),2)){
				if ($model->save()) {
					$this->success('修改成功',U('adminList'));
					exit;
				} else {
				$error = $this->error($model->getError());
					}
			}
		} else {
			$data = $model->find($id);
			$this->assign(array(
				'data' => $data,
				'_page_title' => '修改管理员',
				'_page_btn_name' => '管理员列表',
				'_page_btn_link' => U('adminList'),
			));
			$this->display();
		}
	}

	//删除管理员列表
	public function delete() {
		$id = I('get.id');
		$model = new \Admin\Model\AdminModel();
		if ($model->delete($id)) {
			$this->success('删除成功',U('adminList'));
			exit;
		} else {
			$this->error($model->getError());
		}
	}
}












