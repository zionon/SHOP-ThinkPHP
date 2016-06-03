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
<!-- 搜索表单 -->
<div class="form-div">
    <form action="/index.php/Admin/Goods/goodsList" method="GET" name="searchForm">
        <p>
            商品名称:
            <input type="text" name="gn" size="60" value="<?php echo I('get.gn'); ?>" />
        </p>
        <p>
            价   格:
            从<input type="text" name="fp" size="8" value="<?php echo I('get.fp'); ?>" />
            到<input type="text" name="tp" size="8" value="<?php echo I('get.tp'); ?>" />
        </p>
        <p>
            是否上架:
            <?php $ios = I('get.ios'); ?>
            <input type="radio" name="ios" value="" <?php if($ios == '') echo 'checked="checked"'; ?> />全部
            <input type="radio" name="ios" value="是" <?php if($ios == '是') echo 'checked="checked"'; ?> />上架
            <input type="radio" name="ios" value="否" <?php if($ios == '否') echo 'checked="checked"'; ?> />下架
        </p>
        <p>
            添加时间:
            从<input type="text" name="fa" value="<?php echo I('get.fa'); ?>" size="20" />
            到<input type="text" name="ta" value="<?php echo I('get.ta'); ?>" size="20" />
        </p>
        <p>
            排序方式:<!-- 如果odby为空 ，那么默认的id_desc -->
            <?php $odby = I('get.odby','id_desc'); ?> 
            <input type="radio" name="odby" onclick="this.parentNode.parentNode.submit();" value="id_desc" <?php if($odby == 'id_desc') echo 'checked="checked"'; ?> />以添加时间降序
            <input type="radio" name="odby" onclick="this.parentNode.parentNode.submit();" value="id_asc" <?php if($odby == 'id_asc') echo 'checked="checked"'; ?> />以添加时间升序
            <input type="radio" name="odby" onclick="this.parentNode.parentNode.submit();" value="price_desc" <?php if($odby == 'price_desc') echo 'checked="checked"'; ?> />以价格降序
            <input type="radio" name="odby" onclick="this.parentNode.parentNode.submit();" value="price_asc" <?php if($odby == 'price_asc') echo 'checked="checked"'; ?> />以价格升序  
        </p>
        <p>
            <input type="submit" value="搜索" />
        </p>
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