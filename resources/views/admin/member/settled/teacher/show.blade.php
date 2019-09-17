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
                <td class="td_label">姓名:</td>
                <td class="td_text">{{ $apply->name }}</td>
                <td class="td_label">性别:</td>
                <td class="td_text">{{ $apply->sex }}</td>
            </tr>
            <tr>
                <td class="td_label">联系电话:</td>
                <td class="td_text">{{ $apply->phone }}</td>
                <td class="td_label">身份证号:</td>
                <td class="td_text">{{ $apply->id_card }}</td>
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
                <td class="td_label">获得成就:</td>
                <td class="td_text">{{ $apply->achievement }}</td>
                <td class="td_label">人生格言:</td>
                <td class="td_text">{{ $apply->motto }}</td>
            </tr>
            <tr>
                <td class="td_label">个人简介:</td>
                <td class="td_text" colspan="3">{{ $apply->intro }}</td>
            </tr>
            <tr>
                <td class="td_label">团课费用:</td>
                <td class="td_text">{{ $apply->group_buying_fee }} 元/节课</td>
                <td class="td_label">团课人数:</td>
                <td class="td_text">{{ $apply->cluster_number }}</td>
            </tr>
            <tr>
                <td class="td_label">私教费用:</td>
                <td class="td_text" colspan="3">{{ $apply->private_tuition_fee }} 元/节课</td>
            </tr>
            <tr>
                <td class="td_label">服务区域:</td>
                <td class="td_text" colspan="3"></td>
            </tr>
            <tr>
                <td class="td_label">标签:</td>
                <td class="td_text" colspan="3"></td>
            </tr>
            <tr>
                <td class="td_label">课程详情:</td>
                <td class="td_text" colspan="3"></td>
            </tr>
            <tr>
                <td class="td_label">详情页图片:</td>
                <td class="td_text" colspan="3"></td>
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