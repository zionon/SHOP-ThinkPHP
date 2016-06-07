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
<!-- 引入布局文件 -->

<!-- 商品列表 -->
<div class="main-div">
<form method="POST" action="/index.php/Admin/Category/categoryEdit/id/1.html" name="main_form">
    <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <table cellpadding="3" cellspacing="1">
            <tr>
                <td class="label">上级分类:</td>
                <td>
                    <select name="parent_id">
                        <option value="0">顶级分类</option>
                        <?php foreach($catData as $k => $v): if($v['id'] == $data['id'] || in_array($v['id'], $children)) continue; if($v['id'] == $data['parent_id']) $select = 'selected="selected"'; else $select = ''; ?>
                        <option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']) . $v['cat_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">分类名称:</td>
                <td>
                    <input type="text" name="cat_name" value="<?php echo $data['cat_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="submit" value="确定" />
                    <input type="reset" class="button" value="重置" />
                </td>
            </tr>
        </table>
</form>
</div>
</body>
</html>

</body>
</html>