<?php
//后台管理员模型
//命名空间
namespace Admin\Model;
use Think\Model;

class AdminModel extends Model{
	//调用create允许接收的字段
	protected $insertFields = 'username,password,chkcode';
	protected $updateFields = 'id,username,password';
	//验证规则
	protected $_validate = array(
		array('username','require','用户名不能为空！！',1),
		array('username','1,30','用户名的值最长不能超过30个字符!',1,'length',3),
		array('password','require','密码不能为空',1,'regex',1),
	);

	//为登录的表单定义一个验证规则
	public $_login_validate = array(
		array('username','require','用户名不能为空!',1),
		array('password','require','密码不能为空!',1),
		array('chkcode','require','验证码不能为空!',1),
		array('chkcode','check_verify','验证码错误!',1,'callback'),
		);

	//验证验证码是否正确
	function check_verify($code,$id = '') {
		$verify = new \Think\Verify();
		return $verify->check($code, $id);
	}

	public function login() {
		//从模型中获取用户名和密码
		$username = $this->username;
		$password = $this->password;
		//先查询这个用户名是否存在
		$user = $this->where(array(
			'username' => array('eq', $username),
		))->find();
		if ($user) {
			if ($user['password'] == md5($password)) {
				//登录成功寸session
				session('id',$user['id']);
				session('username', $user['username']);
				return TRUE;
			} else {
				$this->error = '密码不正确!';
				return FALSE;
			}
		} else {
			$this->error = '用户名不存在!';
		}
	}

	public function search() {
		$where = array();
		//取数据
		$data['data'] = $this->alias('a')
		->field('a.*,GROUP_CONCAT(c.role_name) role_name')
		->join('LEFT JOIN __ADMIN_ROLE__ b ON a.id=b.admin_id
				LEFT JOIN __ROLE__ c ON b.role_id=c.id')
		->where($where)
		->group('a.id')
		->select();
		return $data;
	}

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

	protected function _after_insert($data, $option) {
		$roleId = I('post.role_id');
		$arModel = D('admin_role');
		foreach ($roleId as $v) {
			$arModel->add(array(
				'admin_id' => $data['id'],
				'role_id' => $v,
			));
		}
	}
}








