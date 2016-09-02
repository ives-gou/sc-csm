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
        $this->model = D('Config');
    }

    public function index(){
        $this->display();
    }
}