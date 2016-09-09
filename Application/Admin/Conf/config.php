<?php
return array(
	//'配置项'=>'配置值'
	
	 /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__BJUI__' => __ROOT__ . '/Public/BJUI',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/img',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
    ),

    /* 用户信息 */
    'AUTH_KEY'  =>  'mid',
    'NO_CHECK_NODES' => array(
        '0' => 'Admin/Index/index',
        '1' => 'Admin/Index/index_layout',
    ),

    //动态配置中所需参数
    'CONFIG_GROUPS'    => array(
        1  =>  '常用配置',
        2  =>  '手机短信',
        3  =>  '电子邮箱',
        4  =>  '上传配置',
        5  =>  '系统配置',
    ),
    'CONFIG_TYPE_LIST' => array(
        1 => '数字',
        2 => '字符',
        3 => '文本',
        4 => '数组',
        5 => '枚举',
    ),
);