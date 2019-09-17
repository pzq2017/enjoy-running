@section('search')
    <div class="layui-card-body">
        <form class="lotus-search-form layui-form layui-col-space5" name="tagSearch" onsubmit="return false;">
            <div class="layui-inline layui-show-xs-block">
                <input type="text" name="name" placeholder="标签名称" autocomplete="off" class="layui-input">
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
    <input type="checkbox" name="tag_publish" value="@{{ d.id }}" lay-filter="tag_publish" title="发布" @{{ d.status ? 'checked' : '' }}>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        index: '{{ route('admin.config.tag.index') }}',
        lists: '{{ route('admin.config.tag.lists') }}',
        create: '{{ route('admin.config.tag.create') }}',
        save: '{{ route('admin.config.tag.store') }}',
        edit: '{{ route_uri('admin.config.tag.edit') }}',
        update: '{{ route_uri('admin.config.tag.update') }}',
        delete: '{{ route_uri('admin.config.tag.destroy') }}',
        publish: '{{ route_uri('admin.config.tag.publish') }}',
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
            toolbar: '#toolbar',
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'name', title: '名称', align: 'center'},
                {field: 'icon_url', title: '图标', align: 'center', templet: function (data) {
                    return '<a href="'+data.icon_url+'" target="_blank"><img src="'+data.icon_url+'"></a>';
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
        var url = id ? Common.getRealRoutePath(route_url.edit, {tag: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {tag: id}) : route_url.save;
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
            title: '删除标签',
            content: '您确定要删除当前标签信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {tag: id}), null, 'DELETE', function (data) {
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

        layui.form.on('checkbox(tag_publish)', function (obj) {
            var url = Common.getRealRoutePath(route_url.publish, {tag: this.value});
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
        var form = document.forms['tagSearch'];
        if (form.name.value)
            search.name = form.name.value;
        Lists(1);
    }

    $(document).ready(function () {
        Lists(1);
    });
</script>
