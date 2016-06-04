<?php
//品牌模型类
//命名空间
namespace Admin\Model;
use Think\Model;

class BrandModel extends Model{
	//添加调用create方法允许接收的字段
	protected $insertFidlds = 'brand_name,site_url';

	//定义验证规则
	protected $_validate = array(
		array('brand_name','require','品牌名称不能为空！！',1),
		array('brand_name','1,30','品牌名称的值最长不能超过30个字符！',1,'length',3),
		array('site_url','1,150','官方网址的值最长不能超过150个字符！',2,'length',3),
		);

	//钩子方法
	//插入之前
	protected function _before_insert(&$data, $option) {
		//处理Logo
		//判断有没用选择图片
		if ($_FILES['logo']['error'] == 0) {
			$ret = uploadOne('logo','Brand');
			//把路径放到表单中
			$data['logo'] = $ret['images'][0];
		}
	}

	//实现翻页，排序，搜索
	public function search($perPage = 5) {


		//翻页
		//取出总的记录数
		$count = $this->count();
		//生成翻页类的对象
		$pageObj = new \Think\Page($count, $perPage);
		//设置样式
		$pageObj->setConfig('next','下一页');
		$pageObj->setConfig('prev','上一页');
		//生成页面下面显示的上一页，下一页的字符串
		$pageString = $pageObj->show();
		//取某一页的数据
		$data = $this->limit($pageObj->firstRow . ',' . $pageObj->listRows)->select();
		return array(
			'data' => $data,		//数据
			'page' => $pageString,	//翻页字符串
		);
	}
}