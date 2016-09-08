<?php
/**
 * 参数配置控制器
 * @author ：失策
 * Time    : 2016年09月02日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Controller;
class ConfigController extends AdminController{
    protected $model;

    public function _initialize(){
        parent::_initialize();
        $this->model = D('Config');
    }

    public function index(){
        $map = array();

        /* 分组 */
        $group = I('get.group', 0);
        if ($group != 0) {
            $map['group'] = $group;
        }
        $this->assign('group', $group);
        
        /* 筛选 */
        if (isset($_POST['name'])) {
            $name = I('post.name', '', 'trim');
            $map['name'] = array('like', '%'.$name.'%');
            $this->assign('name', $name);
        }
        /* 分页 */
        $pageCurr = I('post.pageCurrent', 1);
        $pageSize = I('post.pageSize', 30);

        $list = $this->model->getList($map, $pageCurr, $pageSize);
        $count = $this->model->getCount($map);

        $this->assign('list', $list);
        $this->assign('count', $count)->assign('pageSize', $pageSize);
        $this->display();

    }

    public function add(){
        if (IS_POST) {
            $data = $this->model->create();
            if (!$data) return show(300, $this->model->getError());

            if (isset($data['id'])) {  //编辑
                $result = $this->model->where('id = '.$data['id'])->save($data);
            } else {  //新增
                $result = $this->model->add($data);
            }
            
            if (!$result) return show(300, '操作失败');
            return show(200, '操作成功', true);
        } else {
            $this->display();
        }
    }

    public function group(){
        $group = I('get.group', 1);

        $list = $this->model
                ->field('id, name, title, extra, value, remark, type')
                ->where(array('status'=>1, 'group'=>$group))
                ->order('sort, id asc')
                ->select();
        if($list) {
            $this->assign('list',$list);
        }
        $this->assign('group', $group);
        $this->display();
    }

    public function save(){
        $post = I('post.', '', 'trim');
        foreach ($post as $name => $value) {
            $map = array('name' => $name);
            $this->model->where($map)->setField('value', $value);
        }
        return show(200, '操作成功');
    }
}