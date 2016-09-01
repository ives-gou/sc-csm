<?php
/**
 * 返回 json 数据
 * @param  [int] $status    300:失败，200:成功
 * @param  [string] $msg    返回信息
 * @param  [array] $data    其他信息
 * @return [json]         
 */
function show($status, $msg, $closeCurrent=false, $data=array()){
	
	$tmpArr = array(
			'statusCode' => $status,
			'message'    => $msg,
			'closeCurrent' => $closeCurrent,
		);
	$tmpArr = array_merge($tmpArr, $data);
	exit(json_encode($tmpArr));
}