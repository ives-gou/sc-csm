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
			array('username', 'require', '用户名必须'),
			array('username', '', '用户名必须唯一', 0, 'unique'),
			array('nickname', 'require', '昵称/姓名必须'),
			array('password', 'require', '密码必须', 0, '', 1),
			array('repassword','password','确认密码不正确', 0, 'confirm'),
			array('email', 'email', '邮箱格式错误或重复', 2, 'unique'),
			array('mobile','/^1[3|4|5|7|8]\d{9}$/','手机格式错误！', 2, 'regex'),
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