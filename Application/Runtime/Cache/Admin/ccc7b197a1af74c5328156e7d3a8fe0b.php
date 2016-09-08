<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <button type="submit" class="submit btn btn-success" form="dbtable">备份数据表</button>&nbsp;
    <button type="submit" class="submit btn btn-info" form="dbtable">优化数据表</button>&nbsp;
    <button type="submit" class="submit btn btn-warning" form="dbtable">修复数据表</button>&nbsp;

    <button type="button" class="btn btn-orange pull-right" data-icon="refresh" onclick="$(this).navtab('refresh');" >刷新</button>
</div>

<div class="bjui-pageContent tableContent">
    <form id="dbtable" action="<?php echo U('export');?>" method="post" data-toggle="ajaxform">
    <table class="table table-hover table-striped"  data-nowrap="true">
        <thead>
            <tr>
                <th width="26"><input type="checkbox" class="checkboxCtrl" data-group="tables[]" data-toggle="icheck" checked></th>
                <th width="40">No.</th>
                <th>表名</th>
                <th>说明</th>
                <th>数据条数</th>
                <th>数据大小</th>
                <th>索引大小</th>
                <th>创建时间</th>
                <th width="200">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr data-id="<?php echo ($v["id"]); ?>">
                <td><input type="checkbox" name="tables[]" data-toggle="icheck" value="<?php echo ($v["name"]); ?>" checked></td>
                <td><?php echo ($key+1); ?></td>
                <td><?php echo ($v["name"]); ?></td>
                <td><?php echo ($v["comment"]); ?></td>
                <td><?php echo ($v["rows"]); ?></td>
                <td><?php echo (format_bytes($v["data_length"])); ?></td>
                <td><?php echo (format_bytes($v["index_length"])); ?></td>
                <td><?php echo ($v["create_time"]); ?></td>
                <td>
                    <button type="button" class="btn btn-info" data-toggle="dialog" data-options="{id:'Database-frame<?php echo ($key); ?>', url:'<?php echo U('frame?name='.$v['name']);?>', title:'<?php echo ($v["name"]); ?>', mask:true}">数据表结构</button>
                    <button type="button" class="btn btn-primary" data-toggle="dialog" data-options="{id:'Database-sql<?php echo ($key); ?>', url:'<?php echo U('createSql?name='.$v['name']);?>', title:'<?php echo ($v["name"]); ?>', mask:true}">sql 语句</button>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
        <input type="hidden" id="act" name="act">
    </table>
    </form>
</div>
<script>
    $('.submit').click(function() {
        $('#act').val($(this).text());
    });
</script>