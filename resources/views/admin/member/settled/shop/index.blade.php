@extends('admin.layout')
<script type="text/html" id="actionBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="view">查看</a>
</script>
<script type="text/javascript">
    var search = {}, curr_page = 1;
    var route_url = {
        lists: '{{ route('admin.member.settled.shop.lists') }}',
        show: '{{ route_uri('admin.member.settled.shop.show') }}',
    };
    function Lists(page) {
        if (!page) page = curr_page;
        Common.dataTableRender(page, {
            url: route_url.lists,
            where: search,
            cols: [[
                {field: 'uid', title: '会员ID', sort: true, width: 80, align: 'center'},
                {field: 'name', title: '姓名', align: 'center'},
                {field: 'phone', title: '电话', align: 'center'},
                {field: 'id_card', title: '身份证号', align: 'center'},
                {field: 'area', title: '省市区', align: 'center'},
                {field: 'audit_status', title: '审核状态', align: 'center'},
                {field: 'is_settled_success', title: '入驻状态', align: 'center', templet: function (data) {
                    return data.is_settled_success ? '已入驻' : '未入驻';
                }},
                {field: 'created_at', title: '申请日期',sort: true},
                {title: '操作', toolbar: '#actionBar', width: 100, align: 'center'},
            ]],
            done: function (res, curr) {
                curr_page = curr;
            }
        }, function (table) {
            table.on('tool(list-datas)', function (obj) {
                var event = obj.event, data = obj.data;
                if (event == 'view') {
                    Show(data.id);
                } else if (event == 'del') {
                    Delete(data.id);
                }
            });
            $('.card-box').addClass('hidden');
            $('.card-box').eq(0).removeClass('hidden');
        });
    }

    function Show(id) {
        Common.loadPage(Common.getRealRoutePath(route_url.show, {shop: id}), {}, function (page) {
            $('.card-box').addClass('hidden');
            $('#content_box').html(page).removeClass('hidden');
        });
    }

    $(document).ready(function () {
        Lists(1);
    });
</script>