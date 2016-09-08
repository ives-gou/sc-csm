<?php
/**
 * 权限菜单控制器
 * @author ：失策
 * Time    : 2016年09月01日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Controller;
class AuthRuleController extends AdminController {

    protected $model;

    public function _initialize(){
        parent::_initialize();
        $this->model = D('AuthRule');
    }

    public function index(){
        $menuList = $this->model->getMenu();
        $menuList = \Common\Lib\ArrayTree::tree($menuList);

        $this->assign('menuList', $menuList);
        $this->display();
    } 

    //新增
    public function add(){
        if (IS_POST) {
            $post = I('post.');
            $data = $this->model->create($post);
            if (!$data) return show('300', $this->model->getError());

            if (isset($data['id'])) {  //编辑
                if (!$this->model->surePid($data['id'], $data['pid'])) return show(300, '父菜单选择错误');
                $result = $this->model->where('id = '.$data['id'])->save($data);
            } else {  //新增
                $result = $this->model->add($data);
            }
    
            if (!$result) return show(300, '操作失败');
            return show(200, '操作成功', true);
        } else {
            //获取上级栏目列表
            $pmenu = $this->model->getMenu(array('menutype' => array('neq', 3)));
            $this->assign('pmenu', $pmenu);
            $this->display();
        }
    }

    public function edit(){
        //获取上级栏目列表
        $pmenu = $this->model->getMenu(array('menutype' => array('neq', 3)));
        $this->assign('pmenu', $pmenu);

        //获取栏目信息
        $id = I('get.id', 0, 'intval');
        $info = $this->model->getInfo($id);
        if (empty($info)) return show(300, '数据获取失败');
        //获取父菜单名称
        foreach ($pmenu as $v) {
            if ($v['id'] == $info['pid']) {
                $info['ptitle'] = $v['title'];
                break;
            }
        }
        $this->assign('info', $info);
        $this->display();
    }

    public function del(){
        $id = I('get.id', 0, 'intval');
        if (!$this->model->getChild($id)) return show(300, '请先删除子菜单');

        $result = $this->model->delete($id);
        if (!$result) return show(300, '删除失败');
        return show(200, '删除成功');
    }
}