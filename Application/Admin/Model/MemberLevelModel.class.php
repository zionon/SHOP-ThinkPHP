<?php
//会员级别模型类
//命名空间
namespace Admin\Model;
use Think\Model;
class MemberLevelModel extends Model{
	//调用create方法允许接收的字段
	protected $insertFields = 'level_name,jifen_bottom,jifen_top';
	protected $updateFields = 'id,level_name,jifen_bottom,jifen_top';
	//定义验证规则
	protected $_validate = array(
		array('level_name','require','会员级别名称不能为空',1),
		);
}