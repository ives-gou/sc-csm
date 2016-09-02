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
class IndexController extends AdminController {
    public function index(){
        $map = array(
                'status' => 1,
                'menutype' => array('neq', 3),
            );
        $menuList = D('AuthRule')->getMenu($map);
        $menuList = \Common\Lib\ArrayTree::list2tree($menuList);
       
        $this->assign('menuList', $menuList);
        $this->display();
    }

    public function index_layout(){
        $this->display();
    }
}