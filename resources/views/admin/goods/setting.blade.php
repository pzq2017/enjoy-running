<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Edit('{{ $good->id }}')">返回</button>
</div>
<div class="layui-card-body">
    @if ($type == 'size')
        <div id="form-data">
            @include('admin.goods.setting_edit', ['type' => $type, 'good' => $good, 'setting' => ''])
        </div>
        <div id="list-data">
            <table class="list-table">
                <tr>
                    <th>尺寸名称</th>
                    <th>创建日期</th>
                    <th>操作</th>
                </tr>
                @foreach($list_settings as $list_setting)
                <tr>
                    <td>{{ $list_setting->name }}</td>
                    <td>{{ $list_setting->created_at }}</td>
                    <td>
                        <a class="layui-btn layui-btn-normal layui-btn-xs" onclick="editSetting('{{ $list_setting->id }}', '{{ $list_setting->goods_id }}', 'size')">编辑</a>
                        <a class="layui-btn layui-btn-danger layui-btn-xs" onclick="deleteSetting('{{ $list_setting->id }}', '{{ $list_setting->goods_id }}', 'size')">删除</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    @elseif($type == 'color')
        <div id="form-data">
            @include('admin.goods.setting_edit', ['type' => $type, 'good' => $good, 'setting' => ''])
        </div>
        <div id="list-data">
            <table class="list-table">
                <tr>
                    <th>颜色名称</th>
                    <th>创建日期</th>
                    <th>操作</th>
                </tr>
                @foreach($list_settings as $list_setting)
                    <tr>
                        <td>{{ $list_setting->name }}</td>
                        <td>{{ $list_setting->created_at }}</td>
                        <td>
                            <a class="layui-btn layui-btn-normal layui-btn-xs" onclick="editSetting('{{ $list_setting->id }}', '{{ $list_setting->goods_id }}', 'color')">编辑</a>
                            <a class="layui-btn layui-btn-danger layui-btn-xs" onclick="deleteSetting('{{ $list_setting->id }}', '{{ $list_setting->goods_id }}', 'color')">删除</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @elseif($type == 'album')
        <div id="form-data">
            @include('admin.goods.setting_edit', ['type' => $type, 'good' => $good, 'setting' => ''])
        </div>
        <div id="list-data">
            <table class="list-table">
                <tr>
                    <th>颜色名称</th>
                    <th>商品图片</th>
                    <th>创建日期</th>
                    <th>操作</th>
                </tr>
                @foreach($list_settings as $list_setting)
                    <tr>
                        <td>{{ $list_setting->name }}</td>
                        <td>{{ $list_setting->image }}</td>
                        <td>{{ $list_setting->created_at }}</td>
                        <td>
                            <a class="layui-btn layui-btn-normal layui-btn-xs" onclick="editSetting('{{ $list_setting->id }}', '{{ $list_setting->goods_id }}', 'color')">编辑</a>
                            <a class="layui-btn layui-btn-danger layui-btn-xs" onclick="deleteSetting('{{ $list_setting->id }}', '{{ $list_setting->goods_id }}', 'color')">删除</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @elseif($type == 'detail')
    @endif
</div>
<script>
    layui.use('form', function () {
        var form = layui.form, type = '{{ $type }}';
        form.render();

        form.on('submit('+type+'_info)', function (data) {
            loading = Common.msg('正在提交数据，请稍后...', {icon: 16, time: 60000});
            var field = data.field;
            Common.ajaxRequest(Common.getRealRoutePath(route_url.setting_store, {good: field.goods_id}), field, 'PUT', function (data) {
                if (data.status == 'success') {
                    Common.msg('保存成功!', {icon: 1});
                    setting(field.goods_id, field.type);
                } else {
                    Common.alertErrors(data.info);
                }
            });
        });
    })

    function editSetting(id, goods_id, type)
    {
        Common.loadPage(Common.getRealRoutePath(route_url.setting_edit, {good: goods_id}), {'type': type, 'id': id}, function (page) {
            $('#form-data').html(page);
        });
    }

    function deleteSetting(id, goods_id, type)
    {
        var confirm_dialog = Common.confirm({
            title: '删除商品属性',
            content: '您确定要删除当前商品属性信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.setting_delete, {good: goods_id}), {'type': type, 'id': id}, 'DELETE', function (data) {
                    if (data.status == 'success') {
                        Common.close(confirm_dialog);
                        Common.msg("删除成功！", {icon: 1}, function () {
                            setting(goods_id, type);
                        });
                    } else {
                        Common.alertErrors(data.info);
                    }
                });
            }
        })
    }
</script>
