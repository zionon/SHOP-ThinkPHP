<?php
//前台会员控制器
//命名空间
namespace Home\Controller;
use Think\Controller;

class MemberController extends Controller{

	//制作验证码
	public function chkcode(){
		$Verify = new \Think\Verify(array(
			'fontSize' => 30,		//验证码字体大小
			'length' => 4,			//验证码位数
			'useNoise' => TRUE,		//关闭验证码杂点
			));	
		$Verify->entry();
	}

	//登录
	public function login() {
		if (IS_POST) {
			$model = new \Admin\Model\MemberModel();
			if ($model->validate($model->_login_validate)->create()) {
				if ($model->login()) {
					$this->success('登录成功!',U('/'));
					exit;
				}
			} else {
				$this->error($model->getError());
			}
		} else {
			$this->assign(array(
				'_page_title' => '登录',
				'_page_keywords' => '登录',
				'_page_description' => '登录',
				));
			$this->display();
		}
	}

	//注册
	public function regist() {
		if (IS_POST) {
			$model = new \Admin\Model\MemberModel();
			if ($model->create(I('post.'),1)) {
				if ($model->add()) {
					$this->success('注册成功!!',U('login'));
					exit;
				}
			} else {
				$this->error($model->getError());
			}
		} else {
			$this->assign(array(
				'_page_title' => '注册',
				'_page_keywords' => '注册',
				'_page_description' => '注册',
				));
			$this->display();
		}
	}

	//登出
	public function logout() {
		$model = new \Admin\Model\MemberModel();
		$model->logout();
		redirect('/');
	}

	//AJAX处理登录状态
	public function ajaxChkLogin() {
		if (session('m_id')) {
			echo json_encode(array(
				'login' => 1,
				'username' => session('m_username'), 
				));
		} else {
			echo json_encode(array(
				'login' => 0,
				));
		}
	}
}
















