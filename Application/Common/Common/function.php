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

/*
*   删除指定目录下所有文件
*   位置:Index/delCache
*/
function del_dir($dir){
    $dir = trim($dir, '/');
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != '.' && $file != '..') {
                    if (is_dir($dir.'/'.$file)) {
                        del_dir($dir.'/'.$file);
                    }else {
                        if(!unlink($dir.'/'.$file)) return false;
                    }
                }
            }
            closedir($dh);
            return true;
        }
    }
    closedir($dh);
    return false;
}