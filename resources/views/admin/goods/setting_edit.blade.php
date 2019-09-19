@if ($type == 'size')
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $setting ? $setting->id : '' }}">
        <input type="hidden" name="goods_id" value="{{ $good->id }}">
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="layui-form-item">
            <label class="layui-form-label">名称<font color='red'>*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="{{ $setting ? $setting->name : '' }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="size_info">保存</button>
            </div>
        </div>
    </form>
@elseif($type == 'color')
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $setting ? $setting->id : '' }}">
        <input type="hidden" name="goods_id" value="{{ $good->id }}">
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="layui-form-item">
            <label class="layui-form-label">名称<font color='red'>*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="{{ $setting ? $setting->name : '' }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="color_info">保存</button>
            </div>
        </div>
    </form>
@elseif($type == 'album')
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $setting ? $setting->id : '' }}">
        <input type="hidden" name="goods_id" value="{{ $good->id }}">
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="layui-form-item">
            <label class="layui-form-label">颜色<font color='red'>*</font>:</label>
            <div class="layui-input-inline">
                <select name="color_id" lay-verify="required">
                    <option value="">请选择颜色</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片<font color='red'>*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list hidden">
                        <input type="hidden" name="image_path" value="" id="goods_album_value">
                        <img class="layui-upload-img" src="" id="goods_album_preview" style="width: 100px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="goods_album_upload">上传图片</button>
                    <span class="upload_tips">图片支持格式:jpg,jpeg,gif,png</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="album_info">保存</button>
            </div>
        </div>
    </form>
    <script>uploadFile('goods_album', 'images', 'jpg|png|gif|jpeg');</script>
@elseif($type == 'detail')
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $setting ? $setting->id : '' }}">
        <input type="hidden" name="goods_id" value="{{ $good->id }}">
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="layui-form-item">
            <label class="layui-form-label">名称<font color='red'>*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="name" value="{{ $setting ? $setting->name : '' }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="color_info">保存</button>
            </div>
        </div>
    </form>
@endif
