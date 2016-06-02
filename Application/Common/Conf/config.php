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
);