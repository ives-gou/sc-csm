<?php
/**
 * 用户行为模型
 * @author ：失策
 * Time    : 2016年09月12日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Model;
use Think\Model;
class ActionModel extends Model{
	//自动验证
    protected $_validate = array(
        array('name', 'require', '标识不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
        array('name', '', '标识已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
        array('title', 'require', '名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    );

    protected $_auto = array(
        array('name', 'strtolower', self::MODEL_BOTH, 'function'),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );
}