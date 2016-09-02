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

	//一维数组转多维数组
	static public function list2tree($list, $root = 0,$pk='id', $pid = 'pid', $child = '_child') {
	    // 创建Tree
	    $tree = array();
	    if(is_array($list)) {
	        // 创建基于主键的数组引用
	        $refer = array();
	        foreach ($list as $key => $data) {
	            $refer[$data[$pk]] =& $list[$key];
	        }
	        foreach ($list as $key => $data) {
	            // 判断是否存在parent
	            $parentId =  $data[$pid];
	            if ($root == $parentId) {
	                $tree[] =& $list[$key];
	            }else{
	                if (isset($refer[$parentId])) {
	                    $parent =& $refer[$parentId];
	                    $parent[$child][] =& $list[$key];
	                }
	            }
	        }
	    }
	    return $tree;
	}
}