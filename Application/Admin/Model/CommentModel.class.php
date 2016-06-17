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

	public function search ($goodsId, $pageSize = 5) {
		//这里因为要做AJAX翻页，所以我们需要自己做翻页不能用TP自带的，自带的不是AJAX的，一点击就跳转了
		$where['a.goods_id'] = array('eq', $goodsId);

		//取出总的记录数
		$count = $this->alias('a')->where($where)->count();
		//计算总的页数
		$pageCount = ceil($count / $pageSize);
		//获取当前页
		$currentPage = max(1, (int)I('get.p'));		// >= 1的整数
		//计算limit上的第一次参数，偏移量
		$offset = ($currentPage - 1) * $pageSize;

		if ($currentPage == 1) {
			//好评率
			//取出所有的分值
			$stars = $this->field('star')->where(array('goods_id'=>array('eq',$goodsId)))->select();
			//循环所有的分值进行统计
			$hao = $zhong = $cha = 0;
			foreach ($stars as $k => $v) {
				if ($v['star'] == 3) {
					$zhong++;
				} elseif ($v['star'] > 3) {
					$hao++;
				} else {
					$cha++;
				}
			}
			$total = $hao + $zhong + $cha; 	//总的评论数
			$hao = round(($hao / $total) * 100, 2);
			$zhong = round(($zhong / $total) * 100, 2);
			$cha = round(($cha / $total) * 100, 2);
			// dump($cha);die;
			//取印象
			$yxModel = D('Yinxiang');
			$yxData = $yxModel->where(array(
				'goods_id' => array('eq', $goodsId),
				))->select();
		}


		//取数据
		$data = $this->alias('a')
		->field('a.content,a.addtime,a.star,a.click_count,b.face,b.username,COUNT(c.id) reply_count')
		->join('LEFT JOIN __MEMBER__ b ON a.member_id=b.id
			 	LEFT JOIN __COMMENT_REPLY__ c ON a.id=c.comment_id')
		->where($where)
		->order('a.id DESC')
		->limit("$offset,$pageSize")
		->group('a.id')
		->select();

		return array(
			'data' => $data,
			'pageCount' => $pageCount,
			'hao' => $hao,
			'zhong' => $zhong,
			'cha' => $cha,
			'yxData' => $yxData,
		);

	}
}


