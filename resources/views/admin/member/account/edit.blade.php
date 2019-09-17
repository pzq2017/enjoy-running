<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists(1)">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $member->id }}">
        <div class="layui-form-item">
            <label class="layui-form-label">昵称<font color='red'>*</font>:</label>
            <div class="layui-input-inline">
                <input type="text" name="nickname" value="{{ $member->nickname }}" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">性别:</label>
            <div class="layui-input-inline">
                <input type="radio" name="sex" value="1" title="男" {{ $member->sex == '男' ? 'checked' : '' }}>
                <input type="radio" name="sex" value="2" title="女" {{ $member->sex == '女' ? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">生日:</label>
            <div class="layui-input-inline">
                <input type="text" name="birthday" value="{{ $member->birthday }}" id="birthday" autocomplete="off" placeholder="yyyy-MM-dd" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list {{ $member->avatar ? '' : 'hidden' }}">
                        <input type="hidden" name="image_path" value="{{ $member->avatar }}" id="avatar_value">
                        <img class="layui-upload-img" src="{{ \App\Services\Storage\Oss\UrlService::getUrl($member->avatar, ['width' => 100]) }}" id="avatar_preview" style="width: 100px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="avatar_upload">上传图片</button>
                    <span class="upload_tips">图片支持格式:jpg,jpeg,gif,png;建议上传图片大小:<font>200*200</font>px</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">账号状态:</label>
            <div class="layui-input-block">
                <input type="hidden" name="status" value="{{ $member->status }}">
                <input type="checkbox" lay-skin="switch" lay-filter="switchStatus" lay-text="ON|OFF" {{ $member->status == \App\Models\Member::STATUS_ACTIVATED ? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="account_info">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form', 'laydate'], function () {
        var form = layui.form, laydate = layui.laydate;
        form.render();

        laydate.render({
            elem: '#birthday',
            format: 'yyyy-MM-dd'
        })

        form.verify({
            password: function (value) {
                if (value.length < 6 || value.length > 12) {
                    return '密码必须6到12位';
                }
            },
        });

        form.on('switch(switchStatus)', function (obj) {
            $(this).parent().find('input[name="status"]').val(this.checked ? 1 : 0);
        });

        form.on('submit(account_info)', function (data) {
            Save('{{ $member->id }}', data.field);
        });
    })

    uploadFile('avatar', 'images', 'jpg|png|gif|jpeg', '200*200', 1);
</script>
