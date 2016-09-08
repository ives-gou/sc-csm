<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent tableContent">
    <form id="authGroup-auth-form" action="/index.php/Admin/Manager/auth.html?id=1&amp;_=1473069390170" method="post" data-toggle="ajaxform">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td width="140" align="center"><b>角色列表：</b></td>
                <td>
                    <select name="group_id[]" class="form-control" multiple style="width:100%">
                        <?php if(is_array($allGroup)): foreach($allGroup as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if(in_array($v['id'], $groupsArr)): ?>selected<?php endif; ?>><?php echo ($v["title"]); ?></option><?php endforeach; endif; ?>
                    </select>
                    <input type="hidden" name="uid" value="<?php echo ($uid); ?>">
                </td>
            </tr>
        </tbody>
    </table>
    </form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
        <li><button type="submit" class="btn-green" data-icon="save">保存</button></li>
    </ul>
</div>