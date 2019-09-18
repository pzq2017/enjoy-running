@section('search')
    <div class="layui-card-body">
        <form class="lotus-search-form layui-form layui-col-space5" name="goodsSearch" onsubmit="return false;">
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
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/html" id="isActivate">
    <input type="checkbox" name="status" value="@{{ d.id }}" lay-filter="activate" title="激活" @{{ d.status ? 'checked' : '' }}>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        lists: '{{ route('admin.goods.lists') }}',
        create: '{{ route('admin.goods.create') }}',
        save: '{{ route('admin.goods.store') }}',
        edit: '{{ route_uri('admin.goods.edit') }}',
        update: '{{ route_uri('admin.goods.update') }}',
        delete: '{{ route_uri('admin.goods.destroy') }}'
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
                {field: 'categoryName', title: '类别', align: 'center'},
                {field: 'typeName', title: '类型', align: 'center'},
                {field: 'imageUrl', title: '图片', align: 'center', templet: function (data) {
                    return '<a href="'+data.imageUrl+'" target="_blank"><img src="'+data.imageUrl+'"></a>';
                }},
                {field: 'price', title: '价格', align: 'center', templet: function (data) {
                    if (data.type == 1) {
                        return '<span style="display: block;">原价: '+data.original_price+'</span>' + '<span style="display: block;">现价: '+data.price+'</span>';
                    } else if (data.type == 2 || data.type == 3) {
                        if (data.mileage_coin > 0) {
                            return '<span>里程币：'+data.mileage_coin+'</span>';
                        } else if (data.gold_coin > 0) {
                            return '<span>金币：'+data.gold_coin+'</span>';
                        }
                    }
                }},
                {field: 'statusName', title: '状态', align: 'center'},
                {field: 'created_at', title: '创建日期',sort: true, align: 'center'},
                {title: '操作', toolbar: '#actionBar', width: 120, align: 'center'},
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
        var url = id ? Common.getRealRoutePath(route_url.edit, {good: id}) : route_url.create;
        Common.loadPage(url, {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    function Save(id, form_datas) {
        var saveUrl = id > 0 ? Common.getRealRoutePath(route_url.update, {good: id}) : route_url.save;
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
            title: '删除商品',
            content: '您确定要删除当前商品信息吗？',
            yes: function () {
                loading = Common.msg('正在删除中,请稍后...', {icon: 16, time: 60000});
                Common.ajaxRequest(Common.getRealRoutePath(route_url.delete, {good: id}), null, 'DELETE', function (data) {
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
            var url = Common.getRealRoutePath(route_url.activate, {good: this.value});
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
        var form = document.forms['goodsSearch'];
        if (form.name.value)
            search.name = form.name.value;
        Lists(1);
    }

    $(document).ready(function () {
        Lists(1);
    });
</script>