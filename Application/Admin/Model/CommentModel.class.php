<?php
//评论模型类
//命名空间
namespace Admin\Model;
use Think\Model;

class CommentModel extends Model{
	//评论是允许提交的字段
	protected $insertFields = array('star','content','goods_id');

	//发表评论时表单验证规则
	protected $_validate = array(
		array('goods_id','require','参数错误',1),
		array('star','1,2,3,4,5','分值只能是1~5之间的数字',1,'in'),
		array('content','1,200','内容必须是1～200个字符',1,'length'),
		);

	protected function _before_insert(&$data,$option){
		//验证是否登录
		$memberId = session('m_id');
		if (!$memberId) {
			$this->error = '必须先登录!!';
			return FALSE;
		}
		$data['member_id'] = $memberId;
		$data['addtime'] = date('Y-m-d H:i:s');
	}
}