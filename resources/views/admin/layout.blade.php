<div class="layadmin-tabsbody-item layui-show">
    <div class="layui-card layadmin-header"></div>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card card-box">
                    @yield('search')
                    <div class="layui-card-body layui-table-body layui-table-main">
                        <table class="layui-hide" id="list-datas" lay-filter="list-datas"></table>
                    </div>
                </div>
                <div class="layui-card card-box hidden" id="content_box"></div>
            </div>
        </div>
    </div>
</div>
