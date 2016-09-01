<?php
/**
 * 数组操作类
 * @author ：失策
 * Time    : 2016年09月01日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Common\Lib;
class ArrayTree{

	//转为子孙树
	static public function tree($list, $root=0, $pk='id', $pid='pid'){
		$tmpArr = array();
		foreach ($list as $v) {
			if ($v[$pid] == $root) {
				$tmpArr[] = $v;
				$tmpArr = array_merge($tmpArr, self::tree($list, $v[$pk])); 
			}
		}
		return $tmpArr;
	}

	//查找族谱树
	static public function ptree($list, $id) {
		$tmpArr = array();
		foreach ($list as $v) {
			if ($v['id'] == $id) {
				$tmpArr[] = $v;
				$tmpArr = array_merge($tmpArr, self::ptree($list, $v['pid']));
			}
		}
		return $tmpArr;
	}
}