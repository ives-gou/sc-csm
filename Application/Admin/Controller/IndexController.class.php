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