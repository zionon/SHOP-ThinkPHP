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
		//获取当前时间并添加到表单中这样就会插入到数据库中
		$data['addtime'] = date('Y-m-d H:i:s',time());
	}
}