<?php
//后台权限模型类
//命名空间
namespace Admin\Model;
use Think\Model;

class PrivilegeModel extends Model{
	//调用create允许接收的字段
	protected $insertFields = 'pri_name,module_name,controller_name,action_name,parent_id';
	protected $updateFields = 'pri_name,module_name,controller_name,action_name,parent_id,id';
	//验证
	protected $_validata = array(
		array('pri_name', 'require', '权限名称不能为空！', 1, 'regex', 3),
		array('pri_name', '1,30', '权限名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('module_name', '1,30', '模块名称的值最长不能超过 30 个字符！', 2, 'length', 3),
		array('controller_name', '1,30', '控制器名称的值最长不能超过 30 个字符！', 2, 'length', 3),
		array('action_name', '1,30', '方法名称的值最长不能超过 30 个字符！', 2, 'length', 3),
		array('parent_id', 'number', '上级权限Id必须是一个整数！', 2, 'regex', 3),
	);

	//找一个分类所有子分类的ID
	public function getChildren($catId) {
		//取出所有的分类
		$data = $this->select();
		//递归从所有的分类中挑出子分类的ID
		return $this->_getChildren($data, $catId, TRUE);
	}

	private function _getChildren($data, $catId, $isClear = FALSE) {
		static $_ret = array();		//保存找到的子分类的ID
		if ($isClear) {
			$_ret = array();
		}
		//循环所有的分类找子分类
		foreach ($data as $k => $v) {
			if ($v['parent_id'] == $catId) {
				$_ret[] = $v['id'];
				//再找这个$v的子分类
				$this->_getChildren($data,$v['id']);
			}
		}
		return $_ret;
	}

	public function getTree() {
		$data = $this->select();
		return $this->_getTree($data);
	}

	private function _getTree($data, $parent_id=0, $level=0) {
		static $_ret = array();
		foreach ($data as $k => $v) {
			if ($v['parent_id'] == $parent_id) {
				$v['level'] = $level;	//用来标记这个分类是第几级的
				$_ret[] = $v;
				//找子类
				$this->_getTree($data,$v['id'],$level+1);
			}
		}
		return $_ret;
	}

	//钩子函数，删除之前
	protected function _before_delete(&$option) {
		//修改原$option,把所有子分类的ID页加进来，这样TP会一起删除
		//先找出所有子分类的ID
		$children = $this->getChildren($option['where']['id']);
		$children[] = $option['where']['id'];
		$option['where']['id'] = array(
			0 => 'IN',
			1 => implode(',', $children),
		);
	}

	//检查当前管理员是否有权限访问这个页面
	public function chkPri() {
		//获取当前管理员正要访问的模型名称、控制器名称、方法名称
		//tp中正带三个常量
		//MODULE_NAME, CONTROLLER_NAME, ACTION_NAME
		$adminId = session('id');
		//如果是超级管理员直接返回TRUE
		if ($adminId == 1) {
			return TRUE;
		}
		$arModel = D('admin_role');
		$has = $arModel->alias('a')
		->join('LEFT JOIN __ROLE_PRI__ b ON a.role_id=b.role_id
				LEFT JOIN __PRIVILEGE__ c ON b.pri_id=c.id')
		->where(array(
			'a.admin_id' => array('eq', $adminId),
			'c.module_name' => array('eq', MODULE_NAME),
			'c.controller_name' => array('eq',CONTROLLER_NAME),
			'c.action_name' => array('eq',ACTION_NAME),
		))->count();
		return ($has > 0);
	}

}












