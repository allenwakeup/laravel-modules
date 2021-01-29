<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@lang('goodcatch::pages.admin.login.name'){{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/public/vendor/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/admin/css/lightcms-login.css" media="all">
    <link rel="stylesheet" href="/public/admin/css/lightcms-login-ext.css" media="all">
</head>
<body>

<div class="lightcms-user-login lightcms-user-display-show" id="user-login" style="display: none;">
    <div class="lightcms-user-background" style="background: url(/public/admin/image/bg.jpg) no-repeat center center;">

    </div>
    <ul class="layui-nav layui-layout-right">
        <li class="layui-nav-item">
            <a href="javascript:;">
                <i class="layui-icon layui-icon-goodcatch layui-icon-goodcatch-language" style="font-size: 20px; color: #009688;"></i>
                @lang('goodcatch::pages.laravel_modules.lang')
            </a>
            <dl class="layui-nav-child">

                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                    <dd>
                        <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    </dd>

                @endforeach
            </dl>
        </li>
        <li class="layui-nav-item"><a href="/">@lang('goodcatch::pages.welcome.name')</a></li>
    </ul>



    <div class="lightcms-user-login-main">
        <div class="lightcms-user-login-box lightcms-user-login-header">
            <h2>@lang('goodcatch::pages.admin.login.name')</h2>
        </div>
        <form id="form">
            <div class="lightcms-user-login-box lightcms-user-login-body layui-form">
                <div class="layui-form-item">
                    <label class="lightcms-user-login-icon layui-icon layui-icon-username" for="login-username"></label>
                    <input type="text" name="name" id="login-username" lay-verify="required" placeholder="@lang('goodcatch::pages.admin.login.form.account')" class="layui-input">
                </div>
                <div class="layui-form-item">
                    <label class="lightcms-user-login-icon layui-icon layui-icon-password" for="login-password"></label>
                    <input type="password" name="password" id="login-password" lay-verify="required" placeholder="@lang('goodcatch::pages.admin.login.form.password')" class="layui-input">
                </div>
                <div class="layui-form-item">
                    <div class="layui-row">
                        <div class="layui-col-xs7">
                            <label class="lightcms-user-login-icon layui-icon layui-icon-vercode" for="login-vercode"></label>
                            <input type="text" name="captcha" id="login-vercode" lay-verify="required" placeholder="@lang('goodcatch::pages.admin.login.form.captcha')" class="layui-input">
                        </div>
                        <div class="layui-col-xs5">
                            <div style="margin-left: 10px;">
                                <img src="{{ captcha_src() }}" class="lightcms-user-login-codeimg" id="get-vercode" title="@lang('goodcatch::pages.admin.login.form.fresh_captcha')" onclick="$(this).prop('src', $(this).prop('src').split('?')[0] + '?' + Math.random())">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="login-submit" type="submit">@lang('goodcatch::pages.admin.login.name')</button>
                </div>
            </div>
        </form>
    </div>

    <div class="layui-trans lightcms-user-login-footer">
        <p>© {{ date ('Y') }} <a href="/" target="_blank">{{ config('app.name') }}</a></p>
    </div>

</div>

<script src="/public/vendor/layui/layui.all.js"></script>
<script src="/public/admin/js/admin.js"></script>
<script src="/public/admin/js/admin-ext.js"></script>
<script>
    $('#form').submit(function () {
        window.form_submit = $('#form').find('[type=submit]');
        form_submit.prop('disabled', true);
        $.ajax({
            url: '{{ route('admin::login') }}',
            data: $('#form').serializeArray(),
            success: function (result) {
                if (result.code !== 0) {
                    form_submit.prop('disabled', false);
                    layer.msg(result.msg, {shift: 6});
                    return false;
                }
                layer.msg(result.msg, {icon: 1}, function () {
                    if (result.reload) {
                        location.reload();
                    }
                    if (result.redirect) {
                        location.href = '{{ route('admin::index') }}';
                    }
                });
            },
            complete: function (d) {
                if (d.responseText.indexOf('"errors"') >= 0) {
                    $('#get-vercode').click();
                }
            }
        });
        return false;
    });

    $ ('.lightcms-user-background').mousemove (function (e) {
        $ (this).css ('transform', 'matrix(1.08, 0, 0, 1.08, ' + (e.target.clientWidth / 2 - e.clientX) / e.target.clientWidth * 80 + ', ' + (e.target.clientHeight / 2 - e.clientY) / e.target.clientHeight * 40 + ')');
    }).mouseout (function (e) {
        $ (this).css ('transform', 'matrix(1, 0, 0, 1, 0, 0)')
    });
</script>
</body>
</html>