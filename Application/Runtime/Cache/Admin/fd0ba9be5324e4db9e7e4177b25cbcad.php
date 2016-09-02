<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <form action="<?php echo U('AuthGroup/add');?>" data-toggle="ajaxform" data-reload-navtab="true">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td align="center"><label>标题：</label></td>
                    <td><input type="text" name="title" value="<?php echo ($info["title"]); ?>"> *</td>
                </tr>
                <tr>
                    <td align="center"><label>描述：</label></td>
                    <td><textarea name="remark" cols="30" rows="2"><?php echo ($info["remark"]); ?></textarea></td>
                </tr>
                <tr>
                    <td align="center"><label>排序：</label></td>
                    <td><input type="text" name="sort" value="<?php echo ($info["sort"]); ?>" data-toggle="spinner" size="5"></td>
                </tr>
                <tr>
                    <td align="center"><label>状态：</label></td>
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
        <li><button type="submit" class="btn-green" data-icon="save">保存</button></li>
    </ul>
</div>