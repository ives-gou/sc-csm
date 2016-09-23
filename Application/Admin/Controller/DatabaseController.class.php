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
        $this->model = M();
    }

    public function index(){
        $list = $this->model->query('SHOW TABLE STATUS');
        $this->assign('list', $list);
        $this->display();
    }

    /* 数据表 结构 */
    public function frame(){
        $name = I('get.name', '');
        $columns = $this->model->query("show columns from " . $name);
        $this->assign('columns', $columns);
        $this->display();
    }

    /* 数据表 生成语句 */
    public function createSql(){
        $name = I('get.name', '');
        $result = $this->model->query("show create table " . $name);
        $this->assign('sql', $result[0]['create table']);
        $this->display();
    }

    /* 数据表操作：备份、优化、修复 */
    public function export(){
        $act = I('post.act', '');
        $tables = I('post.tables', '');
        switch ($act) {
            case '备份数据表':
                $result = $this->backup($tables);
                break;
            case '优化数据表':
                $result = $this->optimize($tables);
                break;
            case '修复数据表':
                $result = $this->repair($tables);
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
            $name = I('get.name', '');
            if(empty($name)) return show(300, '请选择数据文件');
            
            $db = new \Common\Lib\Database();
            $time = reset(explode('_', $name));
            $result = $db->import($time); 
            
            if(!$result) return show(300, $db->getError());
            return show(200, '还原成功');
        } 
        return show(300, '提交方式错误');
    }

    /* 备份列表 */
    public function importList(){
        $fileDir = C('DATA_BACKUP_PATH');
        $listFile = glob($fileDir . '*.sql*');
        if(is_array($listFile)){
            $list=array();
            foreach ($listFile as $key => $value) {
                $list[$key]['create'] = date('Y-m-d H:i:s',filemtime($value));
                $list[$key]['size'] = filesize($value);
                $value = end(explode('/', $value));
                $list[$key]['name'] = $value;
                $list[$key]['type'] = end(explode('.', $value));
            }
        }
        $this->assign('list',$list);
        $this->display();
    }

    /**
     * 删除备份文件
     * @return [type] [description]
     */
    public function delbak(){
        $name = I('get.name', '');
        if(empty($name)) return show(300, '请选择数据文件');

        $time = reset(explode('_', $name));
        $likename  = $time . '_*.sql*';
        $fileDir = C('DATA_BACKUP_PATH');
        $path  = $fileDir . $likename;
        array_map("unlink", glob($path));

        if(count(glob($path))) return show(300, '备份文件删除失败');
        return show(200, '删除成功');
    }

    /**
     * 备份数据库
     * @param  String  $tables 表名
     */
     private function backup($tables=array()){

        if (empty($tables) && !is_array($tables)) {
            $this->error = '数据表名不能为空，请检查后重试！';
            return false;
        }
        //检测备份路径
        $path = C('DATA_BACKUP_PATH');
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        } elseif (!is_writeable($path)) {
            $this->error = '备份目录不存在或不可写，请检查后重试！';
            return false;
        }
        $config = array(
              'path'     => realpath($path) . DIRECTORY_SEPARATOR,  //备份路径
              'part'     => C('DATA_BACKUP_PART_SIZE'),      //分卷大小:20971520
              'compress' => C('DATA_BACKUP_COMPRESS'),             //开启压缩:1
              'level'    => C('DATA_BACKUP_COMPRESS_LEVEL'),             //压缩级别(1-9):4
        );
  
        $file = array(
            'name' => date('Ymd-His', NOW_TIME),
            'part' => 1,
        );
        $db = new \Common\Lib\Database($file, $config);
        $result = $db->backup($tables);
        if (!$result) {
            return show(300, $db->getError());
        }
        return show(200, '备份成功');
    }

    /**
     * 优化表
     * @param  String $tables 表名
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    private function optimize($tables = null){
        if($tables) {
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
            }
            $list = $this->model->query("OPTIMIZE TABLE `{$tables}`");
            if(!$list){
                $this->error = '数据表优化出错请重试！';
                return false;
            }
        } else {
            $this->error = '请指定要优化的表！';
            return false;
        }
        return true;
    }

    /**
     * 修复表
     * @param  String $tables 表名
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    private function repair($tables = null){
        if($tables) {
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
            }
            $list = $this->model->query("REPAIR TABLE `{$tables}`");
            if(!$list){
                $this->error = '数据表修复出错请重试！';
                return false;
            }
        } else {
            $this->error = '请指定要修复的表！';
            return false;
        }
        return true;
    }
}