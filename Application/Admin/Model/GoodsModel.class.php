<?php
//商品模型
//命名空间
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{

	//添加时调用create方法允许接受的字段
	protected $insertFields = 'goods_name,market_price,shop_price,is_on_sale,goods_desc';
	//定义验证规则
	protected $_validate = array(
		array('goods_name','require','商品名称不能为空!',1),
		array('market_price','currency','市场价格必须是货币类型',1),
		array('shop_price','currency','本店价格必须是货币类型',1),
		);

	//这个方法在添加之前会自动调用 －－》钩子方法
	//第一个参数:表单中即将要插入到数据库中的数据->数组
	//&按引用传递:函数内部要修改函数外部传进来的变量必须按引用传递，除非传递的是一个对象，因为对象默认是按引用传递的
	protected function _before_insert(&$data, $option){
		//处理LOGO
		//判断有没有选择图片
		if ($_FILES['logo']['error'] == 0) {
			$upload = new \Think\Upload(); //实例化上传类
			$upload->maxSize = 1024 * 1024;	//最大上传大小
			$upload->rootPath = './Public/Uploads/';	//设置附近上传根目录
			$upload->savePath = 'Goods/';	//设置附件上传(子)目录
			//上传文件
			$info = $upload->upload();
			if (!info) {
				//获取失败原因并把错误信息保存到模型的error属性中，然后在控制器里会调用$model->getError()获取到错误信息并有控制器打印
				$this->error = $upload->getError();
				return FALSE;
			} else {
				//生成缩略图
				//先拼成原图上的路径
				$logo = $info['logo']['savepath'] . $info['logo']['savename'];
				//拼出缩略图的路径和名称
				$mbiglogo = $info['logo']['savepath'] . 'mbig_' . $info['logo']['savename'];
				$biglogo = $info['logo']['savepath'] . 'big_' . $info['logo']['savename'];
				$midlogo = $info['logo']['savepath'] . 'mid_' . $info['logo']['savename'];
				$smlogo = $info['logo']['savepath'] . 'smbig_' . $info['logo']['savename'];
				$image = new \Think\Image();
				//打开要生成缩略图的图片
				$image->open('./Public/Uploads/' . $logo);
				//生成缩略图
				$image->thumb(700, 700)->save('./Public/Uploads/' . $mbiglogo);
				$image->thumb(350,350)->save('./Public/Uploads/' . $biglogo);
				$image->thumb(130,130)->save('./Public/Uploads/' . $midlogo);
				$image->thumb(50,50)->save('./Public/Uploads/' . $smlogo);
				//把路径放到表单中
				$data['logo'] = $logo;
				$data['mbig_logo'] = $mbiglogo;
				$data['big_logo'] = $biglogo;
				$data['mid_logo'] = $midlogo;
				$data['sm_logo'] = $smlogo;
			}
		}

		//获取当前时间并添加到表单中这样就会插入到数据库中
		$data['addtime'] = date('Y-m-d H:i:s',time());
		//过滤这个字段
		$data['goods_desc'] = removeXSS($_POST['goods_desc']);
	}

	/**
	 * 实现翻页，搜索，排序
	 * 
	 */
	public function search($perPage = 3) {
		//翻页
		//取出总的记录数
		$count = $this->count();
		//生成翻页类的对象
		$pageObj = new \Think\Page($count, $perPage);
		//设置样式
		$pageObj->setConfig('next','下一页');
		$pageObj->setConfig('prev','上一页');
		//生成页面下面显示的上一页、下一页的字符串
		$pageString = $pageObj->show();

		//取某一页的数据
		$data = $this->limit($pageObj->firstRow.','.$pageObj->listRows)->select();
		//返回数据
		return array(
			'data' => $data,		//数据
			'page' => $pageString,	//翻页字符串
		);
	}
}
























