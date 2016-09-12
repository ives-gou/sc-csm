<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="/index.php/Admin/Action/actionlog.html?_=1473670330867" method="post">
        <a href="<?php echo U('dellog',array('id' => 0));?>" class="btn btn-warning" data-toggle="doajax" data-confirm-msg="确定要清空吗？">清空日志</a>
        &nbsp;&nbsp;
        <button type="submit" form="actionform" class="btn-primary">删除选中</button>&nbsp;

        <button type="button" class="btn btn-orange pull-right" data-icon="refresh" onclick="$(this).navtab('refresh');" >刷新</button>
    </form>
</div>

<div class="bjui-pageContent tableContent">
    <form id="actionform" action="<?php echo U('dellog');?>" method="post" data-toggle="ajaxform" data-reload-navtab="true">
    <table class="table table-hover"  data-nowrap="true">
        <thead>
            <tr>
                <th width="16"><input type="checkbox" class="checkboxCtrl" data-toggle="icheck" data-group="ids[]"></th>
                <th width="50">ID</th>
                <th>行为名称</th>
                <th>执行者</th>
                <th>IP</th>
                <th>执行时间</th>
                <th width="150">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr data-id="<?php echo ($v["id"]); ?>">
                <td><input type="checkbox" name="ids[]" value="<?php echo ($v["id"]); ?>" data-toggle="icheck"></td>
                <td><?php echo ($v["id"]); ?></td>
                <td><?php echo ($v["title"]); ?></td>
                <td><?php echo ($v["nickname"]); ?></td>
                <td><?php echo (long2ip($v["action_ip"])); ?></td>
                <td><?php echo (date('Y-m-d H:i',$v["create_time"])); ?></td>
                <td>
                    <a href="<?php echo U('dellog',array('id' => $v['id']));?>" class="btn btn-danger" data-toggle="doajax" data-confirm-msg="确定要删除吗？">删除日志</a>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    </form>
</div>
<div class="bjui-pageFooter">
    <div class="pages">
        <span>每页&nbsp;</span>
        <div class="selectPagesize">
            <select data-toggle="selectpicker" data-toggle-change="changepagesize">
                <option value="30">30</option>
                <option value="60">60</option>
                <option value="120">120</option>
                <option value="150">150</option>
            </select>
        </div>
        <span>&nbsp;条，共 <?php echo ($count); ?> 条</span>
    </div>
    <div class="pagination-box" data-toggle="pagination" data-total="<?php echo ($count); ?>" data-page-size="<?php echo ($pageSize); ?>" data-page-current="1">
    </div>
</div>