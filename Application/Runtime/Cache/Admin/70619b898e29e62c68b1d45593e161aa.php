<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent tableContent">
    <table class="table table-hover table-striped"  data-nowrap="true">
        <thead>
            <tr>
                <th width="40">No.</th>
                <th>备份文件名</th>
                <th>文件类型</th>
                <th>备份大小</th>
                <th>创建时间</th>
                <th width="200">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr data-id="<?php echo ($v["id"]); ?>">
                <td><?php echo ($key+1); ?></td>
                <td><?php echo ($v["name"]); ?></td>
                <td><?php echo ($v["type"]); ?></td>
                <td><?php echo (format_bytes($v["size"])); ?></td>
                <td><?php echo ($v["create"]); ?></td>
                <td>
                    <button type="button" class="btn btn-info" data-toggle="doajax" data-confirm-msg="确定要还原吗"
                    data-url="<?php echo U(import,array('time'=>$v['time']));?>">还原数据</button>
                    <button type="button" class="btn btn-danger" data-toggle="doajax" data-confirm-msg="确定要删除吗"
                    data-url="<?php echo U('delbak',array('time'=>$v['time']));?>">删除数据</button>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
</div>