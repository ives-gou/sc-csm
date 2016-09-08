<?php
/**
 * 管理员控制模型
 * @author ：失策
 * Time    : 2016年09月02日 
 * QQ      : 664709989   
 * Email   : 664709989@qq.com
 * Site    : http://www.iamgpj.com/
 */
namespace Admin\Model;
use Think\Model;
class ManagerModel extends Model{
    //自动验证
    protected $_validate = array(
            array('username', 'require', '用户名必须'),
            array('username', '', '用户名必须唯一', 0, 'unique'),
            array('nickname', 'require', '昵称/姓名必须'),
            array('password', 'require', '密码必须', 0, '', 1),
            array('repassword','password','确认密码不正确', 0, 'confirm'),
            array('email', 'email', '邮箱格式错误或重复', 2, 'unique'),
            array('mobile','/^1[3|4|5|7|8]\d{9}$/','手机格式错误！', 2, 'regex'),
            array('status', array(0, 1), '状态所属区间错误', 1, 'in'),
        );

    public function login($username, $password){
        $map = array(
                'username' => $username,
                'password' => $this->pw_md5($password),
                'status'   => 1
            );
        $info = $this->where($map)->find();
        if (empty($info)) return false;
        
        $this->updateLogin($info['id']);
        session('userinfo', $info);
        session(C('AUTH_KEY'), $info['id']);
        return true;
    }

    /* 密码加密 */
    private function pw_md5($password){
        $str = 'AHJKJsahdjk45645';
        return md5($str . $password);
    }

    /**
     * 更新用户登录信息
     * @param  integer $uid 用户ID
     */
    private function updateLogin($uid){
        $data = array(
            'id'              => $uid,
            'last_login_time' => time(),
            'last_login_ip'   => get_client_ip(1),
        );
        $this->save($data);
    }

    /* 获取管理员列表 */
    public function getList($map){
        $list = $this->where($map)->select();
        return $list;
    }

    /* 获取用户信息 */
    public function getInfo($id){
        $info = $this->where('id = '.$id)->find();
        return $info;
    }

    /**
     * 添加管理员数据
     * @param [arr] $data 提交的数据 
     */
    public function addRow($data){
        $data['password'] = $this->pw_md5($data['password']);
        $data['reg_time'] = time();
        $data['reg_ip']   = get_client_ip(1);
        $result = $this->add($data);
        return $result;
    }

    /**
     * 修改管理员数据
     * @param [arr] $data 提交的数据 
     */
    public function editRow($data){
        $data['update_time'] = time();
        if (!empty($data['password'])) {
            $data['password'] = $this->pw_md5($data['password']);
        } else {
            unset($data['password']);
        }
        $result = $this->where('id = '.$data['id'])->save($data);
        return $result;
    }
}