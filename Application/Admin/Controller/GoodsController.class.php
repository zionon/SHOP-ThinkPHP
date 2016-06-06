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
		//设置页面信息
		$this->assign(array(
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
		// 设置页面信息
		$this->assign(array(
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
		//取出所有的品牌
		$brandModel = new \Admin\Model\BrandModel();
		$brandData = $brandModel->select();
		//设置页面信息
		$this->assign(array(
			'brandData' => $brandData,
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
}








