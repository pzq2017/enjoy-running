@section('search')
    <div class="layui-card-body">
        <form class="lotus-search-form layui-form layui-col-space5" name="areasSearch" onsubmit="return false;">
            <div class="layui-inline layui-show-xs-block">
                <input type="text" name="name" placeholder="地区名称" autocomplete="off" class="layui-input">
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
        <button class="layui-btn layui-btn-sm" prev="{{ $prev_pid }}" id="back_grade" onclick="backGrade()">返回上一级</button>
    </div >
</script>
<script type="text/html" id="isShow">
    <input type="checkbox" name="isShow" value="@{{ d.id }}" lay-skin="switch" lay-filter="switchShow" lay-text="显示|隐藏" @{{ d.isShow ? 'checked' : '' }}>
</script>
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-xs" lay-event="view">查看</a>
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/javascript">
    var search = {'pid': {{ $pid }}};
    var route_url = {
        lists: '{{ route('admin.config.area.lists') }}',
        create: '{{ route('admin.config.area.create') }}',
        save: '{{ route('admin.config.area.store') }}',
        edit: '{{ route_uri('admin.config.area.edit') }}',
        update: '{{ route_uri('admin.config.area.update') }}',
        delete: '{{ route_uri('admin.config.area.destroy') }}',
        set_show: '{{ route_uri('admin.config.area.set_show') }}'
    };
    function Lists() {
        Common.dataTableRender(1, {
            url: route_url.lists,
            page: false,
            where: search,
            toolbar: '#toolbar',
            parseData: function (res) {
                return {
                    "code" : 0,
                    "data" : res.message.lists,
                    "prev_pid" : res.message.prev_pid,
                }
            },
            cols: [[
                {field: 'id', title: 'ID', type: 'numbers', sort: true, width: 60, align: 'center'},
                {field: 'name', title: '地区名称', align: 'center'},
                {field: 'first_letter', title: '名称首字母', align: 'center'},
                {field: 'isShow', title: '是否显示', width: 150, align: 'center', unresize: true, templet: '#isShow'},
                {field: 'sort', title: '排序号', width: 80, align: 'center'},
                {field: 'created_at', title: '创建日期',sort: true, width: 180, align: 'center'},
                {title: '操作', width: 200, align: 'center', toolbar: '#actionBar'},
            ]],
            done:function (res) {
                $('#back_grade').attr('prev', res.prev_pid);
            }
        }, function (table) {
            table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'edit') {
                    Edit(data.id);
                } else if (event == 'delete') {
                    Delete(data.id);
                } else if (event == 'view') {
                    search.pid = data.id;
                    Lists();
                }
            });
            $('.card-box').addClass('hidden');
            $('.card-box').eq(0).removeClass('hidden');
        });
    }

    function Edit(id) {
        var url = id ? Common.getRealRoutePath(route_url.edit, {area: id}) : Common.getRealRoutePath(route_url.create, {pid: search.pid});
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {area: id}) : route_url.save;
        Common.ajaxRequest(saveUrl, form_datas, (id > 0 ? 'PUT' : 'POST'), function (data) {
            if (data.status == 'success') {
                Common.msg('保存成功!', {icon: 1}, function () {
                    Lists();
                });
            } else {
                Common.alertErrors(data.info);
            }
        });
    }

    function Delete(id) {
        var confirm_dialog = Common.confirm({
            title: '删除地区',
            content: '您确定要删除当前地区信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {area: id}), null, 'DELETE', function (data) {
                    if (data.status == 'success') {
                        Common.close(confirm_dialog);
                        Common.msg("删除成功！", {icon: 1}, function () {
                            Lists();
                        });
                    } else {
                        Common.alertErrors(data.info);
                    }
                });
            }
        })
    }

    layui.use('form', function () {
        layui.form.on('switch(switchShow)', function (obj) {
            var url = Common.getRealRoutePath(route_url.set_show, {area: this.value});
            Common.ajaxRequest(url, {show: obj.elem.checked ? 1 : 0}, 'PUT', function (data) {
                if (data.status == 'success') {
                    Common.msg('设置成功!', {icon: 1});
                } else {
                    Common.alertErrors('设置失败', {icon: 2});
                }
            });
        });
    })

    function Search() {
        if (search.name) search.name = '';
        var form = document.forms['areasSearch'];
        if (form.name.value)
            search.name = form.name.value;
        Lists();
    }

    function backGrade() {
        search.pid = $('#back_grade').attr('prev');
        Lists();
    }

    $(document).ready(function () {
        Lists();
    });
</script>
