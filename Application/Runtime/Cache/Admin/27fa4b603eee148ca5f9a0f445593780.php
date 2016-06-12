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
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/Role/roleEdit/id/2.html" method="post">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
            <table width="90%" id="general-table" align="center">
                <tr>
                    <td class="label">用户名：</td>
                    <td><input type="text" name="role_name" size="20" value="<?php echo $data['role_name']; ?>" /></td>
                </tr>
                <tr>
                    <td class="label">权限列表:</td>
                    <td>
                        <?php foreach ($priData as $k => $v): if(strpos(','.$rpData.',', ','.$v['id'].',') !== FALSE) $check = 'checked="checked"'; else $check = ''; ?>
                            <input <?php echo $check; ?> type="checkbox" name="pri_id[]" value="<?php echo $v['id']; ?>" level_id="<?php echo $v['level']; ?>" />
                            <?php echo str_repeat('-',8*$v['level']) . $v['pri_name']; ?>
                            <br />
                        <?php endforeach; ?>
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


<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script type="text/javascript">
    $(":checkbox").click(function(){
        //先获取点击的这个 level_id
        var tmp_level_id = level_id = $(this).attr("level_id");
        //判断时选中还是取消
        if ($(this).prop("checked")) {
            //所有的子权限也选中
            $(this).nextAll(":checkbox").each(function(k,v){
                if ($(v).attr("level_id") > level_id) {
                    $(v).prop("checked","checked");
                } else {
                    return false;
                }
            });
            //所有的上级权限也选中
            $(this).prevAll(":checkbox").each(function(k,v){
                if ($(v).attr("level_id") < tmp_level_id) {
                    $(v).prop("checked", "checked");
                    tmp_level_id--; //再找更上一级的
                }
            });
        } else {
            //所有的子权限也取消
            $(this).nextAll(":checkbox").each(function(k,v){
                if ($(v).attr("level_id") > level_id) {
                    $(v).removeAttr("checked");
                } else {
                    return false;
                }
            });
        }
    });
</script>

</body>
</html>