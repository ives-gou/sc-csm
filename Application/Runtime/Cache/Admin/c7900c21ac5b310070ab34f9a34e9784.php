<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
        <form action="<?php echo U('Manager/add');?>" method="post" data-toggle="ajaxform" data-reload-navtab="true">
            <table class="table">
                <tbody>
                    <tr>
                        <td><label class="control-label">用户名：</label></td>
                        <td>
                            <input type="text" name="username" value="<?php echo ($info["username"]); ?>"> *
                        </td>
                    </tr>
                    <tr>
                        <td><label class="control-label">昵称/姓名：</label></td>
                        <td>
                            <input type="text" name="nickname" value="<?php echo ($info["nickname"]); ?>"> *
                        </td>
                    </tr>
                    <tr>
                        <td><label class="control-label">密码：</label></td>
                        <td>
                            <input type="password" name="password" placeholder="******"> *
                        </td>
                    </tr>
                    <tr>
                        <td><label class="control-label">确认密码：</label></td>
                        <td>
                            <input type="password" name="repassword" placeholder="******"> *
                        </td>
                    </tr>
                    <tr>
                        <td><label class="control-label">邮箱：</label></td>
                        <td>
                            <input type="text" name="email" value="<?php echo ($info["email"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="control-label">手机：</label></td>
                        <td>
                            <input type="text" name="mobile" value="<?php echo ($info["mobile"]); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="control-label">状态：</label></td>
                        <td colspan="2">
                            <input type="radio" name="status" value="1" data-toggle="icheck" data-label="开启"
                            <?php if(($info["status"]) == "1"): ?>checked<?php endif; ?> >
                            &nbsp;
                            <input type="radio" name="status" value="0" data-toggle="icheck" data-label="关闭"
                            <?php if(($info["status"]) == "0"): ?>checked<?php endif; ?>>
                        </td>
                    </tr>
                    
                    <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
                </tbody>
            </table>
        </form>
</div>

<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
        <li><button type="submit" class="btn-default" data-icon="save">保存</button></li>
    </ul>
</div>