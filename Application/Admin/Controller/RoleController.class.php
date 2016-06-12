<?php
//后台角色控制器
//命名空间
namespace Admin\Controller;
// use Think\Controller;

class RoleController extends BaseController{
	//角色添加
	public function roleAdd() {
		if (IS_POST) {
			$model = new \Admin\Model\RoleModel();
			// dump($_POST);die;
			if ($model->create(I('post.'),1)) {
				if ($model->add()) {
					$this->success('添加成功 ！',U('roleList'));
					exit;
				}
			} else {
				$error = $this->error($model->getError());
			}
		} else {
			//取出所有权限
			$priModel = new \Admin\Model\PrivilegeModel();
			$priData = $priModel->getTree();
			$this->assign(array(
				'priData' => $priData,
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
		$data = $model->search();
		// dump($data);die;
		$this->assign(array(
			'data' => $data['data'],
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
				if ($model->save() !== FALSE) {
					$this->success('修改成功',U('roleList'));
					exit;
				}
			} else {
				$error = $this->error($model->getError());
			}
		} else {
			//取出所有的权限
			$priModel = new \Admin\Model\PrivilegeModel();
			$priData = $priModel->getTree();
			$data = $model->find($id);
			// dump($priData);die;
			// 取出当前角色已经拥有的权限ID
			$rpModel = D('role_pri');
			$rpData = $rpModel->field('GROUP_CONCAT(pri_id) pri_id')->where(array(
				'role_id' => array('eq',$id),
				))->find();
			// dump($rpData['pri_id']);die;
			$this->assign(array(
				'rpData' => $rpData['pri_id'],
				'priData' => $priData,
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









