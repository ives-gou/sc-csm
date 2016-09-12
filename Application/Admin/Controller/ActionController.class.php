<?php
/**
 * 用户更行为控制器
 * @author ：失策
 * Time    : 2016年09月012日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Controller;
class ActionController extends AdminController{
	
	public function _initialize(){
		parent::_initialize();
		$this->model = D('Action');
	} 

	public function index(){
		$map = array();
		$name = I('post.name', '', 'trim');
		if (!empty($name)) {
			$map['name|title'] = array('like', '%'. $name .'%');
			$this->assign('name', $name);
		}
		$list = $this->model->where($map)->select();
		$this->assign('list', $list);
		$this->display();
	}

	public function add(){
		if (IS_POST) {
			$data = $this->model->create();
			if (!$data) return show(300, $this->model->getError());
			if (isset($data['id'])) {
				$result = $this->model->where('id = '.$data['id'])->save($data);
			} else {
				$result = $this->model->add($data);
			}
			if (!$result) return show(300, '操作失败');
			return show(200, '操作成功', true);
		} else {
			$this->display();
		}
	}

	/*----------------------------------------------------------------------------*/
	/*--------------------------------  行为日志  --------------------------------*/
	/*----------------------------------------------------------------------------*/
	public function actionlog(){
		//分页
		$pageSize = I('post.pageSize', 30, 'intval');
		$pageCurrent = I('post.pageCurrent', 1, 'intval');
		$offset = ($pageCurrent -  1) * $pageSize;

		$list = M('ActionLog')->alias('a')
				->join('sc_action b on a.action_id = b.id')
				->join('sc_manager c on a.user_id = c.id')
				->field('a.id, b.title, c.nickname, a.action_ip, a.create_time')
				->limit($offset, $pageSize)
				->select();

		$count = M('ActionLog')->count();

		$this->assign('list', $list);
		$this->assign('pageSize', $pageSize);
		$this->assign('count', $count);
		$this->display();
	}

	public function dellog(){
		if (IS_POST) {
			$ids = I('post.ids');
			if (empty($ids)) return show(300, '请选择要删除的日志');
			$result = M('ActionLog')->where(array('id' => array('in', $ids)))->delete();
		} else {
			$id = I('get.id', 0, 'intval');
			if ($id == 0) {
				$result = M('ActionLog')->where('1')->delete();
			} else {
				$result = M('ActionLog')->delete($id);
			}
		}
		if (!$result) return show(300, '删除失败');
		return show(200, '删除成功');
	}
}