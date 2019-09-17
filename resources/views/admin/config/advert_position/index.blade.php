@section('search')
    <div class="layui-card-body">
        <form class="lotus-search-form layui-form layui-col-space5" name="advertSearch" onsubmit="return false;">
            <div class="layui-inline layui-show-xs-block">
                <input type="text" name="name" placeholder="广告位置名称" autocomplete="off" class="layui-input">
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
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        lists: '{{ route('admin.config.advert_position.lists') }}',
        create: '{{ route('admin.config.advert_position.create') }}',
        save: '{{ route('admin.config.advert_position.store') }}',
        edit: '{{ route_uri('admin.config.advert_position.edit') }}',
        update: '{{ route_uri('admin.config.advert_position.update') }}',
        delete: '{{ route_uri('admin.config.advert_position.destroy') }}',
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
            toolbar: '#toolbar',
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'name', title: '位置名称', align: 'center'},
                {field: 'width', title: '建议宽度(px)', align: 'center'},
                {field: 'height', title: '建议高度(px)', align: 'center'},
                {field: 'created_at', title: '创建日期',sort: true, width: 200, align: 'center'},
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
        var url = id ? Common.getRealRoutePath(route_url.edit, {advert_position: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {advert_position: id}) : route_url.save;
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
            title: '删除广告位置',
            content: '您确定要删除当前广告位置信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {advert_position: id}), null, 'DELETE', function (data) {
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

    function Search() {
        search = {};
        var form = document.forms['advertPositionsSearch'];
        if (form.name.value)
            search.name = form.name.value;
        Lists(1);
    }

    $(document).ready(function () {
        Lists(1);
    });
</script>
