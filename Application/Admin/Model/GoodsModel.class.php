<?php
//商品模型
//命名空间
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{

	//添加时调用create方法允许接收的字段
	protected $insertFields = 'goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id';
	//修改时调用create方法允许接收的字段
	protected $updateFields = 'id,goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id';
	//定义验证规则
	protected $_validate = array(
		array('goods_name','require','商品名称不能为空!',1),
		array('market_price','currency','市场价格必须是货币类型',1),
		array('shop_price','currency','本店价格必须是货币类型',1),
		);

	//这个方法在添加之前会自动调用 －－》钩子方法
	//第一个参数:表单中即将要插入到数据库中的数据->数组
	//&按引用传递:函数内部要修改函数外部传进来的变量必须按引用传递，除非传递的是一个对象，因为对象默认是按引用传递的
	protected function _before_insert(&$data, $option) {
		//处理LOGO
		//判断有没有选择图片
		if ($_FILES['logo']['error'] == 0) {
			$ret = uploadOne('logo','Goods',array(
				array(700, 700),
				array(350, 350),
				array(130, 130),
				array(50, 50),
				));
			//把路径放到表单中
			$data['logo'] = $ret['images'][0];
			$data['mbig_logo'] = $ret['images'][1];
			$data['big_logo'] = $ret['images'][2];
			$data['mid_logo'] = $ret['images'][3];
			$data['sm_logo'] = $ret['images'][4];
		}

		//获取当前时间并添加到表单中这样就会插入到数据库中
		$data['addtime'] = date('Y-m-d H:i:s',time());
		//过滤这个字段
		$data['goods_desc'] = removeXSS($_POST['goods_desc']);
	}

	protected function _after_insert($data, $option) {
		$mp = I('post.member_price');
		$mpModel = D('member_price');
		foreach ($mp as $k => $v) {
			$_v = (float)$v;
			if ($_v > 0) {
				$mpModel->add(array(
					'price' => $_v,
					'level_id' => $k,
					'goods_id' => $data['id'],
				));
			}
		}
	}

	protected function _before_update(&$data, $option) {
		$id = $option['where']['id'];	//要修改商品的ID
		//处理LOGO
		//判断有没有选择图片
		if ($_FILES['logo']['error'] == 0) {
			$ret = uploadOne('logo','Goods',array(
				array(700, 700),
				array(350, 350),
				array(130, 130),
				array(50, 50),
				));
			//把路径放到表单中
			$data['logo'] = $ret['images'][0];
			$data['mbig_logo'] = $ret['images'][1];
			$data['big_logo'] = $ret['images'][2];
			$data['mid_logo'] = $ret['images'][3];
			$data['sm_logo'] = $ret['images'][4];

			//删除原来的图片
			//先查询出原来图片的路径
			$oldLogo = $this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
			//从硬盘上删除
			deleteImage($oldLogo);
		}

		//处理会员价格
		$mp = I('post.member_price');
		$mpModel = D('member_price');
		//先删除原来的会员价格
		$mpModel->where(array(
			'goods_id'=>$id,
		))->delete();
		//在添加会员价格
		foreach ($mp as $k => $v) {
			$_v = (float)$v;
			if ($_v > 0) {
				$mpModel->add(array(
					'price' => $_v,
					'level_id' => $k,
					'goods_id' => $id,
				));
			}
		}
		$data['goods_desc'] = removeXSS($_POST['goods_desc']);
	}

	protected function _before_delete($option) {
		$id = $option['where']['id'];	//要删除的商品ID
		//删除原来的图片
		//先查询出原来的图片的路径
		$oldLogo = $this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
		//从硬盘上删除
		deleteImage($oldLogo);
		//删除会员价格
		$mpModel = D('member_price');
		$mpModel->where(array(
			'goods_id' => array('eq', $id),
		))->delete();
	}

	/**
	 * 实现翻页，搜索，排序
	 * 
	 */
	public function search($perPage = 5) {
		//搜索
		$where = array();		//空的where条件
		//商品名称
		$gn = I('get.gn');
		if ($gn) {
			$where['goods_name'] = array('like',"%$gn%");	//WHERE goods_name LIKE '%$gn%'
		}
		//价格
		$fp = I('get.fp');
		$tp = I('get.tp');
		if ($fp && $tp) {
			$where['shop_price'] = array('between',array($fp,$tp));	//WHERE shop_price BETWEEN $fp AND $tp
		} elseif ($fp) {
			$where['shop_price'] = array('egt',$fp);	//WHERE shop_price >= $fp
		} elseif ($tp) {
			$where['shop_price'] = array('elt',$tp);	//WHERE shop_price <= $tp
		}
		//是否上架
		$ios = I('get.ios');
		if ($ios) {
			$where['is_on_sale'] = array('eq',$ios);	//WHERE is_on_sale = $ios
		}
		//添加时间
		$fa = I('get.fa');
		$ta = I('get.ta');
		if ($fa && $ta) {
			$where['addtime'] = array('between',array($fa,$ta));	//WHERE shop_price BETWEEN $fp AND $tp
		} elseif ($fa) {
			$where['addtime'] = array('egt',$fa);	//WHERE shop_price >= $fa
		} elseif ($ta) {
			$where['addtime'] = array('elt',$ta);	//WHERE shop_price <= $ta
		}
		//品牌
		$brandId = I('get.brand_id');
		if ($brandId) {
			$where['brand_id'] = array('eq',$brandId);
		}

		//排序
		$orderby = 'a.id';	//默认的排序字段
		$orderway = 'desc';	//默认的排序方式
		$odby = I('get.odby');
		if ($odby) {
			if ($odby == 'id_asc') {
				$orderway = 'asc';
			} elseif ($odby == 'price_desc') {
				$orderby = 'shop_price';
			} elseif ($odby == 'price_asc') {
				$orderby = 'shop_price';
				$orderway = 'asc';
			}
		}


		//翻页
		//取出总的记录数
		$count = $this->where($where)->count();
		//生成翻页类的对象
		$pageObj = new \Think\Page($count, $perPage);
		//设置样式
		$pageObj->setConfig('next','下一页');
		$pageObj->setConfig('prev','上一页');
		//生成页面下面显示的上一页、下一页的字符串
		$pageString = $pageObj->show();

		//取某一页的数据
		// $data = $this->order("$orderby $orderway")->where($where)->limit($pageObj->firstRow.','.$pageObj->listRows)->select();
		$data = $this->order("$orderby $orderway")		//排序
		->field('a.*,b.brand_name')
		->alias('a')
		->join('LEFT JOIN __BRAND__ b ON a.brand_id=b.id')
		->where($where)
		->limit($pageObj->firstRow.','.$pageObj->listRows)
		->select();
		//返回数据
		return array(
			'data' => $data,		//数据
			'page' => $pageString,	//翻页字符串
		);
	}
}