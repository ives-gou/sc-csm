<?php
/**
 * 后台登录控制器
 * @author ：失策
 * Time    : 2016年09月02日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller{

    /* 管理员登录 */
    public function login(){
        if (IS_POST) {
            $username = I('post.username', '', 'trim');
            $password = I('post.password', '', 'trim');
            $captcha  = I('post.captcha', '', 'trim');

            if (!$username || !$password) return show(300, '用户名或密码不能为空！');
            if (!check_verify($captcha, 1)) return show(300, '验证码错误！');
            $result = D('Manager')->login($username, $password);
            
            //记录行为
            $msg = $result ? '登录成功' : '用户名或密码错误';
            action_log('用户登录', 'Manager', $msg);
            if (!$result) return show(300, '用户名或密码错误');
            return show(200, '登录成功', false, array('url' => U('Index/index')));
        } else {
            if (is_login()) {
                $this->redirect('Index/index');
            } else {
                $this->display();
            }
        }
    }   

    /* 注销登录 */
    public function logout(){
        $uid = is_login();
        session(null);
        //记录行为
        action_log('用户注销', 'Manager', '注销成功', $uid);
        $this->redirect('Public/login');
    }

    /* 验证码 */
    public function verify(){
         $config =    array(
            //'fontSize'    =>    30,    // 验证码字体大小    
            'length'      =>    4,     // 验证码位数    
            'useNoise'    =>    false, // 关闭验证码杂点
        );
            
        $Verify = new \Think\Verify($config);
        $Verify->entry(1);
    }
}