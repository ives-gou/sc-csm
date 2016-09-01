<?php if (!defined('THINK_PATH')) exit();?><script>
//单击事件
function authRule_NodeClick(e, treeId, treeNode) {
    $('#sc-menuText').val(treeNode.name);
    $('input[name="pid"]').val(treeNode.id);
}
</script>
<div class="bjui-pageContent">
        <form action="<?php echo U('AuthRule/add');?>" data-toggle="ajaxform" data-reload-navtab="true">
        <table class="table">
            <tbody>
                <tr>
                    <th>上级菜单：</th>
                    <td>
                        <input type="text" id="sc-menuText" value="<?php echo ($info["ptitle"]); ?>" data-toggle="selectztree" size="18" data-tree="#authRuleTree" placeholder="不填写为顶级菜单" readonly>
                        <input type="hidden" name="pid" value="<?php echo ($info["pid"]); ?>">
                        <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
                        <ul id="authRuleTree" class="ztree hide" data-toggle="ztree" data-on-click="authRule_NodeClick">
                            <li data-id="0">顶级菜单</li>
                            <?php if(is_array($pmenu)): foreach($pmenu as $key=>$v): ?><li data-id="<?php echo ($v["id"]); ?>" data-pid="<?php echo ($v["pid"]); ?>"><?php echo ($v["title"]); ?></li><?php endforeach; endif; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>菜单名称：</th>
                    <td>
                        <input type="text" name="title" value="<?php echo ($info["title"]); ?>"> *
                    </td>
                </tr>
                <tr>
                    <th>URL地址：</th>
                    <td>
                        <input type="text" name="name" value="<?php echo ($info["name"]); ?>">
                    </td>
                </tr>
                <tr>
                    <th>图标：</th>
                    <td>
                        <input type="text" name="icon" value="<?php echo ($info["icon"]); ?>" placeholder="Font Awesome图标"> 
                        不带前缀 fa-, 如 fa-user => user
                    </td>
                </tr>
                <tr>
                    <th>类型：</th>
                    <td>
                        <select name="menutype" data-toggle="selectpicker" data-width="100">
                            <option value="1" <?php if(($info["menutype"]) == "1"): ?>selected<?php endif; ?>>分组</option>
                            <option value="2" <?php if(($info["menutype"]) == "2"): ?>selected<?php endif; ?>>菜单</option>
                            <option value="3" <?php if(($info["menutype"]) == "3"): ?>selected<?php endif; ?>>节点</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" name="sort" value="<?php echo ($info["sort"]); ?>" data-toggle="spinner" size="5">
                    </td>
                </tr>
                <tr>
                    <th>状态：</th>
                    <td>
                        <input type="radio" name="status" value="1" data-toggle="icheck" data-label="启用" 
                        <?php if(($info["status"]) == "1"): ?>checked<?php endif; ?>>&nbsp;
                        <input type="radio" name="status" value="0" data-toggle="icheck" data-label="禁用"
                        <?php if(($info["status"]) == "0"): ?>checked<?php endif; ?>>
                    </td>
                </tr>
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