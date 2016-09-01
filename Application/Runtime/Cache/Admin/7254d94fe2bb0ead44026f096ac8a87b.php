<?php if (!defined('THINK_PATH')) exit();?><style>
    table.treetable span.indenter {
      display: inline-block;
      margin: 0;
      padding: 0;
      text-align: right;

      /* Disable text selection of nodes (for better D&D UX) */
      user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -o-user-select: none;
      -webkit-user-select: none;

      /* Force content-box box model for indenter (Bootstrap compatibility) */
      -webkit-box-sizing: content-box;
      -moz-box-sizing: content-box;
      box-sizing: content-box;

      width: 16px;
    }

    table.treetable span.indenter a {
      background-position: left center;
      background-repeat: no-repeat;
      display: inline-block;
      text-decoration: none;
      width: 16px;
    }
    
    table.treetable tr.expanded td span.indenter a{
        background: rgba(0, 0, 0, 0) url("/Public/Admin/img/allbgs.png") no-repeat scroll 0 -3px;
        width: 16px;
    }

    table.treetable tr.collapsed td span.indenter a{
        background: rgba(0, 0, 0, 0) url("/Public/Admin/img/allbgs.png") no-repeat scroll -16px -3px;
        width: 16px;
    }
</style>
<div class="bjui-pageHeader">
    <button type="button" class="btn btn-success" data-icon="plus" data-toggle="dialog"
    data-options="{id:'auth-rule-add', url:'<?php echo U('AuthRule/add');?>', title:'添加菜单', mask:true}">新增菜单</button>&nbsp;
    <button type="submit" class="btn btn-info" data-icon="sort-numeric-asc" form="sc-menu-index">更新排序</button>
    <button type="button" class="btn btn-orange pull-right" data-icon="refresh" onclick="$(this).navtab('refresh');" >刷新</button>
</div>
<div class="bjui-pageContent tableContent">
    <form action="<?php echo U('Menu/sortAll');?>" data-toggle="ajaxform" data-reload-navtab="true">
    <table id="auth-rule-treetable" class="table table-bordered">
        <thead>
            <tr>
                <th width="60" align="center">排序</th>
                <th width="60">ID</th>
                <th width="250">菜单名称</th>
                <th>URL地址</th>
                <th width="50" align="center">图标</th>
                <th width="80" align="center">类型</th>
                <th width="100" align="center">状态</th>
                <th width="150" align="center">管理操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($menuList)): foreach($menuList as $key=>$v): ?><tr data-tt-id="<?php echo ($v["id"]); ?>" data-tt-parent-id="<?php echo ($v["pid"]); ?>">
                <td><input type="text" name="sort[<?php echo ($v["id"]); ?>]" value="<?php echo ($v["sort"]); ?>" size="5" class="text-center"></td>
                <td><?php echo ($v["id"]); ?></td>
                <td><?php echo ($v["title"]); ?></td>
                <td><?php echo ($v["name"]); ?></td>
                <td align="center"><i class="fa fa-<?php echo ($v["icon"]); ?> fa-lg" aria-hidden="true"></i></td>
                <td align="center">
                    <?php if($v['menutype'] == 1): ?>分组
                    <?php elseif($v['menutype'] == 2): ?>菜单
                    <?php else: ?>节点<?php endif; ?>
                </td>
                <td align="center"><?php echo (statusBtn($v['id'], $v["status"])); ?></td>
                <td align="center">
                    <button type="button" class="btn btn-green" data-toggle="dialog" data-icon="pencil" data-options="{id:'sc-editMenu<?php echo ($v["id"]); ?>', url:'<?php echo U('AuthRule/edit');?>?id=<?php echo ($v["id"]); ?>', title:'编辑菜单', mask:true}" title="编辑" ></button>
                    <button type="button" class="btn btn-red" data-url="<?php echo U('AuthRule/del');?>?id=<?php echo ($v["id"]); ?>" data-icon="trash" data-toggle="doajax" data-confirm-msg="确定要删除吗？" title="删除"></button>
                </td>
            </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    </form>
</div>

<script>
    $("#auth-rule-treetable").treetable({ expandable:true, column:2});
</script>