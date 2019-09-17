<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理中心</title>
    <link href="/plugin/layui/css/layui.css" rel="stylesheet" type="text/css" />
    <link href="/css/style.css" rel="stylesheet" type="text/css" />
    <script src="/js/jquery.min.js" type="text/javascript"></script>
    <script src='/plugin/layui/layui.js' type='text/javascript'></script>
    <script src="/js/common.js" type="text/javascript"></script>
    <script src="/js/admin/base.js" type="text/javascript"></script>
    <script>
        var baseParams = {
            csrf_token: '{{ csrf_token() }}',
            upload_url: '{{ route('admin.sigupload.upload') }}'
        };
    </script>
</head>
<body style="background-color: #ffffff;">
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名:</label>
            <div class="layui-input-inline">
                <input type="text" name="staffName" value="{{ $user->staffName }}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">联系电话:</label>
            <div class="layui-input-inline">
                <input type="text" name="staffPhone" value="{{ $user->staffPhone }}" lay-verify="input_phone" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">联系邮箱:</label>
            <div class="layui-input-inline">
                <input type="text" name="staffEmail" value="{{ $user->staffEmail }}" lay-verify="input_email" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像照片:</label>
            <div class="layui-input-inline">
                <div class="layui-upload">
                    <div class="layui-upload-list">
                        <input type="hidden" name="staffPhoto" value="{{ $user->staffPhoto }}" id="avatar_value">
                        @if($user->staffPhoto)
                            <img class="layui-upload-img" src="{{ App\Services\Storage\Oss\UrlService::getUrl($user->staffPhoto, ['width' => 80]) }}" id="avatar_preview" style="width: 80px;">
                        @else
                            <img class="layui-upload-img" src="/imgs/default_headpic.png" id="avatar_preview" style="width: 80px;">
                        @endif
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="avatar_upload">上传图片</button>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="my_info">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['element', 'form'], function () {
        var form = layui.form;

        form.verify({
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

        form.on('submit(my_info)', function (data) {
            loading = Common.msg('正在提交数据，请稍后...', {icon: 16, time: 60000});
            Common.ajaxRequest('{{ route('admin.change_my_info') }}', data.field, 'POST', function (data) {
                if (data.status == 'success') {
                    Common.msg('修改成功!', {icon: 1});
                } else {
                    Common.alertErrors(data.info);
                }
            });
        });
    })

    uploadFile('avatar', 'images', 'jpg|png|gif|jpeg', '80*80', 1);
</script>
</body>
</html>
