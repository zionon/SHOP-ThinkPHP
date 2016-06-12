<?php
//后台角色控制器
//命名空间
namespace Admin\Controller;
use Think\Controller;

class RoleController extends Controller{
	//角色添加
	public function roleAdd() {
		if (IS_POST) {
			$model = new \Admin\Model\RoleModel();
			if ($model->create(I('post.'),1)) {
				if ($model->add()) {
					$this->success('添加成功 ！',U('roleList'));
					exit;
				}
			} else {
				$error = $this->error($model->getError());
			}
		} else {
			$this->assign(array(
				'_page_title' => '添加角色',
				'_page_btn_name' => '角色列表',
				'_page_btn_link' => U('roleList'),
			));
			$this->display();
		}
	}

	//角色列表
	public function roleList() {
		$model = new \Admin\Model\RoleModel();
		$data = $model->select();
		$this->assign(array(
			'data' => $data,
			'_page_title' => '角色列表',
			'_page_btn_name' => '添加角色',
			'_page_btn_link' => U('roleAdd'),
		));
		$this->display();
	}

	//修改角色
	public function roleEdit() {
		$id = I('get.id');
		$model = new \Admin\Model\RoleModel();
		if (IS_POST) {
			if ($model->create(I('post.'),2)) {
				if ($model->save()) {
					$this->success('修改成功！！',U('roleEdit?id='.$id));
					exit;
				} else {
					$error = $this->error($model->getError());
				}
			}
		} else {
			$data = $model->find($id);
			$this->assign(array(
				'data' => $data,
				'_page_title' => '修改角色',
				'_page_btn_name' => '角色列表',
				'_page_btn_link' => U('roleList'),
			));
			$this->display();
		}
	}

	//删除角色
	public function delete() {
		$id = I('get.id');
		$model = new \Admin\Model\RoleModel();
		if ($model->delete($id)) {
			$this->success('删除成功!',U('roleList'));
			exit;
		} else {
			$error = $this->error($model->getError());
		}
	}
}









