<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="/index.php/Admin/AuthGroup/index.html?_=1472802213980" method="post">
        <button type="button" class="btn btn-success" data-icon="plus" data-toggle="dialog"
        data-options="{id:'auth-group-add', url:'<?php echo U('AuthGroup/add');?>', title:'新增角色', mask:true}">新增角色</button>&nbsp;
        <label>角色名：</label><input type="text" value="<?php echo ($title); ?>" name="title" class="form-control" size="15">&nbsp;   
        <button type="submit" class="btn-default" data-icon="search">查询</button>&nbsp;
        <button type="button" class="btn btn-orange pull-right" data-icon="refresh" onclick="$(this).navtab('refresh');" >刷新</button>
    </form>
</div>

<div class="bjui-pageContent tableContent">
    <table class="table table-bordered"  data-nowrap="true">
        <thead>
            <tr>
                <th width="40">ID</th>
                <th>用户组标题</th>
                <th>描述</th>
                <th>排序</th>
                <th width="80" align="center">状态</th>
                <th width="150" align="center">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($groupList)): foreach($groupList as $key=>$v): ?><tr data-id="<?php echo ($v["id"]); ?>">
                <td><?php echo ($v["id"]); ?></td>
                <td><?php echo ($v["title"]); ?></td>
                <td><?php echo ($v["remark"]); ?></td>
                <td><?php echo ($v["sort"]); ?></td>
                <td align="center"><?php echo (statusBtn($v['id'],$v["status"])); ?></td>
                <td align="center">
                    <button type="button" class="btn btn-blue" data-toggle="dialog" data-icon="key" data-options="{id:'sc-authRoles<?php echo ($v["id"]); ?>', url:'<?php echo U('AuthGroup/auth');?>?id=<?php echo ($v["id"]); ?>', title:'<?php echo ($v["title"]); ?>授权', mask:true}" title="授权"></button>
                    <button type="button" class="btn btn-green" data-toggle="dialog" data-icon="pencil" data-options="{id:'sc-editRoles<?php echo ($v["id"]); ?>', url:'<?php echo U('AuthGroup/edit');?>?id=<?php echo ($v["id"]); ?>', title:'编辑菜单', mask:true}" title="编辑"></button>
                    <a href="<?php echo U('AuthGroup/del');?>?id=<?php echo ($v["id"]); ?>" data-icon="trash" class="btn btn-red" data-toggle="doajax" data-confirm-msg="确定要删除该行信息吗？" title="删除"></a>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
</div>