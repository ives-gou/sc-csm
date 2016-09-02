<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageHeader">
    <form id="pagerForm" data-toggle="ajaxsearch" action="/index.php/Admin/Config/index.html?_=1472807044408" method="post">
        <button type="button" class="btn btn-success" data-icon="plus" data-toggle="dialog"
        data-options="{id:'auth-group-add', url:'<?php echo U('AuthGroup/add');?>', title:'新增配置', mask:true}">新增配置</button>&nbsp;
        <label>角色名：</label><input type="text" value="<?php echo ($title); ?>" name="title" class="form-control" size="15">&nbsp;   
        <button type="submit" class="btn-default" data-icon="search">查询</button>&nbsp;
        <button type="button" class="btn btn-orange pull-right" data-icon="refresh" onclick="$(this).navtab('refresh');" >刷新</button>
    </form>
</div>
<div class="bjui-pageContent">
    <form action="ajaxDone1.html" id="j_form_form" class="pageForm" data-toggle="validate">
        <!-- Tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#home" role="tab" data-toggle="tab">Home</a></li>
            <li><a href="form-input.html" role="tab" data-toggle="ajaxtab" data-target="#profile" data-reload="false">ajax加载</a></li>
            <li><a href="#messages" role="tab" data-toggle="tab">固定表头表格</a></li>
            <li><a href="#settings" role="tab" data-toggle="tab">Settings</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade active in" id="home"><p>选项卡的a标签上添加[data-toggle="ajaxtab"]属性可以实现ajax加载内容。</p><p>[data-reload]属性可以定义点击该选项卡时是否每次都需要重新加载。</p></div>
            <div class="tab-pane fade" id="profile"><!-- Ajax加载 --></div>
            <div class="tab-pane fade" id="messages"> </div>
            <div class="tab-pane fade" id="settings">No4. Settings</div>
        </div>       
    </form>
</div>