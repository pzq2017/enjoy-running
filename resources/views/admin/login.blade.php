<!DOCTYpE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">
    <link href="/plugin/layui/css/layui.css" rel="stylesheet" type="text/css" />
    <link href="/css/login.css" rel="stylesheet" type="text/css" />
    <title>后台管理中心登录</title>
</head>
<body id="loginFrame">
<div class="wst-lo-center ">
    <div class="wst-lo">
        <div class="login-header">
            <div class='login_logo'>
                <img src="/imgs/login_logo.png">
            </div>
            <div class="login_title">
                <div class='title_cn'>后台管理系统</div>
            </div>
            <div class="wst-clear"></div>
        </div>
        <div class="login-wrapper">
            <div class="boxbg2"></div>
            <div class="box">
                <div class="content-wrap">
                    <div class="login-box">
                        <div class="login-icon1">账&nbsp;&nbsp;&nbsp;号</div>
                        <div class="login-icon2">密&nbsp;&nbsp;&nbsp;码</div>
                        <div class="login-icon3">验证码</div>
                        <input id='loginName' name="loginName" type="text" class="layui-input ipt ">
                        <input id='loginPwd' name="loginPwd" type="password" class="layui-input ipt">
                        <div class="frame">
                            <input type='text' id='verifyCode' name="verifyCode" class='layui-input  ipt text2'>
                            <img id='verifyImg' src="{{ captcha_src() }}" onclick="this.src='{{ captcha_src() }}?'+Math.random()">
                        </div>
                    </div>
                    <button id="loginbtn" type="button" onclick='login()' class="layui-btn layui-btn-big layui-btn-normal" style="width: 100%;">登&nbsp;&nbsp;&nbsp;&nbsp;录</button>
                </div>
            </div>
        </div>
        <div class="login-footer"></div>
</div>
<script type="application/javascript" src="/js/jquery.min.js"></script>
<script type="application/javascript" src="/plugin/layui/layui.js"></script>
<script type="application/javascript" src="/js/common.js"></script>
<script type="application/javascript" src="/js/admin/login.js"></script>
<script>
    var baseParams = {csrf_token: '{{ csrf_token() }}', checkLoginUrl: '{{ route('admin.checkLogin') }}'};
    document.onkeydown = function (event) {
        var e = event || window.event;
        if (e && e.keyCode == 13) {
            login();
        }
    }
</script>
</body>
</html>
