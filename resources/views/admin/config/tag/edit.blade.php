<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $tag->id }}">
        <div class="layui-form-item">
            <label class="layui-form-label">标签名称<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="{{ $tag->name }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标签图标<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list {{ $tag->icon_path ? '' : 'hidden' }}">
                        <input type="hidden" name="image_path" value="{{ $tag->icon_path }}" id="tag_icon_value">
                        <img class="layui-upload-img" src="{{ App\Services\Storage\Oss\UrlService::getUrl($tag->icon_path, ['width' => '64']) }}" id="tag_icon_preview" style="width: 64px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="advert_upload">上传图片</button>
                    <span class="upload_tips">图片支持格式:png;建议上传图片大小:<font>64*64</font>px</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序号:</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" value="{{ $tag->sort }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="tag_form">更新</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use('form', function () {
        var form = layui.form;
        form.render();

        form.on('submit(tag_form)', function (data) {
            Save('{{ $tag->id }}', data.field);
        });
    })

    uploadFile('tag_icon', 'images', 'png');
</script>
