<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent tableContent">
    <form id="authGroup-auth-form" action="/index.php/Admin/AuthGroup/auth.html?id=1&amp;_=1472801163412" method="post" data-toggle="ajaxform">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td width="140" align="center"><b>权限列表：</b></td>
                <td>
                    <ul id="authGroup-auth-ztree" class="ztree" data-toggle="ztree" data-check-enable="true" data-on-check="authClick">
                        <?php if(is_array($data)): foreach($data as $key=>$v): ?><li data-id="<?php echo ($v["id"]); ?>" data-pid="<?php echo ($v["pid"]); ?>" 
                            <?php if($v['pid'] == 0): ?>data-open="true"<?php endif; ?>
                            <?php if(in_array($v['id'], $rules)): ?>data-checked="true"<?php endif; ?>
                            ><?php echo ($v["title"]); ?></li><?php endforeach; endif; ?>
                    </ul>
                    <input type="hidden" name="rules" id="RulesValue" value="<?php echo ($rules_str); ?>">
                    <input type="hidden" name="id" value="<?php echo ($id); ?>">
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
<script type="text/javascript">

function authClick(e, treeId, treeNode) {
    var zTree = $.fn.zTree.getZTreeObj(treeId),
        nodes = zTree.getCheckedNodes(true)
    var ids = ''
    
    for (var i = 0; i < nodes.length; i++) {
        ids   += ','+ nodes[i].id
    }
    if (ids.length > 0) {
        ids = ids.substr(1)
    }
    $('#RulesValue').val(ids)
}
</script>