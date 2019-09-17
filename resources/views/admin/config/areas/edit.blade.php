<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $area->id }}">
        <div class="layui-form-item">
            <label class="layui-form-label">地区名称<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="{{ $area->name }}" lay-verify="required" autocomplete="off" class="layui-input width-per-40">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">名称首字母<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <input type="text" name="first_letter" value="{{ $area->first_letter }}" lay-verify="required" autocomplete="off" class="layui-input width-per-40">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否显示:</label>
            <div class="layui-input-block">
                <input type="radio" name="isShow" value="1" title="显示" {{ $area->isShow == 1 ? 'checked' : '' }}>
                <input type="radio" name="isShow" value="0" title="隐藏" {{ $area->isShow == 0 ? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序号:</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" value="{{ $area->sort }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="area_info">更新</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use('form', function () {
        var form = layui.form;
        form.render();

        form.on('submit(area_info)', function (data) {
            Save('{{ $area->id }}', data.field);
        });
    })
</script>