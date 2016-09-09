<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="/index.php/Admin/Config/index.html?group=5&amp;_=1473386303458" method="post">
        <button type="button" class="btn btn-success" data-icon="plus" data-toggle="dialog"
        data-options="{id:'config-add', url:'<?php echo U('Config/add');?>', title:'新增配置', mask:true, width:650, height:400}">新增配置</button>
        &nbsp;
        <label>配置名称：</label><input type="text" value="<?php echo ($name); ?>" name="name" class="form-control" size="15">&nbsp;   
        <button type="submit" class="btn-default" data-icon="search">查询</button>&nbsp;
        <button type="button" class="btn btn-orange pull-right" data-icon="refresh" onclick="$(this).navtab('refresh');" >刷新</button>
    </form>
</div>
<div class="bjui-pageContent">
    
    <!-- Tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li <?php if($group == 0): ?>class="active"<?php endif; ?>>
            <a href="<?php echo U('Config/index');?>" role="tab" data-toggle="navtab" >全部配置</a>
        </li>
        <?php if(is_array(C("CONFIG_GROUPS"))): foreach(C("CONFIG_GROUPS") as $key=>$v): ?><li <?php if($group == $key): ?>class="active"<?php endif; ?>>
                <a href="<?php echo U('Config/index');?>?group=<?php echo ($key); ?>" role="tab" data-toggle="navtab" data-title="全部配置"><?php echo ($v); ?></a>
            </li><?php endforeach; endif; ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade active in" id="home">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名称</th>
                        <th>标题</th>
                        <th>分组</th>
                        <th>类型</th>
                        <th>排序</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
                            <td><?php echo ($v["id"]); ?></td>
                            <td><?php echo ($v["name"]); ?></td>
                            <td><?php echo ($v["title"]); ?></td>
                            <td><?php echo (get_config_group($v["group"])); ?></td>
                            <td><?php echo (get_config_type($v["type"])); ?></td>
                            <td><?php echo ($v["sort"]); ?></td>
                            <td><?php echo (statusBtn($v['id'],$v["status"])); ?></td>
                            <td>
                                <button type="button" class="btn btn-green" data-toggle="dialog" data-icon="pencil" data-options="{id:'config-edit<?php echo ($v["id"]); ?>', url:'<?php echo U('Config/edit');?>?id=<?php echo ($v["id"]); ?>', title:'编辑菜单', mask:true, width:650, height:400}" title="编辑" ></button>
                                <button type="button" class="btn btn-red" data-url="<?php echo U('Config/del');?>?id=<?php echo ($v["id"]); ?>" data-icon="trash" data-toggle="doajax" data-confirm-msg="确定要删除吗？" title="删除"></button>
                            </td>
                        </tr><?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>         
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