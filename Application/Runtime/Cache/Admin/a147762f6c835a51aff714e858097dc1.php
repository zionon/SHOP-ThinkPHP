<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo $_page_title; ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
</head>
<body>
<h1>
    <?php if($_page_btn_name): ?>
    <span class="action-span"><a href="<?php echo $_page_btn_link; ?>"><?php echo $_page_btn_name; ?></a></span>
    <?php endif; ?>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title; ?> </span>
    <div style="clear: both"></div>
</h1>
<!-- 内容-->

<link rel="stylesheet" href="/Public/Home/style/home.css" type="text/css">
<link rel="stylesheet" href="/Public/Home/style/order.css" type="text/css">
<script type="text/javascript" src="/Public/Home/js/home.js"></script>
	<!-- 页面主体 start -->
	<div class="main w1210 bc mt10">
		<!-- 右侧内容区域 start -->
		<div class="content fl ml10">

			<div class="order_bd mt10">
				<table class="orders">
					<thead>
						<tr>
							<th width="10%">订单号</th>
							<th width="20%">订单商品</th>
							<th width="10%">下单会员ID</th>
							<th width="20%">订单金额</th>
							<th width="20%">下单时间</th>
							<th width="10%">订单状态</th>
							<th width="10%">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data['data'] as $k => $v): ?>
							<tr>
								<td><?php echo $v['id']; ?></td>
								<td><a href=""><?php $_arr = explode(',',$v['logo']); foreach($_arr as $k1 => $v1) showImage($v1); ?></a></td>
								<td><?php echo $v['member_id']; ?></td>
								<td>¥<?php echo $v['total_price']; ?></td>
								<td><?php echo date('Y-m-d H:i:s', $v['addtime']); ?></td>
								<td>
									<?php if($v['pay_status'] == '是'): ?>
										已支付
									<?php else: ?>
										未支付
									<?php endif; ?>
								</td>
								<td>
									<?php if($v['pay_status'] == '否'): ?>
										<a href="">查看</a> | <a href="">取消定单</a>
									<?php else: ?>
										<a href="">查看</a>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody> 
				</table>
<!-- 				<p><?php echo $data['page']; ?></p> -->
				<table id="page-table" cellspacing="0">
					<tr>
						<td width="80%">&nbsp;</td>
						<td align="center" nowrap="true">
						<?php echo $data['page']; ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- 右侧内容区域 end -->
	</div>
	<!-- 页面主体 end-->

</body>
</html>