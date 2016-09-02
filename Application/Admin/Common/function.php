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