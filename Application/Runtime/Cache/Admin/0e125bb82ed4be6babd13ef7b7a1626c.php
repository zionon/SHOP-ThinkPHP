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
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/Goods/goodsEdit/id/%3Cimg%20%20%20src='/Public/Uploads/'%20/%3E" method="post">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
            <table width="90%" id="general-table" align="center" class="tab_table">
                <tr>
                    <td class="label">所在品牌：</td>
                    <td>
                        <?php buildSelect('brand','brand_id','id','brand_name',$data['brand_id']); ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" size="60" value="<?php echo $data['goods_name']; ?>" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">LOGO:</td>
                    <td>
                    <img src="<?php showImage($v['mid_logo']); ?>" />
                    <input type="file" name="logo" size="60" />
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="<?php echo $data['shop_price']; ?>" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="<?php echo $data['market_price']; ?>" size="20" />
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是" <?php if($data['is_on_sale'] == '是') echo "checked='checked'"; ?> /> 是
                        <input type="radio" name="is_on_sale" value="否" <?php if($data['is_on_sale'] == '否') echo "checked='checked'"; ?> /> 否
                    </td>
                </tr>
            </table>
            <!-- 商品描述 -->
            <table style="display: none" width="90%" class="tab_table" align="center">
                <tr>
                    <td class="label">商品简单描述：</td>
                    <td>
                        <textarea id="goods_desc" name="goods_desc"><?php echo $data['goods_desc']; ?></textarea>
                    </td>
                </tr>                
            </table>
            <!-- 会员价格 -->
            <table style="display: none" width="90%" class="tab_table" align="center">
                <tr>
                    <td class="label">会员价格：</td>
                    <td>
                        <?php foreach ($mlData as $k => $v): ?>
                            <?php echo $v['level_name']; ?>：¥<input value="<?php echo $mpData[$v['id']]; ?>" type="text" name="member_price[<?php echo $v['id']; ?>]" size="8" />元<br />
                        <?php endforeach; ?>
                    </td>
                </tr>                
            </table>
            <!-- 商品属性 -->
            <table style="display: none" width="90%" class="tab_table" align="center">
                <tr><td></td></tr>
            </table>
            <!-- 商品相册 -->
            <table style="display: none" width="90%" class="tab_table" align="center">
                <tr><td></td></tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>
</html>

<!--导入在线编辑器 -->
<link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
<script>
UM.getEditor('goods_desc', {
    initialFrameWidth:"90%",
    initialFrameHeight:350
});
</script>
<script>
//切换的代码
$("#tabbar-div p span").click(function(){
    //点击的第几个按钮
    var i = $(this).index();
    //先隐藏所有的table
    $(".tab_table").hide();
    //显示第i个table
    $(".tab_table").eq(i).show();
    //先取消原按钮的选中状态
    $(".tab-front").removeClass("tab-front").addClass("tab-back");
    //设置当前按钮选中
    $(this).removeClass("tab-back").addClass("tab-front");
});
</script>

</body>
</html>