<?php
//后台角色模型
//命名空间
namespace Admin\Model;
use Think\Model;

class RoleModel extends Model{
	//调用create允许接收的字段
	protected $insertFields = 'role_name';
	protected $updateFields = 'id,role_name';
	//验证
	protected $_validata = array(
		array('role_name','require','用户名不能为空!!',1),
	);
}