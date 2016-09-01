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