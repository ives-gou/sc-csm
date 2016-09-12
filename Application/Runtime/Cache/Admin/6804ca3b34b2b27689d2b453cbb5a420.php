<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
        <form action="<?php echo U('add');?>" method="post" data-toggle="ajaxform" data-reload-navtab="true">
            <table class="table">
                <tbody>
                    <tr>
                        <th>行为标识：</th>
                        <td>
                            <input type="text" name="name" value="<?php echo ($info["name"]); ?>"> （输入行为标识 英文字母）
                        </td>
                    </tr>
                    <tr>
                        <th>行为名称：</th>
                        <td>
                            <input type="text" name="title" value="<?php echo ($info["title"]); ?>"> （输入行为名称）
                        </td>
                    </tr>
                    <tr>
                        <th>行为类型：</th>
                        <td>
                            <select name="type" data-toggle="selectpicker">
                                <option value="1">系统&nbsp;&nbsp;</option>
                                <option value="2" <?php if($info['type'] == 2): ?>selected<?php endif; ?>>用户&nbsp;&nbsp;</option>
                            </select> （选择行为类型）
                        </td>
                    </tr>
                    <tr>
                        <th>行为描述：</th>
                        <td>
                            <textarea name="remark" cols="30" rows="1"><?php echo ($info["remark"]); ?></textarea> （输入行为描述）
                        </td>
                    </tr>
                    <tr>
                        <th>行为规则：</th>
                        <td>
                            <textarea name="rule" cols="30"><?php echo ($info["rule"]); ?></textarea> （不写则只记录日志）
                        </td>
                    </tr>
                    <tr>
                        <th>日志规则：</th>
                        <td>
                            <textarea name="log" cols="30"><?php echo ($info["log"]); ?></textarea> （日志备注时按此规则来生成）
                        </td>
                    </tr>
                    <tr>
                        <th>状态：</th>
                        <td>
                            <input type="radio" name="status" value="1" data-toggle="icheck" data-label="开启"
                            <?php if($info['status'] == 1): ?>checked<?php endif; ?>>
                            &nbsp;
                            <input type="radio" name="status" value="0" data-toggle="icheck" data-label="关闭"
                            <?php if($info['status'] == 0): ?>checked<?php endif; ?>>
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