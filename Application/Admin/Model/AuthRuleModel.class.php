<?php
/**
 * 权限菜单模型
 * @author ：失策
 * Time    : 2016年09月01日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Model;
use Think\Model;
class AuthRuleModel extends Model{

	//自动验证
	protected $_validate = array(
			array('title', 'require', '菜单名必须'),
			array('name', '', 'url地址必须唯一', 0, 'unique'),
			array('status', array(0, 1), '状态所属区间错误', 1, 'in'),
		);
	/**
	 * 获取菜单列表数据
	 * @param  array  $map 查询条件
	 * @return array
	 */
	public function getMenu($map = array()){
		$menuList = $this->where($map)->order('sort, id asc')->select();
		return $menuList;
	}

	//获取数据单行信息
	public function getInfo($id){
		$info = $this->where('id = '.$id)->find();
		return $info;
	}

	//查询是否有子菜单
	public function getChild($id){
		$info = $this->where('pid = '.$id)->find();
		if (empty($info)) return true;
		return false;
	}

	//确认提交父菜单是否为 自身或自身子菜单
	public function surePid($id, $pid){
		$menuList = $this->getMenu();
		$plist = \Common\Lib\ArrayTree::ptree($menuList, $pid);;
		foreach ($plist as $v) {
			if ($v['id'] == $id) {
				return false;
			}
		}
		return true;
	} 
}