<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="/index.php/Admin/Manager/action.html?_=1473650617215" method="post">
        <button type="button" class="btn btn-success" data-icon="plus" data-toggle="dialog"
        data-options="{id:'Manager-add', url:'<?php echo U('Manager/add');?>', title:'添加管理', mask:true}">添加管理</button>&nbsp;
        &nbsp;&nbsp;
        <label>用户名/昵称：</label><input type="text" value="<?php echo ($name); ?>" name="name" class="form-control" size="15">&nbsp;
        <button type="submit" class="btn-default" data-icon="search">查询</button>&nbsp;

        <button type="button" class="btn btn-orange pull-right" data-icon="refresh" onclick="$(this).navtab('refresh');" >刷新</button>
    </form>
</div>

<div class="bjui-pageContent tableContent">
    <table class="table table-bordered table-hover"  data-nowrap="true">
        <thead>
            <tr>
                <th width="40">ID</th>
                <th>标识</th>
                <th>名称</th>
                <th>类型</th>
                <th>规则</th>
                <th width="80" align="center">状态</th>
                <th width="150" align="center">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr data-id="<?php echo ($v["id"]); ?>">
                <td><?php echo ($v["id"]); ?></td>
                <td><?php echo ($v["name"]); ?></td>
                <td><?php echo ($v["title"]); ?></td>
                <td><?php echo ($v["type"]); ?></td>
                <td><?php echo ($v["remark"]); ?></td>
                <td align="center"><?php echo (statusBtn($v['id'],$v["status"])); ?></td>
                <td align="center">
                    <button type="button" class="btn btn-green" data-toggle="dialog" data-icon="pencil" data-options="{id:'Manager-edit<?php echo ($v["id"]); ?>', url:'<?php echo U('Manager/edit');?>?id=<?php echo ($v["id"]); ?>', title:'编辑管理员', mask:true}" title="编辑"></button>
                    <a href="<?php echo U('Manager/del');?>?id=<?php echo ($v["id"]); ?>" data-icon="trash" class="btn btn-red" data-toggle="doajax" data-confirm-msg="确定要删除吗？" title="删除"></a>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
</div>