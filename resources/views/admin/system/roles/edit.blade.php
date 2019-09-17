<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">角色名称<font color='red'>*</font>:</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input" value="{{ $role->name }}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色备注:</label>
            <div class="layui-input-block">
                <textarea name="desc" autocomplete="off" class="layui-input" style="width: 80%; height: 60px;">{{ $role->desc }}</textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限菜单<font color='red'>*</font>:</label>
            <div class="layui-input-block">
                <input type="hidden" id="menus_privileges" value="{{ $menuPrivileges }}">
                <ul id="menuTree" class="ztree ztree_panel"></ul>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="role_info">立即提交</button>
            </div>
        </div>
    </form>
</div>
<link href="/plugin/ztree/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" type="text/css" />
<script src="/plugin/ztree/jquery.ztree.all-3.5.js"></script>
<script>
    var setting = {
        check: {
            enable: true
        }
    };

    var zNodes = $('#menus_privileges').val();
    if (zNodes) {
        zNodes = eval('(' + zNodes + ')');
        $.fn.zTree.init($('#menuTree'), setting, zNodes);
        zTree = $.fn.zTree.getZTreeObj('menuTree');
    }

    layui.use('form', function () {
        var form = layui.form;
        form.render();

        form.on('submit(role_info)', function (data) {
            Save('{{ $role->id }}', data.field);
        });
    })
</script>