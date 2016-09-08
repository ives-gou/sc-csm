<?php
/**
 * 管理员控制器
 * @author ：失策
 * Time    : 2016年09月02日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Controller;
class ManagerController extends AdminController{
	protected $model;

	public function _initialize(){
		parent::_initialize();
		$this->model = D('Manager');
	}

	public function index(){
		$map = array();
		if (IS_POST) {
			$name = I('post.name', '', 'trim');
			$this->assign('name', $name);
			$map['username|nickname'] = array('like', '%'. $name .'%');
		}
		$list = $this->model->getList($map);
		$this->assign('list', $list);
		$this->display();
	}

	public function add(){
		if (IS_POST) {
			$post = I('post.');
			$data = $this->model->create($post);
			if (!$data) return show(300, $this->model->getError());

			if (isset($data['id'])) {
				$result = $this->model->editRow($data);
			} else {
				$result = $this->model->addRow($data);
			}

			if (!$result) return show(300, '操作失败');
			return show(200, '操作成功', true);
		} else {
			$this->display();
		}
	}

	public function edit(){
		$id = I('get.id', 0, 'intval');
		$info = $this->model->getInfo($id);
		if (empty($info)) return show(300, '获取数据失败');
		$this->assign('info', $info);
		$this->display();
	}

	public function auth(){
		if (IS_POST) {
			$uid = I('post.uid', 0, 'intval');
			if ($uid == 0) return show(300, '参数提交错误');
			//删除已存在角色
			$table = M('auth_group_access');
			$table->where('uid = '.$uid)->delete();

			$group_id = I('post.group_id');
			if (!empty($group_id)) {
				$datas = array();
				foreach ($group_id as $v) {
	                $data['uid'] = $uid;
	                $data['group_id'] = $v;
	                $datas[] = $data;
	            }
	            $result = $table->addAll($datas);
	            if (!$result) return show(300, '操作失败');
	        }
			return show(200, '操作成功', true);
		} else {
			$uid = I('get.id', 0, 'intval');
			$this->assign('uid', $uid);
			/* 获取已有角色 */
			$groups = M('auth_group_access')->field('group_id')->where('uid = '.$uid)->select();
			$groupsArr = array();
			if (is_array($groups) && !empty($groups)) {
				foreach ($groups as $v) {
					$groupsArr[] = $v['group_id'];
				}
			}
			$this->assign('groupsArr', $groupsArr);

			/* 获取所有角色 */
			$allGroup = M('auth_group')->field('id, title')->select();
			$this->assign('allGroup', $allGroup);
			$this->display();
		}
	}
}