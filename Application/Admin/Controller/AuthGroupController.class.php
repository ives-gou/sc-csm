<?php
/**
 * 角色管理控制器
 * @author ：失策
 * Time    : 2016年09月02日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Controller;
class AuthGroupController extends AdminController{
	protected $model;

	public function _initialize(){
		$this->model = M('auth_group');
	}

	/* 角色列表 */
	public function index(){
		$map = array();
		if (IS_POST) {
			$title = I('post.title', '', 'trim');
			$this->assign('title', $title);
			$map['title'] = array('like', '%'. $title .'%');
		}
		$groupList = $this->model->where($map)->order('sort, id asc')->select();
		$this->assign('groupList', $groupList);
		$this->display();
	}

	/* 角色新增 */
	public function add(){
		if (IS_POST) {
			$post = I('post.', '', 'trim');
			if (empty($post['title'])) return show(300, '角色标题必须');
			
			if (isset($post['id'])) {  /* 编辑 */
				$result = $this->model->where('id = '.$post['id'])->save($post);
			} else {  /* 新增 */
				$result = $this->model->add($post);
			}

			if (!$result) return show(300, '操作失败');
			return show(200, '操作成功', true);
		} else {
			$this->display();
		}
	}

	/* 角色编辑 */
	public function edit(){
		$id = I('get.id', 0, 'intval');
		$info = $this->model->where('id = '.$id)->find();
		if (empty($info)) return show(300, '获取数据失败');
		$this->assign('info', $info);
		$this->display();
	}

	/* 角色授权 */
	public function auth(){
		if (IS_POST) {
			$id = I('post.id', 0, 'intval');
			$rules = I('post.rules', '', 'trim');
			$result = $this->model->where('id = '.$id)->setField('rules', $rules);

			if (!$result) return show(300, '授权失败');
			return show(200, '授权成功', true);
		} else {
			$id = I('get.id', 0, 'intval');
			//获取已授权限 与 所有菜单
			$rules_str = $this->model->where('id = '.$id)->getField('rules');
			$rules_arr = explode(',', $rules_str);
			$data = D('AuthRule')->getMenu();

			$this->assign('rules', $rules_arr)->assign('id', $id);
			$this->assign('data', $data);
			$this->display();
		}
	}
}
