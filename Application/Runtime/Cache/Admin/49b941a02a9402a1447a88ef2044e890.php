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


<div class="tab-div">
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/Attribute/attributeAdd.html" method="post">
            <table width="90%" id="general-table" align="center">
                <tr>
                    <td class="label">属性名称：</td>
                    <td><input type="text" name="attr_name" size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">属性类型：</td>
                    <td>
                        <input type="radio" name="attr_type" value="唯一" checked="checked" />唯一 
                        <input type="radio" name="attr_type" value="可选"  />可选 
                    </td>                   
                </tr>
                <tr>
                    <td class="label">属性可选值：</td>
                    <td>
                        <textarea rows="6" cols="60" name="attr_option_values"></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="label">所属类型:</td>
                    <td>
                    <?php buildSelect('Type', 'type_id', 'id', 'type_name',I('get.type_id')); ?>
                    </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>

</html>

</body>
</html>