<?php
//后台权限控制器
//命名空间
namespace Admin\Controller;
use Think\Controller;

class PrivilegeController extends Controller{
	//添加权限
	public function privilegeAdd() {
		$model = new \Admin\Model\PrivilegeModel();
		if (IS_POST) {
			// dump($_POST);die;
			if ($model->create(I('post.'),1)) {
				if ($model->add()) {
					$this->success('添加权限成功 ！',U('privilegeList'));
					exit;
				} else {
					$error = $this->error($model->getError());
				}
			}
		} else {
			$priData = $model->getTree();
			$this->assign(array(
				'priData' => $priData,
				'_page_title' => '添加权限',
				'_page_btn_name' => '权限列表',
				'_page_btn_link' => U('privilegeList'),
			));
			$this->display();
		}
	}

	//显示权限
	public function privilegeList() {
		$model = new \Admin\Model\PrivilegeModel();
		$data = $model->getTree();
		$this->assign(array(
			'data' => $data,
			'_page_title' => '权限列表',
			'_page_btn_name' => '添加权限',
			'_page_btn_link' => U('privilegeAdd'),
		));
		$this->display();
	}

	//权限修改
	public function privilegeEdit() {
		$id = I('get.id');
		$model = new \Admin\Model\PrivilegeModel();
		if (IS_POST) {
			if ($model->create(I('post.'),2)) {
				if ($model->save()) {
					$this->success('修改成功!!',U('privilegeEdit?id='.$id));
					exit;
				}
			} else {
				$error = $this->error($model->getError());
			}
		} else {
			//取出所有的分类做下拉框
			$priData = $model->getTree();
			//取出当前分类的子分类
			$children = $model->getChildren($id);
			//取出当前分类
			$data = $model->find($id);

			// dump($data);
			// dump($children);
			// dump($catData);
			// die;

			$this->assign(array(
				'children' => $children,
				'data' => $data,
				'priData' => $priData,
			));
			$this->assign(array(
				'_page_title' => '分类修改',
				'_page_btn_name' => '分类列表',
				'_page_btn_link' => U('privilegeList'),
			));
			$this->display();
		}
	}

	//删除权限
	public function delete() {
		$id = I('get.id');
		$model = new \Admin\Model\PrivilegeModel();
		if ($model->delete($id)) {
			$this->success('删除成功!!',U('privilegeList'));
			exit;
		} else {
			$error = $this->error($model->getError());
		}
	}
}










