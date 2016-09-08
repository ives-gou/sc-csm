<?php if (!defined('THINK_PATH')) exit();?><div class="bjui-pageContent">
        <form action="/index.php/Admin/Config/add.html?_=1473323264559" method="post" data-toggle="ajaxform" data-reload-navtab="true">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>&nbsp;配置标题：</th>
                        <td>
                            <input type="text" name="title"> （用于后台显示的配置标题）
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;配置标识：</th>
                        <td>
                            <input type="text" name="name"> （用于C函数调用，只能使用英文且不能重复）
                        </td>
                    </tr><tr>
                        <th>&nbsp;配置类型：</th>
                        <td>
                            <select name="type" data-toggle="selectpicker" data-width="80">
                                <?php if(is_array(C("CONFIG_TYPE_LIST"))): foreach(C("CONFIG_TYPE_LIST") as $key=>$v): ?><option value="<?php echo ($key); ?>"><?php echo ($v); ?></option><?php endforeach; endif; ?>
                            </select>
                        </td>
                    </tr><tr>
                        <th>&nbsp;配置分组：</th>
                        <td>
                            <select name="group" data-toggle="selectpicker" data-width="80">
                                    <option value="0">不分组</option>
                                <?php if(is_array(C("CONFIG_GROUPS"))): foreach(C("CONFIG_GROUPS") as $key=>$v): ?><option value="<?php echo ($key); ?>"><?php echo ($v); ?></option><?php endforeach; endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;配置值：</th>
                        <td>
                            <textarea name="value" cols="30" ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;配置项：</th>
                        <td>
                            <textarea name="extra" cols="30" ></textarea> （如果是枚举型 需要配置该项）
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;说明：</th>
                        <td>
                            <textarea name="remark" cols="30" ></textarea> （配置详细说明）
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;排序：</th>
                        <td>
                            <input type="text" name="sort" value="99" data-toggle="spinner" size="5">
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;状态：</th>
                        <td colspan="2">
                            <input type="radio" name="status" value="1" data-toggle="icheck" data-label="开启" checked>
                            &nbsp;
                            <input type="radio" name="status" value="0" data-toggle="icheck" data-label="关闭">
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </form>
</div>

<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
        <li><button type="submit" class="btn-default" data-icon="save">保存</button></li>
    </ul>
</div>