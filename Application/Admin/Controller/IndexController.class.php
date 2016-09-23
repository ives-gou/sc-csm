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
        //判断是否为超级管理员
        $uid = is_login();
        if (!in_array($uid, C('ADMIN_SUPER'))) {
            //获取自身角色
            $groups = M('AuthGroupAccess')->where('uid = '.$uid)->group('uid')->getField('GROUP_CONCAT(group_id)');
            //查询角色权限
            $gwhere = array('status' => 1, 'id' => array('in', explode(',', $groups)));
            $rulesArr = M('AuthGroup')->where($gwhere)->field('rules')->select();
            $rules = array();
            foreach ($rulesArr as $v) {
                $rules = array_merge($rules, explode(',', $v['rules']));
            }
            $rules = array_unique($rules);
            if (!empty($rules)) {
                $map['id'] = array('in', $rules);
            }
        }
        $menuList = D('AuthRule')->getMenu($map);
        $menuList = \Common\Lib\ArrayTree::list2tree($menuList);
        
        $userinfo = session('userinfo');
        $this->assign('nickname', $userinfo['nickname']);
        $this->assign('menuList', $menuList);
        $this->display();
    }

    public function index_layout(){
        if (function_exists('gd_info')) {
            $gd = gd_info();
            $gd = $gd ['GD Version'];
        } else {
            $gd = "不支持";
        }
        $able = get_loaded_extensions();
        $extensions_list = "";
        foreach ($able as $key => $value) {
            if ($key != 0 && $key % 20 == 0) {
                $extensions_list = $extensions_list . '<br />';
            }
            $extensions_list = $extensions_list . "{$value}&nbsp;&nbsp;";
        }

        $server_info = array(
            '操作系统' => PHP_OS,
            '主机名IP端口' => $_SERVER ['SERVER_NAME'] . ' (' . $_SERVER ['SERVER_ADDR'] . ':' . $_SERVER ['SERVER_PORT'] . ')',
            '运行环境' => $_SERVER ["SERVER_SOFTWARE"],
            '服务器语言' => getenv("HTTP_ACCEPT_LANGUAGE"),
            'PHP运行方式' => php_sapi_name(),
            '管理员邮箱' => $_SERVER['SERVER_ADMIN'],
            '程序目录' => WEB_PATH,
            'MYSQL版本' => function_exists("mysql_close") ? mysql_get_client_info() : '不支持',
            'GD库版本' => $gd,
            '上传附件限制' => ini_get('upload_max_filesize'),
            'POST方法提交限制' => ini_get('post_max_size'),
            '脚本占用最大内存' => ini_get('memory_limit'),
            '执行时间限制' => ini_get('max_execution_time') . "秒",
            '浮点型数据显示的有效位数' => ini_get('precision'),
            '内存使用状况' => round((@disk_free_space(".") / (1024 * 1024)), 5) . 'M/',
            '已用/总磁盘' => round((@disk_free_space(".") / (1024 * 1024 * 1024)), 3) . 'G/' . round(@disk_total_space(".") / (1024 * 1024 * 1024), 3) . 'G',
            '服务器时间' => date("Y年n月j日 H:i:s 秒"),
            '北京时间' => gmdate("Y年n月j日 H:i:s 秒", time() + 8 * 3600),
            '显示错误信息' => ini_get("display_errors") == "1" ? '√' : '×',
            'register_globals' => get_cfg_var("register_globals") == "1" ? '√' : '×',
            'magic_quotes_gpc' => (1 === get_magic_quotes_gpc()) ? '√' : '×',
            'magic_quotes_runtime' => (1 === get_magic_quotes_runtime()) ? '√' : '×',
            'phpinfo' => '<a href="'.U('Admin/Index/phpInfo').'" target="_blank">PHP详细信息</a>',
        );
        $this->assign('server_info', $server_info);
        $this->assign('extensions_list', $extensions_list);
        $this->display();
    }

    //修改密码
    public function changepwd(){
        if (IS_POST) {
            $post = I('post.', '', 'trim');
            if (empty($post['old_password'])) return show(300, '旧密码不能为空');
            if (empty($post['password'])) return show(300, '新密码不能为空');
            if (strlen($post['password']) < 6) return show(300, '密码必须 >= 6位数');
            if ($post['password'] != $post['password2']) return show(300, '确认密码错误');

            $id = is_login();
            $manager = D('Manager');
            $password = $manager->where('id = '.$id)->getField('password');
            if ($password != $manager->pw_md5($post['old_password'])) {
                return show(300, '密码输入错误');
            } else {
                $new_pwd = $manager->pw_md5($post['password']);
                $result = $manager->where('id = '.$id)->setField('password', $new_pwd);
                if (!$result) return show(300, '密码修改失败');
                return show(200, '密码修改成功', true);
            }
        } else {
            $this->display();
        }
    }

    //我的资料
    public function myinfo(){
        if (IS_POST) {
            $post = I('post.');
            if (empty($post['nickname'])) return show(300, '用户昵称/姓名不能为空');
            if (empty($post['password'])) return show(300, '密码必须');
            $manager = D('Manager');
            $password = $manager->where('id = '.$post['id'])->getField('password');
            if ($password != $manager->pw_md5($post['password'])) {
                return show(300, '密码输入错误');
            } else {
                $result = $manager->editRow($post);
                if (!$result) return show(300, '资料修改失败');
                return show(200, '资料修改成功', true);
            }
        } else {
            $info = M('Manager')->where('id = '.is_login())->find();
            $this->assign('info', $info);
            $this->display();
        }
    }

    public function phpinfo(){
        echo phpinfo();
    }

    //清除缓存
    public function delcache(){
        $result = del_dir(RUNTIME_PATH);
        if (!$result) {
            return show(300, '清理缓存失败');
        }
        return show(200, '清理缓存完成');
    }
}