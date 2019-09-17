<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists(1)">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <div class="layui-form-item">
            <label class="layui-form-label">标签名称<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标签图标<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list hidden">
                        <input type="hidden" name="image_path" id="tag_icon_value">
                        <img class="layui-upload-img" src="" id="tag_icon_preview" style="width: 64px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="tag_icon_upload">上传图片</button>
                    <span class="upload_tips">图片支持格式:png;建议上传图片大小:<font>64*64</font>px</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序号:</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-input-inline">
                <span class="sort_tips">序号越大越在最前面显示</span>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="tag_form">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use('form', function () {
        var form = layui.form;
        form.render();

        form.on('submit(tag_form)', function (data) {
            Save(0, data.field);
        });
    })

    uploadFile('tag_icon', 'images', 'png');
</script>
