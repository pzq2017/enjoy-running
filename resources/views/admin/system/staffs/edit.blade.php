<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <input type="hidden" name="id" value="{{ $staff->id }}">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">登录账号<font color='red'>*</font>:</label>
                <div class="layui-input-inline">
                    <input type="text" name="loginName" lay-verify="required" autocomplete="off" class="layui-input" value="{{ $staff->loginName }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">登录密码<font color='red'>*</font>:</label>
                <div class="layui-input-inline">
                    <input type="password" name="password" lay-verify="password" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">真实姓名:</label>
                <div class="layui-input-inline">
                    <input type="text" name="staffName" autocomplete="off" class="layui-input" value="{{ $staff->staffName }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">联系电话:</label>
                <div class="layui-input-inline">
                    <input type="text" name="staffPhone" lay-verify="input_phone" autocomplete="off" class="layui-input" value="{{ $staff->staffPhone }}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">联系邮箱:</label>
                <div class="layui-input-inline">
                    <input type="text" name="staffEmail" lay-verify="input_email" autocomplete="off" class="layui-input" value="{{ $staff->staffEmail }}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像照片:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list">
                        <input type="hidden" name="staffPhoto" value="{{ $staff->staffPhoto }}" id="avatar_value">
                        @if($staff->staffPhoto)
                            <img class="layui-upload-img" src="{{ App\Services\Storage\Oss\UrlService::getUrl($staff->staffPhoto, ['width' => 80]) }}" id="avatar_preview" style="width: 80px;">
                        @else
                            <img class="layui-upload-img" src="/imgs/default_headpic.png" id="avatar_preview" style="width: 80px;">
                        @endif
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="avatar_upload">上传图片</button>
                </div>
            </div>
        </div>
        @if($staff->staffRoleId != \App\Models\Staffs::SUPER_USER)
        <div class="layui-form-item">
            <label class="layui-form-label">所属角色:</label>
            <div class="layui-input-inline">
                <select name="staffRoleId" lay-verify="required">
                    <option value="">请选择角色</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $staff->staffRoleId == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        <div class="layui-form-item">
            <label class="layui-form-label">账号状态:</label>
            <div class="layui-input-block">
                <input type="hidden" name="status" value="{{ $staff->status }}">
                <input type="checkbox" lay-skin="switch" lay-filter="switchStatus" lay-text="ON|OFF" {{ $staff->status == \App\Models\Staffs::STATUS_ACTIVE ? 'checked' : '' }}>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="staff_info">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['form'], function () {
        var form = layui.form;
        form.render();

        form.verify({
            password: function (value) {
                if (value && (value.length < 6 || value.length > 12)) {
                    return '密码必须6到12位';
                }
            },
            input_phone: function (value) {
                var phoneVerify = form.config.verify.phone;
                if (value && !phoneVerify[0].test(value)) {
                    return phoneVerify[1];
                }
            },
            input_email: function (value) {
                var emailVerify = form.config.verify.email;
                if (value && !emailVerify[0].test(value)) {
                    return emailVerify[1];
                }
            }
        });

        form.on('switch(switchStatus)', function (obj) {
            $(this).parent().find('input[name="status"]').val(this.checked ? 1 : 0);
        });

        form.on('submit(staff_info)', function (data) {
            Save('{{ $staff->id }}', data.field);
        });
    })

    uploadFile('avatar', 'images', 'jpg|png|gif|jpeg', '80*80', 1);
</script>
