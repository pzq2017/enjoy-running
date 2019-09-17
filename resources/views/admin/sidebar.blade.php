<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree" lay-shrink="all">
            @foreach($menus as $menu)
            <li class="layui-nav-item">
                @if($menu->subChildMenu->count() > 0)
                    <a href="javascript:void(0);">{{ $menu->name }}<span class="layui-nav-more"></span></a>
                    <dl class="layui-nav-child">
                        @foreach($menu->subChildMenu as $childMenu)
                            <dd>
                                @if ($childMenu->subThirdMenu->count() > 0)
                                    <a href="javascript:void(0);" style="padding-left: 40px; padding-right: 0px;">{{ $menu->name }}<span class="layui-nav-more"></span></a>
                                    <dl class="layui-nav-child">
                                        @foreach($childMenu->subThirdMenu as $thirdMenu)
                                            <dd>
                                                <a class="menu_item" href="javascript:void(0);" style="padding-left: 60px; padding-right: 0px;" url="{{ $thirdMenu->url }}">{{ $thirdMenu->name }}</a>
                                            </dd>
                                        @endforeach
                                    </dl>
                                @else
                                    <a class="menu_item" href="javascript:void(0);" style="padding-left: 40px; padding-right: 0px;" url="{{ $childMenu->url }}">{{ $childMenu->name }}</a>
                                @endif
                            </dd>
                        @endforeach
                    </dl>
                @else
                    <a class="menu_item" href="javascript:void(0);" url="{{ $menu->url }}">{{ $menu->name }}</a>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.menu_item').click(function () {
            var target_url = $(this).attr('url');
            if (!target_url) return;
            Common.loadPage(target_url, {}, function (page) {
                $('#content_body').html(page);
            })
        });
    })
</script>
