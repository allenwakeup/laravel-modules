<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@isset($breadcrumb){{ last($breadcrumb)['title'] }}@endisset - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="/public/admin/css/iconfont/iconfont.css" media="all">
    <link rel="stylesheet" href="/public/vendor/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/admin/css/lightCMSAdmin.css" media="all">
    <link rel="stylesheet" href="/public/admin/css/goodcatch.css" media="all">
    @yield('css')
</head>
<body class="layui-layout-body layui-theme-goodcatch">
@php
    $user = \Auth::guard('admin')->user();
    $isSuperAdmin = in_array($user->id, config('light.superAdmin'));
@endphp
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">{{ config('app.name') }}</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            @foreach(App\Repository\Admin\MenuRepository::allRoot() as $v)
                @if($isSuperAdmin || $user->can($v->name))
                    <li class="layui-nav-item @if(!empty($light_menu) && $v->id == $light_menu['id']) layui-this @endif"><a href="{{  \LaravelLocalization::localizeURL( $v->url ) }}">@lang('pages.app.menu.' . \Illuminate\Support\Str::replaceFirst('::', '.', $v->route))</a></li>
                @endif
            @endforeach
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <i class="layui-icon layui-icon-username" style="font-size: 20px; color: #009688;"></i>
                    {{ \Auth::guard('admin')->user()->name }}
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="{{  \LaravelLocalization::localizeURL(  route('admin::adminUser.edit', ['id' => \Auth::guard('admin')->user()->id]) )}}">编辑用户</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <i class="layui-icon layui-icon-goodcatch-language" style="font-size: 20px; color: #009688;"></i>
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
            <li class="layui-nav-item"><a href="{{  \LaravelLocalization::localizeURL(  route('admin::logout') )}}">@lang('goodcatch::pages.admin.sign.out.name')</a></li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->

            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                <li class="layui-nav-item">
                    <a class="" href="javascript:;">
                        <div title="菜单缩放" class="kit-side-fold" data-show="true">
                            <i class="layui-icon layui-icon-spread-left" aria-hidden="true"></i>
                        </div>
                    </a>
                </li>

                @isset($light_menu['children'])
                    @foreach($light_menu['children']->groupBy('group') as $k => $menu)
                        @if($k != '')
                            <li class="layui-nav-item @if(collect($menu)->filter(function ($item, $key) use ($light_cur_route) {return $item ['route'] == $light_cur_route;})->count()>0) layui-nav-itemed @endif" ><!-- layui-nav-itemed 自动展开 -->
                                @foreach($menu as $sidx => $sub)
                                    @if(intval($sub['status']) === App\Model\Admin\Menu::STATUS_ENABLE && ($isSuperAdmin || $user->can($sub['name'])))
                                        <a class="" href="javascript:;"><i class="layui-icon layui-icon-goodcatch-menu-g{{ $sidx }}"></i>{{ $k }}</a>
                                        @break
                                    @endif
                                @endforeach

                                <dl class="layui-nav-child">
                                    @foreach($menu as $sub)
                                        @if(intval($sub['status']) === App\Model\Admin\Menu::STATUS_ENABLE && ($isSuperAdmin || $user->can($sub['name'])))
                                            <dd @if($sub['route'] == $light_cur_route) class="layui-this" @endif style="margin-left: 7px" ><a href="{{  \LaravelLocalization::localizeURL(  $sub['url'] )}}">@if(array_has($sub, 'icon')) <i class="layui-icon {{array_get($sub, 'icon')}}"></i> @endif {{ __(config ('pages.app.menu.' . \Illuminate\Support\Str::replaceFirst('::', '.', $sub['route']), $sub ['name'])) }}</a></dd>
                                        @endif
                                    @endforeach
                                </dl>
                            </li>
                        @endif
                    @endforeach
                @endisset
                @isset($autoMenu)
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="" href="javascript:;">系统菜单</a>
                        <dl class="layui-nav-child">
                            @foreach($autoMenu as $v)
                                <dd @if(isset($entity) && $v['id'] == intval($entity)) class="layui-this" @endif><a href="{{ $v['url'] }}">{{ $v['name'] }}</a></dd>
                            @endforeach
                        </dl>
                    </li>
                @endisset
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            @yield ('content')
        </div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © {{ config('app.name') }}
    </div>
</div>
<script src="/public/vendor/layui/layui.all.js"></script>
<script src="/public/vendor/xm-select/xm-select.js"></script>
<script src="/public/admin/js/admin.js"></script>
<script src="/public/admin/js/admin-ext.js"></script>
@yield('js')
</body>
</html>