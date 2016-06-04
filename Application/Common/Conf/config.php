<?php
return array(
	//数据库配置
	'DB_TYPE'		=> 'mysqli',
	'DB_HOST'		=> '127.0.0.1',
	'DB_CHARSET'	=> 'utf8',
	'DB_NAME'		=> 'shopThinkphp',
    'DB_USER' 	  	=> 'root', // 用户名
    'DB_PWD'      	=> 'password', // 密码
    'DB_PORT' 		=> '3306', // 端口
    'DB_PREFIX'  	=> 'st_', // 数据库表前缀

    //定义过滤I函数
    'DEFAULT_FILTER' => 'trim,htmlspecialchars',

    //图片相关的配置
    'IMAGE_CONFIG' => array(
        'maxSize' => 1024*1024,
        'exts' => array('jpg','gif','png','jpeg'),
        'rootPath' => './Public/Uploads/',  //上传图片的保存路径　->PHP要使用的路径，硬盘上的路径
        'viewPath' => '/Public/Uploads/',  //显示图片时的路径  ->浏览器用的路径，相对网站根目录
        ),
);