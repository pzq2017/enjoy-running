<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists(1)">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $category->id }}">
        <div class="layui-form-item">
            <label class="layui-form-label">名称<font color='red'>*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="{{ $category->name }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态:</label>
            <div class="layui-input-block">
                <input type="hidden" name="status" value="{{ $category->status }}">
                <input type="checkbox" lay-skin="switch" lay-filter="switchStatus" lay-text="发布|不发布" {{ $category->status == 1 ? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="goods_category_info">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use('form', function () {
        var form = layui.form;
        form.render();

        form.on('switch(switchStatus)', function (obj) {
            $(this).parent().find('input[name="status"]').val(this.checked ? 1 : 0);
        });

        form.on('submit(goods_category_info)', function (data) {
            Save('{{ $category->id }}', data.field);
        });
    })
</script>
