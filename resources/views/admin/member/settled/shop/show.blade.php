<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists()">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form layui-form-pane">
        <table class="form_table_item">
            <tr>
                <td class="td_label">会员ID:</td>
                <td class="td_text">{{ $apply->uid }}</td>
                <td class="td_label">会员账号:</td>
                <td class="td_text">{{ $apply->member->loginAccount }}</td>
            </tr>
            <tr>
                <td class="td_label">机构名称:</td>
                <td class="td_text" colspan="3">{{ $apply->name }}</td>
            </tr>
            <tr>
                <td class="td_label">机构地址:</td>
                <td class="td_text" colspan="3">{{ $apply->province }} - {{ $apply->city }} - {{ $apply->region }} - {{ $apply->address }}</td>
            </tr>
            <tr>
                <td class="td_label">联系人:</td>
                <td class="td_text">{{ $apply->name }}</td>
                <td class="td_label">法人电话:</td>
                <td class="td_text">{{ $apply->phone }}</td>
            </tr>
            <tr>
                <td class="td_label">身份证号:</td>
                <td class="td_text" colspan="3">{{ $apply->id_card }}</td>
            </tr>
            <tr>
                <td class="td_label">身份证正面:</td>
                <td class="td_text">
                    @if($apply->positive_id_card)
                        <div class="img_preview"><img src="{{ App\Services\Storage\Oss\UrlService::getUrl($member->positive_id_card, ['width' => 100]) }}"></div>
                    @endif
                </td>
                <td class="td_label">身份证反面:</td>
                <td class="td_text">
                    @if($apply->side_id_card)
                        <div class="img_preview"><img src="{{ App\Services\Storage\Oss\UrlService::getUrl($member->side_id_card, ['width' => 100]) }}"></div>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="td_label">营业执照:</td>
                <td class="td_text" colspan="3">
                    @if($apply->business_license)
                        <div class="img_preview"><img src="{{ App\Services\Storage\Oss\UrlService::getUrl($member->business_license, ['width' => 100]) }}"></div>
                    @endif
                </td>
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