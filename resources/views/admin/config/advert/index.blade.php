@section('search')
    <div class="layui-card-body">
        <form class="lotus-search-form layui-form layui-col-space5" name="advertSearch" onsubmit="return false;">
            <div class="layui-inline layui-show-xs-block">
                <input type="text" name="name" placeholder="广告名称" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-inline layui-show-xs-block">
                <select name="position_id">
                    <option value="">请选择位置</option>
                    @foreach($advert_positions as $advert_position)
                        <option value="{{ $advert_position->id }}">{{ $advert_position->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-inline layui-show-xs-block">
                <button class="layui-btn" onclick="Search();">
                    <i class="layui-icon layui-icon-search"></i>
                </button>
            </div>
        </form>
    </div>
@endsection
@extends('admin.layout')
<script type="text/html" id="toolbar">
    <div class="layui-btn-container" >
        <button class="layui-btn layui-btn-sm" onclick="Edit(0)"><i class="layui-icon"></i>添加</button>
    </div >
</script>
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/html" id="isPublish">
    <input type="checkbox" name="ad_publish" value="@{{ d.id }}" lay-filter="advert_publish" title="发布" @{{ d.publish_date ? 'checked' : '' }}>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        index: '{{ route('admin.config.advert.index') }}',
        lists: '{{ route('admin.config.advert.lists') }}',
        create: '{{ route('admin.config.advert.create') }}',
        save: '{{ route('admin.config.advert.store') }}',
        edit: '{{ route_uri('admin.config.advert.edit') }}',
        update: '{{ route_uri('admin.config.advert.update') }}',
        delete: '{{ route_uri('admin.config.advert.destroy') }}',
        publish: '{{ route_uri('admin.config.advert.update_publish_date') }}',
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
            toolbar: '#toolbar',
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'name', title: '广告名称', align: 'center'},
                {field: 'position_id', title: '广告位置', align: 'center', templet: function (data) {
                    if (data.advert_positions) {
                        return data.advert_positions.name;
                    }
                    return '';
                }},
                {field: 'date', title: '广告日期', align: 'center', templet: function (data) {
                    return data.start_date + '~' + data.end_date;
                }},
                {field: 'advert_url', title: '广告图', align: 'center', templet: function (data) {
                    return '<a href="'+data.advert_url+'" target="_blank"><img src="'+data.advert_url+'"></a>';
                }},
                {field: 'sort', title: '排序号', width: 80, align: 'center'},
                {field: 'status', title: '发布状态', width: 120, align: 'center', unresize: true, templet: '#isPublish'},
                {field: 'created_at', title: '创建日期',sort: true, width: 180, align: 'center'},
                {title: '操作', toolbar: '#actionBar', width: 150, align: 'center'},
            ]],
            done: function (res, curr) {
                curr_page = curr;
            }
        }, function (table) {
            table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'edit') {
                    Edit(data.id);
                } else if (event == 'delete') {
                    Delete(data.id);
                }
            });
            $('.card-box').addClass('hidden');
            $('.card-box').eq(0).removeClass('hidden');
        });
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath(route_url.edit, {advert: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {advert: id}) : route_url.save;
        Common.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    Lists(id > 0 ? curr_page : 1);
                });
            } else {
                Common.alertErrors(data.info);
            }
        });
    }

    function Delete(id) {
        var confirm_dialog = Common.confirm({
            title: '删除广告',
            content: '您确定要删除当前广告信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {advert: id}), null, 'DELETE', function (data) {
                    if (data.status == 'success') {
                        Common.close(confirm_dialog);
                        Common.msg("删除成功！", {icon: 1}, function () {
                            Lists(1);
                        });
                    } else {
                        Common.alertErrors(data.info);
                    }
                });
            }
        })
    }

    layui.use('form', function () {
        layui.form.render();

        layui.form.on('checkbox(advert_publish)', function (obj) {
            var url = Common.getRealRoutePath(route_url.publish, {advert: this.value});
            Common.ajaxRequest(url, {publish: obj.elem.checked ? 1 : 0}, 'PUT', function (data) {
                if (data.status == 'success') {
                    Common.msg('设置成功!', {icon: 1});
                } else {
                    Common.alertErrors('设置失败');
                }
            });
        });
    })

    function Search() {
        search = {};
        var form = document.forms['advertSearch'];
        if (form.name.value)
            search.name = form.name.value;
        if (form.position_id.value)
            search.position_id = form.position_id.value;
        Lists(1);
    }

    $(document).ready(function () {
        Lists(1);
    });
</script>
