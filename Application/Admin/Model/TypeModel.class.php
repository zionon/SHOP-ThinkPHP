<?php
//类型模型类
//命名空间
namespace Admin\Model;
use Think\Model;

class TypeModel extends Model{
	protected $insertFields = 'type_name';
	protected $updateFields = 'id,type_name';
	protected $_validate = array(
		array('type_name', 'require', '类型名称不能为空！', 1, 'regex', 3),
		array('type_name', '1,30', '类型名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('type_name', '', '类型名称已经存在！', 1, 'unique', 3),
	);

	protected function _before_delete($option){
		$attrModel = new \Admin\Model\AttributeModel();
		$attrModel->where(array(
			'type_id' => array('eq',$option['where']['id']),
		))->delete();
	}
}