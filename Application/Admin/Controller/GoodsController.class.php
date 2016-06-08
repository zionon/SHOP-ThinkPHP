<?php
//后台商品控制器
//命名空间
namespace Admin\Controller;
use Think\Controller;

class GoodsController extends Controller{

	//显示和处理表单
	public function goodsAdd() {
		//判断用户是否提交了表单
		if (IS_POST) {
			// dump($_POST);die;
			$model = D('Goods');
			//2.create方法：a.接收数据并保存到模型中，b.根据模型中定义的规则验证表单
			/**
			 * 第一个参数:要接收的数据默认是$_POST
			 * 第二个参数:表单的类型，当前是添加还是修改的表单，1:添加2:修改
			 * $_POST:表单中原始的数据，I('post.'):过滤之后的$_POST的数据，过滤xss攻击
			 */
			if ($model->create(I('post.'),1)) {
				//插入到数据库中
				if ($model->add()) {
					//显示成功信息并等待1秒之后跳转
					$this->success('操作成功！',U('goodsList'));
					exit;
				}
			}
			//如果走到这说明上面失败了，在这里处理失败的请求
			//从模型中取出失败的原因
			$error = $model->getError();
			//由控制器显示错误信息，并在3秒跳回上一个页面
			$this->error($error);
		}
		//取出所有的品牌
		$brandModel = new \Admin\Model\BrandModel();
		$brandData = $brandModel->select();
		//取出所有的会员级别
		$mlModel = new \Admin\Model\MemberLevelModel();
		$mlData = $mlModel->select();
		//取出所有的分类做下拉框
		$catModel = new \Admin\Model\CategoryModel();
		$catData = $catModel->getTree();

		//设置页面信息
		$this->assign(array(
			'catData' => $catData,
			'mlData' => $mlData,
			'brandData' => $brandData,
			'_page_title' => '商品添加',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('goodsList'),
			));
		//显示表单
		$this->display();
	}

	//商品列表
	public function goodsList() {
		$model = D('goods');
		//返回数据和翻页
		$data = $model->search();
		// dump($data);
		$this->assign($data);
		//取出所有的分类做下拉框
		$catModel = new \Admin\Model\CategoryModel();
		$catData = $catModel->getTree();
		// 设置页面信息
		$this->assign(array(
			'catData' => $catData,
			'_page_title' => '商品列表',
			'_page_btn_name' => '商品添加',
			'_page_btn_link' => U('goodsAdd'),
			));
		$this->display();
	}

	//商品修改
	public function goodsEdit() {
		$id = I('get.id');	//要修改的商品ID
		$model = D('goods');
		if (IS_POST) {
			if ($model->create(I('post.'), 2)) {
				if (FALSE !== $model->save()) {		
					$this->success('操作成功 ！',U('goodsList'));
					exit;
				}
			}
			$error = $model->getErroe();
			$this->error($error);
		}
		//根据ID取出要修改的商品原信息
		$data = $model->find($id);
		$this->assign('data',$data);

		//取出所有的会员级别
		$mlModel = new \Admin\Model\MemberLevelModel();
		$mlData = $mlModel->select();

		//取出这件商品已经设置好的会员价格
		$mpModel = D('member_price');
		$mpData = $mpModel->where(array(
			'goods_id'=>array('eq',$id),
		))->select();
		//把取出来的二维数组转一维数组
		$_mpData = array();
		foreach ($mpData as $k => $v) {
			$_mpData[$v['level_id']] = $v['price'];
		}

		//取出相册中现有的相片
		$gpModle = D('goods_pic');
		$gpData = $gpModle->field('id,mid_pic')->where(array(
			'goods_id' => array('eq',$id),
		))->select();

		//取出所有的分类做下拉框
		$catModel = new \Admin\Model\CategoryModel();
		$catData = $catModel->getTree();

		//取出拓展分类ID
		$gcModel = D('goods_cat');
		$gcData = $gcModel->where(array(
			'goods_id' => array('eq',$id),
		))->select();

		//取出这件商品已经设置了的属性值
		$gaModel = D('goods_attr');
		$gaData = $gaModel->alias('a')
		->field('a.*,b.attr_name,b.attr_type,b.attr_option_values')
		->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id')
		->where(array(
			'a.goods_id' => array('eq', $id),
		))->select();
		//设置页面信息
		$this->assign(array(
			'gaData' => $gaData,
			'gcData' => $gcData,
			'catData' => $catData,
			'mpData' => $_mpData,
			'mlData' => $mlData,
			'gpData' => $gpData,
			'_page_title' => '修改商品',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('goodsList'),
			));
		$this->display();
	}

	//商品删除
	public function delete(){
		$model = D('goods');
		if (FALSE !== $model->delete(I('get.id'))) {
			$this->success('删除成功!',U('goodsList'));
		} else {
			$this->error('删除失败!原因:'.$model->getError());
		}
	}

	//处理AJAX删除图片的请求
	public function ajaxDelPic() {
		$picId = I('get.picid');
		//根据ID从硬盘上数据删除中删除图片
		$gpModle = D('goods_pic');
		$pic = $gpModle->field('pic,sm_pic,mid_pic,big_pic')->find($picId);
		//从硬盘删除图片
		deleteImage($pic);
		//从数据库中删除记录
		$gpModle->delete($picId);
	}

	//处理获取属性的AJAX请求
	public function ajaxGetAttr() {
		$typeId = I('get.type_id');
		$attrModel = new \Admin\Model\AttributeModel();
		$attrData = $attrModel->where(array(
			'type_id' => array('eq', $typeId),
		))->select();
		echo json_encode($attrData);
		// dump($attrData);
		// die;
	}
}








