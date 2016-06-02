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
			$_POST['addtime'] = date("Y-m-d;H:m:s");
			if ($model->create(I('post.'),1)) {
				//插入到数据库中
				if ($model->add()) {
					//显示成功信息并等待1秒之后跳转
					$this->success('操作成功！',U('lst'));
					exit;
				}
			}
			//如果走到这说明上面失败了，在这里处理失败的请求
			//从模型中取出失败的原因
			$error = $model->getError();
			//由控制器显示错误信息，并在3秒跳回上一个页面
			$this->error($error);
		}
		//显示表单
		$this->display();
	}

	public function lst() {
		echo "显示商品列表";
	}
}








