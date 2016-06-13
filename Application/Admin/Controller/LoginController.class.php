<?php
//后台登录控制器
//命名空间
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller {
	public function login() {
		if (IS_POST) {
			// dump($_POST);die;
			$model = new \Admin\Model\AdminModel();
			if ($model->validate($model->_login_validate)->create()) {
				if ($model->login()) {
					$this->success('登录成功!',U('Index/index'));
					exit;
				} else {
					$this->error($model->getError());
				}
			} else {
				// $this->error($model->getError());
				redirect('Login/login');
			}
		} else {
			$this->display();
		}
	}

	public function logout() {
		$model = new \Admin\Model\AdminModel();
		$model->logout();
		redirect('login');
	}

	public function chkcode() {
		$Verify = new \Think\Verify(array(
			'fontSize' => 30,		//验证码字体大小
			'length' => 4,			//验证码位数
			'useNoise' => TRUE,		//关闭验证码杂点
		));
		$Verify->entry();
	}
}