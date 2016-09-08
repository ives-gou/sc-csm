<?php
/**
 * 后台中心控制器
 * @author ：失策
 * Time    : 2016年09月01日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller{
	/* 初始化 */
	public function _initialize(){
		/* 用户是否登录 */
		if (!is_login()) {
			$this->redirect('Public/login');
		}

		 /* 读取数据库中的配置 */
        $admin_config = S('ADMIN_CONFIG');
        if (!$admin_config) {
            $admin_config = D('Config')->getConfig();
            S('ADMIN_CONFIG',$admin_config);
        }
        C($admin_config);
	}




	/* 公共状态修改 */
	public function dostatus(){
		$id = I('get.id', 0, 'intval');
		$status = I('get.status', 0, 'intval');
		$new_status = $status == 0 ? 1 : 0;
		$result = $this->model->where('id = '.$id)->save(array('status' => $new_status));

		if (!$result) return show(300, '操作失败');
		return show(200, '操作成功');
	}

	/* 公共删除方法 */
	public function del(){
		$id = I('get.id', 0, 'intval');
		if ($id == 0) return show(300, '参数类型错误');
		$result = $this->model->delete($id);
		if (!$result) return show(300, '删除失败');
		return show(200, '删除成功');
	}

	/* 公共编辑方法 */
	public function edit(){
		$id = I('get.id', 0, 'intval');
		if ($id == 0) return show(300, '参数类型错误');
		$info = $this->model->getInfo($id);
		if (empty($info)) return show(300, '获取数据失败');
		$this->assign('info', $info); 
		$this->display();
	}
}
