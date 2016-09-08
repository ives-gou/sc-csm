<?php
/**
 * 参数配置模型
 * @author ：失策
 * Time    : 2016年09月05日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Model;
use Think\Model;
class ConfigModel extends Model{
    //自动验证
    protected $_validate = array(
        array('name', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', '', '标识已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
        array('title', 'require', '名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    protected $_auto = array(
        array('name', 'strtoupper', self::MODEL_BOTH, 'function'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

    /**
     * 获取配置列表
     * @param  array   $map      查询条件
     * @param  integer $pageCurr 当前页
     * @param  integer $pageSize 分页条数
     * @return array            
     */
    public function getList($map=array(), $pageCurr=1, $pageSize=30){
        $offset = ($pageCurr - 1) * $pageSize;
        $list = $this->where($map)
            ->field('id, name, title, type, group, sort, status')
            ->order('sort, id asc')
            ->limit($offset, $pageSize)
            ->select();
        return $list;
    }

    /**
     * 获取配置总条数
     * @param  [array] $map 查询条件
     * @return [array]
     */
    public function getCount($map=array()){
        $count = $this->where($map)->count();
        return $count;
    }

    public function getInfo($id){
        $info = $this->where('id = '.$id)->find();
        return $info;
    }

    public function getConfig(){
        $list = $this->field('name,value,type')->where('status = 1')->select();
        $config = array();
        foreach ($list as $v) {
            switch ($v['type']) {
                case 4:
                    $config[$v['name']] = parse_config_attr($v['value']);
                    break;
                default:
                    $config[$v['name']] = $v['value'];
                    break;
            }
        }
        return $config;
    }
}