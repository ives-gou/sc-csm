<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="/index.php/Admin/Action/index.html?_=1473670351533" method="post">
        <button type="button" class="btn btn-success" data-icon="plus" data-toggle="dialog"
        data-options="{id:'Action-add', url:'<?php echo U('Action/add');?>', title:'新增行为', mask:true}">新增行为</button>&nbsp;
        &nbsp;&nbsp;
        <label>标识/名称：</label><input type="text" value="<?php echo ($name); ?>" name="name" class="form-control" size="15">&nbsp;
        <button type="submit" class="btn-default" data-icon="search">查询</button>&nbsp;

        <button type="button" class="btn btn-orange pull-right" data-icon="refresh" onclick="$(this).navtab('refresh');" >刷新</button>
    </form>
</div>

<div class="bjui-pageContent tableContent">
    <table class="table table-hover"  data-nowrap="true">
        <thead>
            <tr>
                <th width="50">ID</th>
                <th>标识</th>
                <th>名称</th>
                <th>类型</th>
                <th>规则</th>
                <th>状态</th>
                <th width="150">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr data-id="<?php echo ($v["id"]); ?>">
                <td><?php echo ($v["id"]); ?></td>
                <td><?php echo ($v["name"]); ?></td>
                <td><?php echo ($v["title"]); ?></td>
                <td><?php if($v['type'] == 1): ?>系统<?php else: ?>用户<?php endif; ?></td>
                <td><?php echo ($v["remark"]); ?></td>
                <td><?php echo (statusBtn($v['id'],$v["status"])); ?></td>
                <td>
                    <button type="button" class="btn btn-green" data-toggle="dialog" data-icon="pencil" data-options="{id:'Action-edit<?php echo ($v["id"]); ?>', url:'<?php echo U('Action/edit');?>?id=<?php echo ($v["id"]); ?>', title:'编辑行为', mask:true}" title="编辑"></button>
                    <a href="<?php echo U('Action/del');?>?id=<?php echo ($v["id"]); ?>" data-icon="trash" class="btn btn-red" data-toggle="doajax" data-confirm-msg="确定要删除吗？" title="删除"></a>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
</div>