<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
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


<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
		<tr>
			<!-- 循环输出属性 -->
			<?php foreach ($gaData as $k => $v): ?>
				<th><?php echo $k; ?></th>
			<?php endforeach; ?>
			<th width="120">库存量</th>
			<th width="60">操作</th>
		</tr>
		<tr>
			<?php
 $gaCount = count($gaData); foreach ($gaData as $k => $v): ?>
				<td>
					<select>
						<option value="">请选择</option>
						<?php foreach ($v as $k1 => $v1): ?>
							<option value=""><?php echo $v1['attr_value']; ?></option>
						<?php echo '<?'; ?>
end foreach; ?>
					</select>
				</td>
			<?php endforeach; ?>
			<td><input type="text" name="" /></td>
			<td><input type="button" value="+" onclick="addNewTr(this)" /></td>
		</tr>
		<tr id="submit">
			<td align="center" colspan="<?php echo $gaCount+2; ?>"><input type="submit" value="提交" />
			</td>
		</tr>

	</table>
	
</div>


<script type="text/javascript">
	function addNewTr(btn){
		var tr = $(btn).parent().parent();
		if ($(btn).val() == "+") {
			var newTr = tr.clone();
			newTr.find(":button").val("-");
			$("#submit").before(newTr);
		} else {
			tr.remove();
		}
	}
</script>

</body>
</html>