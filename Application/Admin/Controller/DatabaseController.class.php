<?php
/**
 * 数据库管理控制器
 * @author ：失策
 * Time    : 2016年09月06日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Controller;
class DatabaseController extends AdminController{
    protected $model = null;

    public function _initialize(){
        parent::_initialize();
        $this->model = new \Common\Lib\Table();
    }

    public function index(){

        $list = $this->model->getTables();
        $this->assign('list', $list);
        $this->display();
    }

    /* 数据表 结构 */
    public function frame(){
        $name = I('get.name', '');
        $columns = $this->model->getTalbeColumns($name);
        $this->assign('columns', $columns);
        $this->display();
    }

    /* 数据表 生成语句 */
    public function createSql(){
        $name = I('get.name', '');
        $sql = $this->model->getCreateSql($name);
        $this->assign('sql', $sql);
        $this->display();
    }

    /* 数据表操作：备份、优化、修复 */
    public function export(){
        $act = I('post.act', '');
        $tables = I('post.tables', '');
        switch ($act) {
            case '备份数据表':
                $result = $this->model->backup($tables);
                break;
            case '优化数据表':
                $result = $this->model->optimize($tables);
                break;
            case '修复数据表':
                $result = $this->model->repair($tables);
                break;
            default:
                $result = false;
                break;
        }

        if (!$result) {
            return show(300, $this->model->getError());
        }
        return show(200, $act . '成功');
    }

    /* 数据库恢复 */
    public function import(){
        if (IS_POST) {
            $time = I('get.time', '');
            if(empty($time)) return show(300, '请选择数据文件');
            $result = $this->model->backupImport($time);
            
            if(!$result) return show(300, $this->model->getError());
            return show(200, '还原成功');
        } else {
            $list = $this->model->backupList();
            $this->assign('list',$list);
            $this->display();
        } 
    }

    public function delbak(){
        $time = I('get.time', '');
        if(empty($time)) return show(300, '请选择数据文件');
        $result = $this->model->backupDel($time);
        if(!$result) return show(300, '备份文件删除失败');
        return show(200, '删除成功');
    }
}