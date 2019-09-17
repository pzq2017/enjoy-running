<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists(1)">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">登录账号<font color='red'>*</font>:</label>
                <div class="layui-input-inline">
                    <input type="text" name="loginName" lay-verify="required" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">登录密码<font color='red'>*</font>:</label>
                <div class="layui-input-inline">
                    <input type="password" name="password" lay-verify="required|password" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">真实姓名:</label>
                <div class="layui-input-inline">
                    <input type="text" name="staffName" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">联系电话:</label>
                <div class="layui-input-inline">
                    <input type="text" name="staffPhone" lay-verify="input_phone" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">联系邮箱:</label>
                <div class="layui-input-inline">
                    <input type="text" name="staffEmail" lay-verify="input_email" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像照片:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list">
                        <input type="hidden" name="staffPhoto" id="avatar_value">
                        <img class="layui-upload-img" src="/imgs/default_headpic.png" id="avatar_preview" style="width: 80px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="avatar_upload">上传图片</button>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">所属角色:</label>
            <div class="layui-input-inline">
                <select name="staffRoleId" lay-verify="required">
                    <option value="">请选择角色</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">账号状态:</label>
            <div class="layui-input-block">
                <input type="hidden" name="status">
                <input type="checkbox" lay-skin="switch" lay-filter="switchStatus" lay-text="ON|OFF">
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
    layui.use('form', function () {
        var form = layui.form;
        form.render();

        form.verify({
            password: function (value) {
                if (value.length < 6 || value.length > 12) {
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
            Save(0, data.field);
        });
    })

    uploadFile('avatar', 'images', 'jpg|png|gif|jpeg', '80*80', 1);
</script>