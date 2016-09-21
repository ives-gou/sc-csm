<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
    <table class="table">
        <thead>
            <tr>
                <th>名</th>
                <th>类型</th>
                <th>为空</th>
                <th>索引</th>
                <th>默认值</th>
                <th>属性</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($columns)): foreach($columns as $key=>$v): ?><tr>
                <td><?php echo ($v["field"]); ?></td>
                <td><?php echo ($v["type"]); ?></td>
                <td><?php echo ($v["null"]); ?></td>
                <td><?php echo ($v["key"]); ?></td>
                <td><?php echo ($v["default"]); ?></td>
                <td><?php echo ($v["extra"]); ?></td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
</div>