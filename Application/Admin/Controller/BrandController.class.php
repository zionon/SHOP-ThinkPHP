<?php
//后台品牌控制器
//命名空间
namespace Admin\Controller;
use Think\Controller;

class BrandController extends Controller{

	//品牌添加
	public function brandAdd() {
		//判读用户是否提交了表单
		if (IS_POST) {
			$model = new \Admin\Model\BrandModel();
			// $model = D('Brand');
			//create方法接收post过来的数据
			if ($model->create(I('post.'), 1)) {
				if ($model->add()) {
					//添加成功跳转到品牌列表
					$this->success('添加品牌成功！！',U('brandList'));
					exit;
				}
			} else {
				//获取错误信息
				$error = $model->getError();
				//输出错误信息
				$this->error($error);
			}
		} else {
			//设置页面信息
			$this->assign(array(
				'_page_title' => '添加品牌',
				'_page_btn_name' => '品牌列表',
				'_page_btn_link' => U('brandList'),
				));
			$this->display();
		}
	}

	//品牌列表
	public function brandList() {
		$model = new \Admin\Model\BrandModel();
		//返回数据和翻页
		$data = $model->search();
		$this->assign($data);
		//设置页面信息
		$this->assign(array(
			'_page_title' => '品牌列表',
			'_page_btn_name' => '添加品牌',
			'_page_btn_link' => U('brandAdd'),
			));
		$this->display();
	}

	//修改品牌
	public function brandEdit() {
		$id = I('get.id');
		$model = new \Admin\Model\BrandModel();
		if (IS_POST) {
			if ($model->create(I('post.'), 2)) {
				if (FALSE !== $model->save()) {
					$this->success('修改成功！！',U('brandList'));
					exit;
				} else {
					$error = $model->getError();
					$this->error($error);
				}
			}
		}
		//根据ID取出要修改的品牌
		$data = $model->find($id);
		$this->assign('data',$data);
		$this->assign(array(
			'_page_title' => '修改品牌',
			'_page_btn_name' => '品牌列表',
			'_page_btn_link' => U('brandList'),
			));
		$this->display();

	}

	//删除品牌
	public function delete() {
		$model = new \Admin\Model\BrandModel();
		if (FALSE !== $model->delete(I('get.id'))) {
			$this->success('删除成功',U('brandList'));
			exit;
		} else {
			$this->error('删除失败！原因：',$this->getError());
		}
	}
}










