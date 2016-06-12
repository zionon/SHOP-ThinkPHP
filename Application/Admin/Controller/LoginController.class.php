<?php
//后台登录控制器
//命名空间
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller {
	public function login() {
		$this->display();
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