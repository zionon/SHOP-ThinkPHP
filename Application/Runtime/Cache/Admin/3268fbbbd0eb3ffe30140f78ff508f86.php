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
    <span class="action-span"><a href="__GROUP__/Goods/goodsAdd">添加新商品</a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="" name="searchForm">
        <img src="/Public/Admin/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
        <!-- 分类 -->
        <select name="cat_id">
            <option value="0">所有分类</option>
            <?php if(is_array($cat_list)): foreach($cat_list as $key=>$val): ?><option value="<<?php echo ($val["cat_id"]); ?>>"><<?php echo (str_repeat('&nbsp;&nbsp;',$val["lev"])); ?>><<?php echo ($val["cat_name"]); ?>></option><?php endforeach; endif; ?>
        </select>
        <!-- 品牌 -->
        <select name="brand_id">
            <option value="0">所有品牌</option>
            <?php if(is_array($brand_list)): foreach($brand_list as $key=>$val): ?><option value="<<?php echo ($val["brand_id"]); ?>>"><<?php echo ($val["brand_name"]); ?>></option><?php endforeach; endif; ?>
        </select>
        <!-- 推荐 -->
        <select name="intro_type">
            <option value="0">全部</option>
            <option value="is_best">精品</option>
            <option value="is_new">新品</option>
            <option value="is_hot">热销</option>
        </select>
        <!-- 上架 -->
        <select name="is_on_sale">
            <option value=''>全部</option>
            <option value="1">上架</option>
            <option value="0">下架</option>
        </select>
        <!-- 关键字 -->
        关键字 <input type="text" name="keyword" size="15" />
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>商品名称</th>
                <th>LOGO</th>
                <th>市场价格</th>
                <th>本店价格</th>
                <th>是否上架</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            <?php foreach($data as $k => $v): ?>
            <tr>
                <td align="center"><?php echo $v['id']; ?></td>
                <td align="center" class="first-cell"><span><?php echo $v['goods_name']; ?></span></td>
                <td align="center"><img src="/Public/Uploads/<?php echo $v['sm_logo']; ?>" /></td>
                <td align="center"><?php echo $v['marker_price']; ?></td>
                <td align="center"><?php echo $v['shop_price']; ?></td>
                <td align="center"><?php echo $v['is_on_sale']; ?></td>
                <td align="center"><?php echo $v['addtime']; ?></td>
                <td align="center">
                    <a href="">修改</a>
                    <a href="">删除</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?php echo $page; ?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>
</form>

<div id="footer">
共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>