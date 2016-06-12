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
	);
}