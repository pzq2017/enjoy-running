function goBack(backurl) {
    Common.loadPage(backurl, {}, function (page) {
        $('#content_body').html(page);
    })
}

function myInfo() {
    Common.open({
        title: '个人资料',
        type: 2,
        area: ['460px', '430px'],
        offset: '150px',
        content: baseParams.myinfo_url
    })
}

function editPwd() {
    var dialog = Common.open({
        title: '修改密码', 
        type: 1,
        area: ['400px', '280px'],
        offset: '150px',
        content: $('#editPwdBox').html(),
        success: function () {
            layui.use('form', function () {
                layui.form.on('submit(change_password)', function (data) {
                    loading = Common.msg('正在提交数据，请稍后...', {icon: 16, time: 60000});
                    Common.ajaxRequest(baseParams.change_password_url, data.field, 'POST', function (data) {
                        if (data.status == 'success') {
                            Common.msg('修改成功!', {icon: 1});
                            Common.close(dialog);
                        } else {
                            Common.alertErrors(data.info);
                        }
                    });
                });
            })
        }
    })
}

function logout() {
    loading = Common.msg('正在退出账号，请稍后...', {icon: 16, time: 60000});
    Common.ajaxRequest(baseParams.logout_url, null, 'GET', function (data) {
        if (data.status == 'success') {
            Common.msg('账号已成功退出', {icon: 1}, function () {
                location.href = '/admin/login';
            })
        } else {
            Common.alertErrors(data.info);
        }
    });
}

function clearCache() {
    loading = Common.msg('正在清除缓存，请稍后...', {icon: 16, time: 60000});
    Common.ajaxRequest(window.params.clearCacheUrl, null, 'GET', function (data) {
        if (data.status == 'success') {
            Common.msg('缓存已成功清除', {icon: 1});
        } else {
            Common.alertErrors(data.info);
        }
    });
}

function uploadFile(objId, acceptType, acceptExts, pSize, handleType) {
    if (!pSize) pSize = '';
    if (!handleType) handleType = '';
    layui.use('upload', function () {
        var load;
        layui.upload.render({
            elem: '#' + objId + '_upload',
            url: baseParams.upload_url,
            headers: {'X-CSRF-TOKEN': baseParams.csrf_token},
            size: Const.maxUploadSize,     //KB
            accept: acceptType,         //images, file, video, audio
            exts: acceptExts,
            data: {type: acceptType, pSize: pSize, handleType: handleType},
            before: function(obj){
                load = Common.loading();
            },
            done: function(res){
                Common.close(load);
                if (res.status == 'success') {
                    if (acceptType == 'images') {
                        $('#' + objId + '_preview').attr('src', res.message.fileUrl);
                        $('#' + objId + '_preview').parent().removeClass('hidden');
                    }
                    $('#' + objId + '_value').val(res.message.filePath);
                } else {
                    if (res.info) {
                        Common.alertErrors(res.info);
                    } else {
                        Common.alertErrors('上传失败.');
                    }
                }
            },
            error: function(){
                Common.close(load);
                Common.alertErrors('上传失败.');
            }
        });
    })
}