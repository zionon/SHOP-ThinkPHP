<?php
//属性控制器
//命名空间
namespace Admin\Controller;
use Think\Controller;
class AttributeController extends Controller{
	//添加属性
	public function attributeAdd() {
		if (IS_POST) {
			$model = new \Admin\Model\AttributeModel();
			if ($model->create(I('post.'),1)) {
				if ($model->add()) {
					$this->success('属性添加成功!!',U('attributeList?p='.I('get.p').'&type_id='.I('get.type_id')));
					exit;
				}
			} else {
				$this->error($model->getError());
			}
		} else {
			$this->assign(array(
				'_page_title' => '添加属性',
				'_page_btn_name' => '属性列表',
				'_page_btn_link' => U('attributeList'),
			));
			$this->display();
		}
	}

	//显示属性列表
	public function attributeList() {
		$model = new \Admin\Model\AttributeModel();
		$data = $model->search();
		$this->assign(array(
			'data' => $data['data'],
			'page' => $data['page'],
			'_page_title' => '属性列表',
			'_page_btn_name' => '添加属性',
			'_page_btn_link' => U('attributeAdd?type_id='.I('get.type_id')),
		));
		$this->display();
	}

	//修改属性列表
	public function attributeEdit() {
		$model = new \Admin\Model\AttributeModel();
		$id = I('get.id');
		if (IS_POST) {
			if ($model->create(I('post.'), 2)) {
				if ($model->save()) {
					$this->success('修改成功!!', U('attributeList'));
					exit;
				}
			} else {
				$this->error($model->getError());
			}
		} else {
			$data = $model->find($id);
			$this->assign(array(
				'data' => $data,
				'_page_title' => '修改属性列表',
				'_page_btn_name' => '属性列表',
				'_page_btn_link' => U('attributeList'),
			));
			$this->display();
		}
	}
}











