<div class="layui-card-header">
    <button class="layui-btn layui-btn-normal" onclick="Lists(1)">返回</button>
</div>
<div class="layui-card-body">
    <form class="layui-form" onsubmit="return false;">
        <div class="layui-form-item">
            <label class="layui-form-label">类别<font color='red'>*</font>:</label>
            <div class="layui-input-block width-per-50">
                <select name="category_id" lay-verify="required">
                    <option value="">请选择商品所属类别</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">名称<font color='red'>*</font>:</label>
            <div class="layui-input-block width-per-50">
                <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图片<font color='red'>*</font>:</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list hidden">
                        <input type="hidden" name="image_path" id="goods_value">
                        <img class="layui-upload-img" src="" id="goods_preview" style="width: 100px;">
                    </div>
                    <button type="button" class="layui-btn layui-btn-danger" id="goods_upload">上传图片</button>
                    <span class="upload_tips">图片支持格式:jpg,jpeg,gif,png;建议上传图片大小:<font>200*200</font>px</span>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">类型<font color='red'>*</font>:</label>
            <div class="layui-input-block">
                <input type="radio" name="type" value="1" lay-filter="goodsType" title="实体" checked>
                <input type="radio" name="type" value="2" lay-filter="goodsType" title="虚拟装扮">
                <input type="radio" name="type" value="3" lay-filter="goodsType" title="虚拟礼物">
            </div>
        </div>
        <div class="layui-form-item hidden virtual">
            <label class="layui-form-label">支付方式<font color='red'>*</font>:</label>
            <div class="layui-input-inline" id="payMethod">
                <input type="radio" name="pay_method" value="1" lay-filter="payMethod" title="里程币" checked>
                <input type="radio" name="pay_method" value="2" lay-filter="payMethod" title="金币">
            </div>
        </div>
        <div class="layui-form-item physical">
            <label class="layui-form-label">原价<font color='red'>*</font>:</label>
            <div class="layui-input-inline">
                <input type="number" name="original_price" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item physical">
            <label class="layui-form-label">现价<font color='red'>*</font>:</label>
            <div class="layui-input-inline">
                <input type="number" name="price" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item hidden mileage_coin">
            <label class="layui-form-label">里程币<font color='red'>*</font>:</label>
            <div class="layui-input-inline">
                <input type="number" name="mileage_coin" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item hidden gold_coin">
            <label class="layui-form-label">金币<font color='red'>*</font>:</label>
            <div class="layui-input-inline">
                <input type="number" name="gold_coin" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">库存<font color='red'>*</font>:</label>
            <div class="layui-input-inline">
                <input type="number" name="stock" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">好评率:</label>
            <div class="layui-input-inline">
                <input type="number" name="applause_rate" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">简介:</label>
            <div class="layui-input-block width-per-50">
                <textarea name="intro" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态:</label>
            <div class="layui-input-block">
                <input type="hidden" name="status">
                <input type="checkbox" lay-skin="switch" lay-filter="switchStatus" lay-text="上架|下架">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="goods_info">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use('form', function () {
        var form = layui.form;
        form.render();

        form.on('radio(goodsType)', function (data) {
            $('.mileage_coin').addClass('hidden').find('input').removeAttr('lay-verify').val('');
            $('.gold_coin').addClass('hidden').find('input').removeAttr('lay-verify').val('');
            if (data.value == 1) {
                $('.physical').removeClass('hidden');
                $('.virtual').addClass('hidden');
            } else {
                $('.physical').addClass('hidden');
                $('.virtual').removeClass('hidden');
                var pay_method = $('#payMethod').find('input[name="pay_method"]:checked').val();
                if (pay_method == 1) {
                    $('.mileage_coin').removeClass('hidden').find('input').attr('lay-verify', 'required');
                } else {
                    $('.gold_coin').removeClass('hidden').find('input').attr('lay-verify', 'required');
                }
            }
        });

        form.on('radio(payMethod)', function (data) {
            if (data.value == 1) {
                $('.mileage_coin').removeClass('hidden').find('input').attr('lay-verify', 'required');
                $('.gold_coin').addClass('hidden').find('input').removeAttr('lay-verify');
            } else {
                $('.mileage_coin').addClass('hidden').find('input').removeAttr('lay-verify');
                $('.gold_coin').removeClass('hidden').find('input').attr('lay-verify', 'required');
            }
        });

        form.on('switch(switchStatus)', function (obj) {
            $(this).parent().find('input[name="status"]').val(this.checked ? 1 : 0);
        });

        form.on('submit(goods_info)', function (data) {
            Save(0, data.field);
        });
    })

    uploadFile('goods', 'images', 'jpg|png|gif|jpeg');
</script>
