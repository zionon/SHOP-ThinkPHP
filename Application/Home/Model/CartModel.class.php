<?php
//前台购物车模型
//命名空间
namespace Home\Model;
use Think\Model;

class CartModel extends Model{
	//加入购物车允许接收的字段
	protected $insertFields = array('goods_id','goods_attr_id','goods_number');
	//加入购物车时的表单验证规则 
	protected $_validate = array(
		array('goods_id','require','必须选择商品',1),
		array('goods_number','chkGoodsNumber','库存量不足',1,'callback'),
		);

	//检查库存量
	public function chkGoodsNumber($goodsNumber) {
		//选择的商品属性id
		$gaid = I('post.goods_attr_id');
		sort($gaid, SORT_NUMERIC);
		$gaid = implode(',', $gaid);
		//取出库存量
		$gnModel = D('goods_number');
		$gn = $gnModel->field('goods_number')->where(array(
			'goods_id' => I('post.goods_id'),
			'goods_attr_id' => $gaid,
			))->find();
		//返回库存量是否狗
		return ($gn['goods_number'] >= $goodsNumber);
	}

	//重写父类的add方法:判断如果没用登录是存COOKIE,否则村数据库
	public function add() {
		$memberId = session('m_id');
		//先把商品属性ID升序并转化成字符串
		sort($this->goods_attr_id, SORT_NUMERIC);
		$this->goods_attr_id = implode(',', $this->goods_attr_id);
		//判读有没有登录
		if ($memberId) {
			$goodsNumber = $this->goods_number;	//先把表单中的库存量存到这个变量中，否则调用find之后就没了
			//从数据库中取出数据，并存到模型中[覆盖原数据]
			$has = $this->field('id')->where(array(
				'member_id' => $memberId,
				'goods_id' => $this->goods_id,
				'goods_attr_id' => $this->goods_attr_id,))->find();
			//如果购物车中已经有这个商品就在原数量上加上这次购买的数量
			if ($has) {
				$this->where(array(
					'id' => array('eq',$has['id']),
					))->setInc('goods_number', $goodsNumber);
			} else {
				parent::add(array(
					'member_id' => $memberId,
					'goods_id' => $this->goods_id,
					'goods_attr_id' => $this->goods_attr_id,
					'goods_number' => $this->goods_number,
					));
			}
		} else {
			//从COOKIE中取出购物车的一维数组
			$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
			//先拼一个下标
			$key = $this->goods_id.'-'.$this->goods_attr_id;
			if (isset($cat[$key])) {
				$cart[$key] += $this->goods_number;
			} else {
				//把商品加进来
				$cart[$key] = $this->goods_number;
			}
			//把一维数组存回到COOKIE
			setcookie('cart',serialize($cart), time()+30*86400,'/');
		}
	}

	//把cookie中的数据移动到数据库中
	public function moveDataToDb() {
		$memberId = session('m_id');
		if ($memberId) {
			$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
			//循环购物车中每件商品
			foreach ($cart as $k => $v) {
				$_k = explode('-', $k);
				//判读数据库中是否有这件商品
				$has = $this->field('id')->where(array(
					'member_id' => $memberId,
					'goods_id' => $_k[0],
					'goods_attr_id' => $_k[1],
					))->find();
				//如果购物车中已经有这个商品就在原数量上加上这次购买的数量
				if ($has) {
					$this->where(array(
						'id' => array('eq',$has['id']),
						))->setInc('goods_number', $v);
				} else {
					parent::add(array(
						'member_id' => $memberId,
						'goods_id' => $_k[0],
						'goods_attr_id' => $_k[i],
						'goods_number' => $v,
						));
				}
			}
			setcookie('cart','',time()-1,'/');
		}
	}
}















