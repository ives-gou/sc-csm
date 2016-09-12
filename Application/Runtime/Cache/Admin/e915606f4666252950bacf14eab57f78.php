<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent"> 
    <!-- Tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <?php if(is_array(C("CONFIG_GROUPS"))): foreach(C("CONFIG_GROUPS") as $key=>$v): ?><li <?php if($group == $key): ?>class="active"<?php endif; ?>>
                <a href="<?php echo U('?group='.$key);?>" role="tab" data-toggle="navtab" data-title="常用配置"><?php echo ($v); ?></a>
            </li><?php endforeach; endif; ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade active in">
            <form action="<?php echo U('save');?>" method="post" data-toggle="ajaxform" data-reload-navtab="true">
            <table class="table table-hover table-bordered">
                <tbody>
                    <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
                            <th width="200">&nbsp;<?php echo ($v["title"]); ?>：</th>
                            <td>
                                <?php switch($v["type"]): case "1": ?><input type="text" name="<?php echo ($v["name"]); ?>" value="<?php echo ($v["value"]); ?>" data-toggle="spinner"><?php break;?>
                                <?php case "2": ?><input type="text" name="<?php echo ($v["name"]); ?>" value="<?php echo ($v["value"]); ?>" size="30" ><?php break;?>
                                <?php case "3": case "4": ?><textarea name="<?php echo ($v["name"]); ?>" cols="40"><?php echo ($v["value"]); ?></textarea><?php break;?>
                                <?php case "5": ?><select name="<?php echo ($v["name"]); ?>" data-toggle="selectpicker">
                                        <?php $configAttr = parse_config_attr($v['extra']); echo $v['extra']; ?>
                                        <?php if(is_array($configAttr)): foreach($configAttr as $ko=>$vo): ?><option value="<?php echo ($ko); ?>" <?php if(($v["value"]) == $ko): ?>selected<?php endif; ?>><?php echo ($vo); ?>&nbsp;&nbsp;</option><?php endforeach; endif; ?>
                                    </select><?php break; endswitch;?>
                                &nbsp;<?php echo ($v["remark"]); ?>
                            </td>
                        </tr><?php endforeach; endif; ?>
                </tbody>
            </table>
            </form>
        </div>
    </div>         
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
        <li><button type="submit" class="btn-default" data-icon="save">保存</button></li>
    </ul>
</div>