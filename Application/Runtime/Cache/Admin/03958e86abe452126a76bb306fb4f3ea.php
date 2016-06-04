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

<!-- 搜索表单 -->
<div class="form-div">
    <form action="/index.php/Admin/Brand/brandList" method="GET" name="searchForm">
        <p>
            品牌名称:
            <input type="text" name="bn" size="60" value="<?php echo I('get.bn'); ?>" />
        </p>
        <p>
            <!-- 排序方式:如果odby为空 ，那么默认的id_desc -->
            <?php $odby = I('get.odby','id_desc'); ?> 
            <input type="radio" name="odby" onclick="this.parentNode.parentNode.submit();" value="id_desc" <?php if($odby == 'id_desc') echo 'checked="checked"'; ?> />以添加时间降序
            <input type="radio" name="odby" onclick="this.parentNode.parentNode.submit();" value="id_asc" <?php if($odby == 'id_asc') echo 'checked="checked"'; ?> />以添加时间升序
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
                <th>品牌名称</th>
                <th>官方网站</th>
                <th>品牌LOGO</th>
                <th>操作</th>
            </tr>
            <?php foreach($data as $k => $v): ?>
            <tr class="tron">
                <td align="center" class="first-cell"><span><?php echo $v['brand_name']; ?></span></td>
                <td align="center"><?php echo $v['site_url']; ?></td>
                <td><?php showImage($v['logo'],40,40); ?></td>
                <td align="center">
                    <a href="">修改</a>
                    <a onclick="return confirm('确定要删除吗？');" href="<?php echo U('delete?id='.$v['id']); ?>">删除</a>
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
<!-- 引入行高亮显示 -->
<script type="text/javascript" src="/Public/datetimepicker/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>
</body>
</html>

</body>
</html>