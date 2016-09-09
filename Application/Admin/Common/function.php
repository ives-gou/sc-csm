<?php

/**
 * 状态按钮
 * @param  [int]     $status  1-启用, 2-禁用
 * @param  [int]     $id      所选栏目ID
 * @return [string]     
 */
function statusBtn($id, $status){
	$str = '<button type="button" data-toggle="doajax" data-url="'.__CONTROLLER__.'/dostatus?id='.$id.'&status='.$status.'"';
	if ($status == 1) {
		$str .= ' class="btn btn-success" data-icon="check-circle">启用</button>';
	} else {
		$str .= ' class="btn btn-danger" data-icon="minus-circle">禁用</button>';
	}
	return $str;
}

/**
 * 查询用户是否登录
 * @return int  0-未登录，大于0-登录id 
 */
function is_login(){
	$uid = session(C('AUTH_KEY'));
	return $uid > 0 ? $uid : 0;
}

// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
function check_verify($code, $id = ''){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

//检测Auth中允许访问的节点
function check_auth($rule, $uid=null){
	//不需要检测的权限节点
	if (in_array($rule, C('NO_CHECK_NODES'))) {
		return true;
	}
	if (is_null($uid)) $uid = is_login();
    static $Auth = null;
    if (!$Auth) {
        $Auth = new \Think\Auth();
    }
    if(!$Auth->check($rule, $uid, 1)){
        return false;
    }
    return true;
}

/**
 * 获取配置的类型
 * @param string $type 配置类型
 * @return string
 */
function get_config_type($type=0){
    $list = C('CONFIG_TYPE_LIST');
    return $list[$type];
}

/**
 * 获取配置的分组
 * @param string $group 配置分组
 * @return string
 */
function get_config_group($group=0){
    $list = C('CONFIG_GROUPS');
    return $group ? $list[$group] : '';
}

 /**
  * 分析枚举类型字段值 格式 a:名称1,b:名称2
  * @param  [string] $string 
  * @return [array]         
  */
function parse_config_attr($string) {
	$tmpArr = array();
	if (strpos($string, ':') === false) {
		return $tmpArr;
	}

    $array = explode(',', trim($string));
    foreach ($array as $val) {
    	list($k, $v) = explode(':', trim($val));
    	$tmpArr[$k]   = $v;
    }
    return $tmpArr;
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}
