@section('search')
    <div class="layui-card-body">
        <form class="lotus-search-form layui-form layui-col-space5" name="accountSearch" onsubmit="return false;">
            <div class="layui-inline layui-show-xs-block">
                <input type="text" name="loginAccount" placeholder="账号" autocomplete="off" class="layui-input">
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
    <a class="layui-btn layui-btn-xs" lay-event="view">查看</a>
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/html" id="isActivate">
    <input type="checkbox" name="status" value="@{{ d.id }}" lay-filter="activate" title="激活" @{{ d.status ? 'checked' : '' }}>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        lists: '{{ route('admin.member.account.lists') }}',
        create: '{{ route('admin.member.account.create') }}',
        save: '{{ route('admin.member.account.store') }}',
        edit: '{{ route_uri('admin.member.account.edit') }}',
        update: '{{ route_uri('admin.member.account.update') }}',
        show: '{{ route_uri('admin.member.account.show') }}',
        delete: '{{ route_uri('admin.member.account.destroy') }}',
        activate: '{{ route_uri('admin.member.account.activate') }}',
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
            toolbar: '#toolbar',
            cols: [[
                {field: 'id', title: 'ID', sort: true, width: 60, align: 'center'},
                {field: 'loginAccount', title: '账号', align: 'center'},
                {field: 'nickname', title: '昵称', align: 'center'},
                {field: 'glamour_value', title: '魅力值', align: 'center'},
                {field: 'mileage_coin', title: '里程币', align: 'center'},
                {field: 'gold_coin', title: '金币', align: 'center'},
                {field: 'balance_money', title: '账户余额', align: 'center'},
                {field: 'status', title: '账号状态', align: 'center', unresize: true, templet: '#isActivate'},
                {field: 'created_at', title: '注册日期',sort: true, align: 'center'},
                {fixed: 'right', title: '操作', toolbar: '#actionBar', width: 200, align: 'center'},
            ]],
            done: function (res, curr) {
                curr_page = curr;
            }
        }, function (table) {
            table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'view') {
                    Show(data.id);
                } else if (event == 'edit') {
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
        var url = id ? Common.getRealRoutePath(route_url.edit, {account: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {account: id}) : route_url.save;
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

    function Show(id) {
        var url = id ? Common.getRealRoutePath(route_url.show, {account: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Delete(id) {
        var confirm_dialog = Common.confirm({
            title: '删除会员',
            content: '您确定要删除当前会员信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {account: id}), null, 'DELETE', function (data) {
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
        layui.form.on('checkbox(activate)', function (obj) {
            var url = Common.getRealRoutePath(route_url.activate, {account: this.value});
            Common.ajaxRequest(url, {activate: obj.elem.checked ? 1 : 0}, 'PUT', function (data) {
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
        var form = document.forms['accountSearch'];
        if (form.loginAccount.value)
            search.loginAccount = form.loginAccount.value;
        Lists(1);
    }

    $(document).ready(function () {
        Lists(1);
    });
</script>
