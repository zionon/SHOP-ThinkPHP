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

	public function search() {
		$where = array();
		$data['data'] = $this->alias('a')
		->field('a.*,GROUP_CONCAT(c.pri_name) pri_name')
		->join('LEFT JOIN __ROLE_PRI__ b ON a.id=b.role_id
				LEFT JOIN __PRIVILEGE__ c ON b.pri_id=c.id')
		->where($where)
		->group('a.id')
		->select();
		return $data;
	}

	protected function _after_insert($data, $option) {
		$priId = I('post.pri_id');
		$rpModel = D('role_pri');
		foreach ($priId as $v) {
			$rpModel->add(array(
				'pri_id' => $v,
				'role_id' => $data['id'],
			));
		}
	}
}