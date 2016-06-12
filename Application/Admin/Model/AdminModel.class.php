<?php
//后台管理员模型
//命名空间
namespace Admin\Model;
use Think\Model;

class AdminModel extends Model{
	//调用create允许接收的字段
	protected $insertFields = 'username,password';
	protected $updateFields = 'id,username,password';
	//验证规则
	protected $_validate = array(
		array('username','require','用户名不能为空！！',1),
		array('username','1,30','用户名的值最长不能超过30个字符!',1,'length',3),
		array('password','require','密码不能为空',1,'regex',1),
	);

	protected function _before_insert(&$data, $option) {
		// dump($data);die;
		$data['password'] = md5($data['password']);
	}

	protected function _before_delete($option) {
		//超级管理员无法删除
		if ($option['where']['id'] == 1) {
			$this->error = '超级管理员无法删除！';
			return FALSE;
		}
	}

	protected function _before_update(&$data, $option) {
		// dump($data);die;
		if ($data['password']) {
			$data['password'] = md5($data['password']);
		} else {
			unset($data['password']);
		}
	}
}