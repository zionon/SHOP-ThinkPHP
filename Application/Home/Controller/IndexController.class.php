<?php
//前台首页控制器
namespace Home\Controller;

class IndexController extends NavController {

	//显示首页
    public function index() {

    	//取出疯狂抢购的商品
    	$goodsModel = new \Admin\Model\GoodsModel();
    	$goods1 = $goodsModel->getPromoteGoods();
    	$goods2 = $goodsModel->getRecGoods('is_new');	//新品
    	$goods3 = $goodsModel->getRecGoods('is_hot');	//热卖
    	$goods4 = $goodsModel->getRecGoods('is_best');	//精品
    	// dump($goods1);die;
    	
    	//取出首页楼层的数据
    	$catModel = new \Admin\Model\CategoryModel();
    	$floorData = $catModel->floorData();
    	// dump($floorData);die;
    	//设置页面信息
  		$this->assign(array(
  			'goods1' => $goods1,
  			'goods2' => $goods2,
  			'goods3' => $goods3,
  			'goods4' => $goods4,
  			'floorData' => $floorData,
  			'_show_nav' => 1,
  			'_page_title' => '首页',
  			'_page_keywords' => '首页',
  			'_page_description' => '首页',
  		));
    	$this->display();
    }

    //商品详情页
    public function goods() {

    	//接收商品的ID
    	$id = I('get.id');
    	//根据ID取出商品的详细信息
    	$gModel = new \Admin\Model\GoodsModel();
    	$info = $gModel->find($id);
    	//再根据主分类ID找出这个分类所有上级分类制作导航
    	$catModel = new \Admin\Model\CategoryModel();
    	$catPath = $catModel->parentPath($info['cat_id']);
        //取出商品的相册
        $gpModel = D('goods_pic');
        $gpData = $gpModel->where(array(
            'goods_id' => array('eq',$id),
            ))->select();
        //取出这件商品所有的属性
        $gaModel = D('goods_attr');
        $gaData = $gaModel->alias('a')
        ->field('a.*,b.attr_name,b.attr_type')
        ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id')
        ->where(array(
            'a.goods_id'=>array('eq',$id),
        ))->select();
        //整理所有的商品，把唯一的和可选的属性分开存放
        $uniArr = array();  //唯一属性
        $mulArr = array();  //可选属性
        foreach ($gaData as $k => $v) {
            if ($v['attr_type'] == '唯一') {
                $uniArr[] = $v;
            } else {
                //把同一个属性放到一起-->三维属性
                $mulArr[$v['attr_name']][] = $v;
            }
        }
        // dump($uniArr);die;
        // dump($mulArr);die;
        // 取出这件商品所有的会员价格
        $mpModel = D('member_price');
        $mpData = $mpModel->alias('a')
        ->field('a.price,b.level_name')
        ->join('LEFT JOIN __MEMBER_LEVEL__ b ON a.level_id=b.id')
        ->where(array(
            'a.goods_id' => array('eq',$id),
            ))->select();

        $viewPath = C('IMAGE_CONFIG');

    	//设置页面信息
    	$this->assign(array(
    		'info' => $info,
    		'catPath' => $catPath,
            'gpData' => $gpData,
            'gaData' => $gaData,
            'mpData' => $mpData,
            'uniArr' => $uniArr,
            'mulArr' => $mulArr,
            'viewPath' => $viewPath['viewPath'],
    		'_show_nav' => 0,
    		'_page_title' => '商品详情页',
    		'_page_keywords' => '商品详情页',
    		'_page_description' => '商品详情页',
    		));
    	$this->display();
    }

    //处理浏览历史
    public function displayHistory() {
        $id = I('get.id');
        // 先从COOKIE中取出浏览历史的ID数组
        $data = isset($_COOKIE['display_history']) ? unserialize($_COOKIE['display_history']) : array();
        // dump($data);die;
        // 把最新浏览的这件商品放到数组中的第一个位置上
        array_unshift($data, $id);
        // 去重
        $data = array_unique($data);
        // 只取数组中前6个
        if(count($data) > 6)
            $data = array_slice($data, 0, 6);
        // 数组存回COOKIE
        setcookie('display_history', serialize($data), time() + 30 * 86400, '/');
        // 再根据商品的ID取出商品的详细信息
        $goodsModel = new \Admin\Model\GoodsModel();
        // dump($_COOKIE);
        // dump($data);
        // $data[0] = 12;
        $data = implode(',', $data);
        // dump($data);
        // $orderString = "FIELD(`id`,$data)";
        // dump($orderString);
        $gData = $goodsModel->field('id,mid_logo,goods_name')->where(array(
            'id' => array('in', $data),
            'is_on_sale' => array('eq', '是'),
        ))->order(array("field(id,$data)"))->select();
        // $sql = "SELECT `id`,`mid_logo`,`goods_name` FROM `st_goods` WHERE `id` IN ($data) AND `is_on_sale` = '是' ORDER BY field(`id`,'$data')";
        // $gData = $goodsModel->query($sql);
        // echo $goodsModel->getLastSql();
        echo json_encode($gData);
    }

    //AJAX获取会员价格
    public function ajaxGetMemberPrice() {
        $goodsId = I('get.goods_id');
        $gModel = new \Admin\Model\GoodsModel();
        echo $gModel->getMemberPrice($goodsId);
    }
        
}










