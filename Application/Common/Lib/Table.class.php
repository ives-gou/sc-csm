<?php
/**
 * 数据表操作类
 * @author ：失策
 * Time    : 2016年09月07日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Common\Lib;
use Think\Model;
class Table{
    private $tablesName = array();
    private $model = null;
    private $error = '数据错误';

    public function __construct(){
        $this->model = M();
    }

    /**
     * 获取错误信息
     */
    public function getError(){
        return $this->error;
    }

    /** 
     * 获取全部表名
     * sql:show tables;
     */
    public function getTablesName() {
        if(empty($this->tablesName)){
            $data = $this->model->query("SHOW TABLES");
            foreach ($data as $v) {
                $tables[] = $v['tables_in_' . C("DB_NAME")];
            }
            $this->tablesName = $tables;
        }
        return $this->tablesName;
    }

    /**
     * 检查表是否存在
     */
    public function tableExist($table) {
        $tables = $this->getTablesName();
        return in_array($table, $tables) ? true : false;
    }

    /**
     * 获取所有数据表信息
     * SHOW TABLE STATUS
     */
    public function getTables(){
        return $this->model->query('SHOW TABLE STATUS');
    }

    /**
     * 获取表结构
     * show columns from table --;
     */
    public function getTalbeColumns($table){
        if ($this->tableExist($table)) {
            return $this->model->query("show columns from " . $table);
        } else {
            return false;
        }
    }

    /**
     * 获取生成表的SQL语句
     * sql:show create table --;
     */
    public function getCreateSql($table) {
        if($this->tableExist($table)){
            $result=$this->model->query("show create table " . $table);
            return $result[0]['create table'];
        }else{
            return false;
        }
    }

    /**
     * 优化表
     * @param  String $tables 表名
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function optimize($tables = null){
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
    public function repair($tables = null){
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

    /**
     * 备份数据库
     * @param  String  $tables 表名
     */
     public function backup($tables=array()){

        if(empty($tables) && !is_array($tables)) {
            $this->error = '数据表名不能为空，请检查后重试！';
            return false;
        }
        //检测备份路径
        $path = C('DATA_BACKUP_PATH');
        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }elseif(!is_writeable($path)){
            $this->error='备份目录不存在或不可写，请检查后重试！';
            return false;
        }

        //读取备份配置
        $config = array(
            'path'     => realpath($path) . DIRECTORY_SEPARATOR,
            'part'     => C('DATA_BACKUP_PART_SIZE'),  //分卷大小:20971520
            'compress' => C('DATA_BACKUP_COMPRESS'),  //开启压缩:1
            'level'    => C('DATA_BACKUP_COMPRESS_LEVEL'),  //压缩级别(1-9):4
        );

        //检测文件锁
        $lock = "{$config['path']}backup.lock";
        if(is_file($lock)){
            $this->error='检测到有一个备份任务正在执行，请稍后再试！';
            return false;
        } else {
            //创建锁文件
            file_put_contents($lock, NOW_TIME);
        }
        
        //暂存备份文件信息
        $file = array(
            'name' => date('Ymd-His', NOW_TIME),
            'part' => 1,
        );

        $Database = new \Common\Lib\Database($file, $config);

        foreach ($tables as $table) {
            $start = 0;
            do{
                $start=$Database->backup($table, $start);
                if(is_array($start)){
                    $start=$start[0];
                }elseif($start === false){
                    unlink($lock);
                    $this->error = "备份到{$table}表时发生错误";
                    return false;
                }
            }while( $start != 0 );
        }
        //删除文件锁
        unlink($lock);
        return true;
    }


    //获取备份文件列表
    public function backupList(){
        $fileDir = C('DATA_BACKUP_PATH');
        if(!is_dir($fileDir)) return false;

        $listFile = glob($fileDir . '*.sql*');
        if(is_array($listFile)){
            $list=array();
            foreach ($listFile as $key => $value) {
                $list[$key]['create'] = date('Y-m-d H:i:s',filemtime($value));
                $list[$key]['size'] = filesize($value);
                $value = end(explode('/', $value));
                $list[$key]['name'] = $value;
                $list[$key]['type'] = end(explode('.', $value));
                $fileName = explode('-', $value);
                $list[$key]['time'] = $fileName[0].'-'.$fileName[1];
            }
        }
        return array_reverse($list);
    }

    //还原数据库
    public function backupImport($time){
        $name  = $time . '-*.sql*';
        $fileDir  = C('DATA_BACKUP_PATH');
        $path = realpath($fileDir) . DIRECTORY_SEPARATOR . $name;
        $files = glob($path);
        $list  = array();
        foreach($files as $name){
            $basename = basename($name);
            $match = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
            $gz = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
            $list[$match[6]] = array($match[6], $name, $gz);
        }
        ksort($list);
        //检测文件正确性
        $last = end($list);
        if(!count($list) === $last[0]){
            $this->error = '备份文件可能已经损坏，请检查！';
            return false;
        }

        //还原数据库
        $start = 0;
        foreach ($list as $value) {
            $file = $value;
            $config = array(
                'path'     => realpath($fileDir) . DIRECTORY_SEPARATOR,
                'compress' => $value[2],
            );
            $Database = new \Common\Lib\Database($file, $config);
            do{
                $start = $Database->import($start);
                if($start === false){
                    $this->error = '恢复数据失败，请稍后再试！';
                    return false;
                }elseif(is_array($start) && $start[0] != $start[1]){
                    $start=$start[0];
                }
            }while($start != 0);
        }
        return true;

    }

    //删除备份文件
    public function backupDel($time){
        $name  = $time . '-*.sql*';
        $fileDir = C('DATA_BACKUP_PATH');
        $path  = $fileDir . $name;
        array_map("unlink", glob($path));
        if(empty(glob($path))){
            return true;
        } else {
            return false;
        }
    }


}