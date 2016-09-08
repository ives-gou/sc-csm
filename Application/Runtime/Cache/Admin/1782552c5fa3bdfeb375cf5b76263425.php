<?php if (!defined('THINK_PATH')) exit();?><script>
//单击事件
function authRule_NodeClick(e, treeId, treeNode) {
    $('#sc-menuText').val(treeNode.name);
    $('input[name="pid"]').val(treeNode.id);
}
</script>
<div class="bjui-pageContent">
        <form action="/index.php/Admin/AuthRule/add.html?_=1473314118400" data-toggle="ajaxform" data-reload-navtab="true">
        <table class="table">
            <tbody>
                <tr>
                    <th>上级菜单：</th>
                    <td>
                        <input type="text" id="sc-menuText" data-toggle="selectztree" size="18" data-tree="#authRuleTree" placeholder="不填写为顶级菜单" readonly>
                        <input type="hidden" name="pid" value="0">
                        <ul id="authRuleTree" class="ztree hide" data-toggle="ztree" data-on-click="authRule_NodeClick">
                            <?php if(is_array($pmenu)): foreach($pmenu as $key=>$v): ?><li data-id="<?php echo ($v["id"]); ?>" data-pid="<?php echo ($v["pid"]); ?>"><?php echo ($v["title"]); ?></li><?php endforeach; endif; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>菜单名称：</th>
                    <td>
                        <input type="text" name="title"> *
                    </td>
                </tr>
                <tr>
                    <th>URL地址：</th>
                    <td>
                        <input type="text" name="name">
                    </td>
                </tr>
                <tr>
                    <th>图标：</th>
                    <td>
                        <input type="text" name="icon" value="angle-right" placeholder="Font Awesome图标"> 
                        不带前缀 fa-, 如 fa-user => user
                    </td>
                </tr>
                <tr>
                    <th>类型：</th>
                    <td>
                        <select name="menutype" data-toggle="selectpicker" data-width="100">
                            <option value="1">分组</option>
                            <option value="2">菜单</option>
                            <option value="3">节点</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" name="sort" value="99" data-toggle="spinner" size="5">
                    </td>
                </tr>
                <tr>
                    <th>状态：</th>
                    <td>
                        <input type="radio" name="status" value="1" data-toggle="icheck" data-label="启用" checked>&nbsp;
                        <input type="radio" name="status" value="0" data-toggle="icheck" data-label="禁用">
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