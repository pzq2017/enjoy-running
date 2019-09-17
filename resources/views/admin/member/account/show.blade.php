<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form layui-form-pane">
        <table class="form_table_item">
            <tr>
                <td class="td_label">登录账号:</td>
                <td class="td_text">{{ $member->loginAccount }}</td>
                <td class="td_label">昵称:</td>
                <td class="td_text">{{ $member->nickname }}</td>
            </tr>
            <tr>
                <td class="td_label">性别:</td>
                <td class="td_text">{{ $member->sex }}</td>
                <td class="td_label">生日:</td>
                <td class="td_text">{{ $member->birthday ?? '-' }}</td>
            </tr>
            <tr>
                <td class="td_label">头像:</td>
                <td colspan="3" class="td_text">
                    @if($member->avatar)
                        <div class="img_preview"><img src="{{ App\Services\Storage\Oss\UrlService::getUrl($member->avatar, ['width' => 80]) }}"></div>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="td_label">个性签名:</td>
                <td colspan="3" class="td_text">{{ $member->signature ?? '-' }}</td>
            </tr>
            <tr>
                <td class="td_label">魅力值:</td>
                <td class="td_text">{{ $member->glamour_value }}</td>
                <td class="td_label">里程币:</td>
                <td class="td_text">{{ $member->mileage_coin }}</td>
            </tr>
            <tr>
                <td class="td_label">余额:</td>
                <td class="td_text">{{ $member->balance_money }}</td>
                <td class="td_label">金币:</td>
                <td class="td_text">{{ $member->gold_coin }}</td>
            </tr>
        </table>
    </form>
</div>
<script>
    layui.use('form', function () {
        var form = layui.form;
        form.render();
    })
</script>