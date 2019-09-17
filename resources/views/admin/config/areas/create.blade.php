<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="pid" value="{{ $pid }}">
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="layui-form-item">
            <label class="layui-form-label">地区名称[{{ \App\Models\Area::AREA_GRADE_NAME[$type] }}]<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input width-per-40">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">名称首字母<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="first_letter" lay-verify="required" autocomplete="off" class="layui-input width-per-40">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否显示:</label>
            <div class="layui-input-block">
                <input type="radio" name="isShow" value="1" title="显示" checked>
                <input type="radio" name="isShow" value="0" title="隐藏">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序号:</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="area_info">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use('form', function () {
        var form = layui.form;
        form.render();

        form.on('submit(area_info)', function (data) {
            Save(0, data.field);
        });
    })
</script>