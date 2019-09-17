<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $advert->id }}">
        <div class="layui-form-item">
            <label class="layui-form-label">广告位置<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <select name="position_id" lay-filter="advert_positions" lay-verify="required">
                    <option value="">请选择广告位置</option>
                    @foreach($advert_positions as $advert_position)
                        <option value="{{ $advert_position->id }}" title="{{ $advert_position->width }}*{{ $advert_position->height }}" {{ $advert_position->id == $advert->position_id ? 'selected' : '' }}>{{ $advert_position->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">广告名称<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="{{ $advert->name }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">广告图片<font color="red">*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list {{ $advert->image_path ? '' : 'hidden' }}">
                        <input type="hidden" name="image_path" value="{{ $advert->image_path }}" id="advert_value">
                        <img class="layui-upload-img" src="{{ App\Services\Storage\Oss\UrlService::getUrl($advert->image_path, ['width' => 100]) }}" id="advert_preview" style="width: 100px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="advert_upload">上传图片</button>
                    <span class="upload_tips">图片支持格式:jpg,jpeg,gif,png;建议上传图片大小:<font>{{ $advert_position_size }}</font>px</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">广告链接:</label>
            <div class="layui-input-block">
                <input type="text" name="url" value="{{ $advert->url }}" autocomplete="off" class="layui-input width-per-50">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">开始时间<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="start_date" value="{{ $advert->start_date }}" id="start_date" lay-verify="required" autocomplete="off" placeholder="yyyy-MM-dd" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">结束时间<font color="red">*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="end_date" value="{{ $advert->end_date }}" id="end_date" lay-verify="required" autocomplete="off" placeholder="yyyy-MM-dd" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序号:</label>
            <div class="layui-input-inline">
                <input type="number" name="sort" value="{{ $advert->sort }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="advert_form">更新</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form', 'laydate'], function () {
        var form = layui.form, laydate = layui.laydate;
        form.render();

        laydate.render({
            elem: '#start_date',
            format: 'yyyy-MM-dd'
        })

        laydate.render({
            elem: '#end_date',
            format: 'yyyy-MM-dd'
        })

        form.on('select(advert_positions)', function (data) {
            var size = data.elem[data.elem.selectedIndex].title;
            $('.upload_tips').find('font').html(size);
            if (size) {
                uploadFile('advert', 'images', 'jpg|png|gif|jpeg');
            }
        });

        form.on('submit(advert_form)', function (data) {
            Save('{{ $advert->id }}', data.field);
        });
    })

    $(document).ready(function () {
        $('#advert_upload').click(function () {
            if ($('.upload_tips').find('font').html() == '') {
                return Common.msg('请选择广告位置.', {icon: 2});
            }
        });
    })
</script>
