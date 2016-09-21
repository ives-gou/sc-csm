<?php
/**
 * 数据库备份还原管理类
 * @author ：失策
 * Time    : 2016年09月16日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 * ---------------------------------------------------------
 * 使用说明
 * $config = array(
 *     'path'     => '.\Backups\',  //备份路径
 *     'part'     => 20971520,      //分卷大小:20971520
 *     'compress' => 0,             //开启压缩:1
 *     'level'    => 4,             //压缩级别(1-9):4
 * );
 * 
 * $file = array(
 *    'name' => date('Ymd-His', NOW_TIME),
 *    'part' => 1,
 * );
 * ---------------------------------------------------------
 */

namespace Common\Lib;
use Think\Db;
class Database{
    /* 相关配置 */
    private $config = array();

    /* 备份文件信息 part - 卷号，name - 文件名 */
    private $file = array();

    /* 文件资源句柄 */
    private $fh = null;

    private $filename = '';

    /* 错误信息 */
    private $error = '';
    
    public function __construct($file=array(), $config=array()){
        $this->file = $file;
        $this->config = $config;
    }

    /**
     * 获取错误信息
     * @return [string] 
     */
    public function getError(){
        return $this->error;
    }

    /**
     * 写入SQL语句
     * @param  string $sql 要写入的SQL语句
     * @return boolean     true - 写入成功，false - 写入失败！
     */
    private function write($sql){
        $size = strlen($sql);
        /* 由于压缩原因，无法计算出压缩后的长度，这里假设压缩率为50%，
         * 一般情况压缩率都会高于50%；*/
        $size = $this->config['compress'] ? $size / 2 : $size;

       
        if (!$this->filename) {
            $path = $this->config['path'];
            $this->filename = "{$path}{$this->file['name']}_{$this->file['part']}.sql"; 
        }

        /* 判断是否重新打开一个卷 */
        if (is_null($this->fh) || (filesize($this->filename) + $size) > $this->config['part']) {
            $result = $this->open();
            if (!$result) return false;
            $this->filename = '';
        }
        
        return $this->config['compress'] ? gzwrite($this->fh, $sql) : fwrite($this->fh, $sql);  
    }

    /**
     * 写入初始数据
     * @return boolean true - 写入成功，false - 写入失败
     */
    private function create(){
        $sql  = "-- -----------------------------\n";
        $sql .= "-- Think MySQL Data Transfer \n";
        $sql .= "-- \n";
        $sql .= "-- Host     : " . C('DB_HOST') . "\n";
        $sql .= "-- Port     : " . C('DB_PORT') . "\n";
        $sql .= "-- Database : " . C('DB_NAME') . "\n";
        $sql .= "-- \n";
        $sql .= "-- Part : #{$this->file['part']}\n";
        $sql .= "-- Date : " . date("Y-m-d H:i:s") . "\n";
        $sql .= "-- -----------------------------\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";
        return $this->write($sql);
    }

    /**
     * 打开一个文件资源
     * @param  [string] $filename [文件名]
     * @return [resource]
     */
    private function open(){
        
        if (!is_null($this->fh)) {
            $this->config['compress'] ? gzclose($this->fh) : fclose($this->fh);
        }

        if ($this->config['compress']) {
            $this->fh = gzopen($this->filename.'.gz', 'a'.$this->config['level']);
        } else {
            $this->fh = fopen($this->filename, 'a');
        }

        if ($this->fh === false) {
            $this->error = '资源句柄打开失败';
            return false;
        } 
        $this->create();
        $this->file['part']++;
        return true; 
    }

    /**
     * 备份数据表
     * @param  [array]   $tables  数据表
     * @return [boolean]         
     */
    public function backup($tables){
        //创建DB对象
        $db = Db::getInstance();
        foreach ($tables as $table) {
            //备份表结构
            if (!$this->backup_frame($db, $table)) return false;
            //备份表数据
            if (!$this->backup_datas($db, $table)) return false;
        }
        return true;
    }

    /**
     * 还原数据表
     * @param  [string]   $time  备份时间
     * @return [boolean]         
     */
    public function import($time){
        $db = Db::getInstance();
        $fileDir = realpath(C('DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR;
        $listFile = glob($fileDir . $time . '_*.sql*');

        if (!empty($listFile)) {
            foreach ($listFile as $filename) {
                $file = substr($filename, -2) == 'gz' ? gzfile($filename) : file($filename);
                foreach ($file as $row) { 
                    if (substr(trim($row), 0, 2) == '--') continue;
                    $sql .= $row;
                    if (substr(rtrim($row, "\n"), -1) == ';') {
                        $result = $db->execute($sql);
                        if ($result === false) {
                            $this->error = $row .'错误';
                            return false;
                        }
                        $sql = '';
                    }   
                }
            }
            return true;
        }
    }

    /**
     * 备份表结构
     * @param  [resouce] $db      数据库资源
     * @param  [string]  $table   数据表名
     * @return [boolean]
     */
    private function backup_frame($db, $table){
        $result = $db->query("SHOW CREATE TABLE `{$table}`");
        $sql  = "\n";
        $sql .= "-- -----------------------------\n";
        $sql .= "-- Table structure for `{$table}`\n";
        $sql .= "-- -----------------------------\n";
        $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
        $sql .= trim($result[0]['create table']) . ";\n\n";
        if(!$this->write($sql)){
            $this->error = '备份数据表 '.$table.' 结构出错';
            return false;
        }
        return true;
    }

    /**
     * 备份表数据
     * @param  [resouce] $db      数据库资源
     * @param  [string]  $table   数据表名
     * @return [boolean]
     */
    private function backup_datas($db, $table){
        //数据总数
        $result = $db->query("SELECT COUNT(*) AS count FROM `{$table}`");
        $count  = $result['0']['count'];

        //备份表数据
        if($count){
            //写入数据注释
            $sql  = "-- -----------------------------\n";
            $sql .= "-- Records of `{$table}`\n";
            $sql .= "-- -----------------------------\n";
            $this->write($sql);
            //备份数据记录
            $result = $db->query("SELECT * FROM `{$table}`");
            foreach ($result as $row) {
                $sql = "INSERT INTO `{$table}` VALUES ('" .implode("', '", $row) . "');\n";
                if($this->write($sql) === false){
                    $this->error = $sql.' 写入失败';
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 析构方法，用于关闭文件资源
     */
    public function __destruct(){
        $this->config['compress'] ? gzclose($this->fh) : fclose($this->fh);
    }

}