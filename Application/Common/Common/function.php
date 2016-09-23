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

/**
 * 获取ip详细信息
 * @param  [int] $intIp  ip (ip2long后)
 * @param  [obj] $ipobj  实例化对象
 * @return [string]        
 */
function ipInfo($intIp, $ipobj=null) {
    $ip = long2ip($intIp);
    if (!$ipobj) {
        $ipobj = new Org\Net\IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
    }
    $tmpArr = $ipobj->getlocation($ip); // 获取某个IP地址所在的位置
    
    return $tmpArr['ip'].';'.$tmpArr['country'].' '.$tmpArr['area'];
}

/**
 * 记录行为日志
 * @param  [string] $action  行为名称
 * @param  [string] $model   触发行为模型名
 * @param  [string] $msg     日志内容
 * @param  [int]    $user_id 执行行为用户
 * @return          
 */
function action_log($action, $model, $msg, $user_id=null){
    //参数检查
    if (empty($action) || empty($model) || empty($msg)) {
        return '参数不能为空';
    }
    if(empty($user_id)){
        $user_id = is_login();
    }

    $data = array(
        'name'        =>    $action,
        'model'       =>    $model,
        'remark'      =>    $msg,
        'user_id'     =>    $user_id,
        'action_ip'   =>    get_client_ip(1),
        'create_time' =>    time()
    );
    $result = M('ActionLog')->add($data);
    return $result;
}
