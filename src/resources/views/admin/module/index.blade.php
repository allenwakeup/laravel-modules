@extends('admin.base')
@section('css')
    <style>
        .layui-layout-admin .layui-side {

            display: none;
        }
        .layui-layout-admin .layui-body {
            left: 0;
        }
        .layui-layout-admin .layui-footer {
            left: 0;
        }
    </style>
@endsection
@section('content')

    @include('admin.breadcrumb')


    <div class="layui-card">
        <div class="layui-form layui-card-header light-search" style="height: auto">
            <form>
                <input type="hidden" name="action" value="search">
                <div class="layui-inline">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.name')</label>
                    <div class="layui-input-inline">
                        <input type="text" name="name" autocomplete="off" class="layui-input" value="{{ request()->get('name') }}">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.alias')</label>
                    <div class="layui-input-inline">
                        <input type="text" name="alias" autocomplete="off" class="layui-input" value="{{ request()->get('alias') }}">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.description')</label>
                    <div class="layui-input-inline">
                        <input type="text" name="description" autocomplete="off" class="layui-input" value="{{ request()->get('description') }}">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.type')</label>
                    <div class="layui-input-inline">
                        <select name="type">
                            <option value="" @if(!request()->has('type')) selected @endif>@lang('goodcatch::pages.laravel_modules.module.search.select')</option>
                            @foreach([
    Goodcatch\Modules\Laravel\Model\Module::TYPE_SYSTEM,
    Goodcatch\Modules\Laravel\Model\Module::TYPE_EXTEND,
] as $v)
                                <option value="{{ $v }}" @isset($model) @if($v == $model->type) selected @endif @endisset>@lang('goodcatch::pages.laravel_modules.module.field.type_' . $v)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.status')</label>
                    <div class="layui-input-inline">
                        <select name="type">
                            <option value="" @if(!request()->has('status')) selected @endif>@lang('goodcatch::pages.laravel_modules.module.search.select')</option>
                            <option value="{{ Goodcatch\Modules\Laravel\Model\Module::STATUS_DISABLE }}" @isset($model) @if(Goodcatch\Modules\Laravel\Model\Module::STATUS_DISABLE === $model->status) selected @endif @endisset>@lang('goodcatch::pages.laravel_modules.module.field.type_disable')</option>
                            <option value="{{ Goodcatch\Modules\Laravel\Model\Module::STATUS_ENABLE }}" @isset($model) @if(Goodcatch\Modules\Laravel\Model\Module::STATUS_ENABLE === $model->status) selected @endif @endisset>@lang('goodcatch::pages.laravel_modules.module.field.type_enable')</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.search.created_at')</label>
                    <div class="layui-input-inline">
                        <input type="text" name="created_at" class="layui-input" id="created_at" value="{{ request ()->get ('created_at') }}">
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-list" lay-filter="form-search" id="submitBtn">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="layui-card-body">


            <table class="layui-table" lay-data="{url:'{{ route ('admin::' . module_route_prefix ('.goodcatch.') . 'module.list') }}?{{ request ()->getQueryString () }}', page:true, limit:50, id:'table', toolbar:'<div><a href=\'{{ route ('admin::' . module_route_prefix ('.goodcatch.') . 'module.create') }}\'><i class=\'layui-icon layui-icon-add-1\'></i>@lang('goodcatch::pages.laravel_modules.module.form.btn.create')</a>&nbsp;&nbsp;&nbsp;&nbsp;@foreach($modules as $module)<span class=\'layui-text\' >{{ $module->getName () }}</span>@endforeach</div>'}" lay-filter="table">
                <thead>
                <tr>
                    <th lay-data="{field:'id', width:80, sort: true, style:'cursor: pointer;', templet:'#id'}">ID</th>
                    <th lay-data="{field:'name', width: 120}">@lang('goodcatch::pages.laravel_modules.module.list.name')</th>
                    <th lay-data="{field:'alias', width: 120}">@lang('goodcatch::pages.laravel_modules.module.list.alias')</th>
                    <th lay-data="{field:'description', width: 180}">@lang('goodcatch::pages.laravel_modules.module.list.description')</th>
                    <th lay-data="{field:'priority', width: 80}">@lang('goodcatch::pages.laravel_modules.module.list.priority')</th>
                    <th lay-data="{field:'version', width: 100}">@lang('goodcatch::pages.laravel_modules.module.list.version')</th>
                    <th lay-data="{field:'path', width: 120}">@lang('goodcatch::pages.laravel_modules.module.list.path')</th>
                    <th lay-data="{field:'type', width: 120, templet:'#typeText'}">@lang('goodcatch::pages.laravel_modules.module.list.type')</th>
                    <th lay-data="{field:'sort', width: 80}">@lang('goodcatch::pages.laravel_modules.module.list.sort')</th>
                    <th lay-data="{field:'status', width: 100, templet:'#statusText'}">@lang('goodcatch::pages.laravel_modules.module.list.status')</th>
                    <th lay-data="{field:'created_at'}">@lang('goodcatch::pages.laravel_modules.module.list.created_at')</th>
                    <th lay-data="{field:'updated_at'}">@lang('goodcatch::pages.laravel_modules.module.list.updated_at')</th>
                    <th lay-data="{width:200, templet:'#action'}">@lang('goodcatch::pages.laravel_modules.module.list.action')</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
<script type="text/html" id="id">
    <%# if(d.logs && d.logs.length > 0) { %>
    <a href="javascript:;" class="layui-table-link" style="font-weight:bold;"><% d.id %></a>
    <%# } else { %>
    <% d.id %>
    <%# } %>
</script>
<script type="text/html" id="action">
    <a href="<% d.editUrl %>" class="layui-table-link" title="@lang('goodcatch::pages.laravel_modules.module.form.btn.edit')"><i class="layui-icon layui-icon-edit"></i></a>
    <a href="javascript:;" class="layui-table-link" title="@lang('goodcatch::pages.laravel_modules.module.form.btn.delete')" style="margin-left: 15px" onclick="deleteSchedule ('<% d.deleteUrl %>')"><i class="layui-icon layui-icon-delete"></i></a>
</script>
<script type="text/html" id="typeText">
    <%# if(d.type === 1) { %>
    @lang('goodcatch::pages.laravel_modules.module.field.type_1')
    <%# } else if (d.type == 2) { %>
    @lang('goodcatch::pages.laravel_modules.module.field.type_2')
    <%# } else { %>
    --
    <%# } %>
</script>
<script type="text/html" id="statusText">
    <%# if(d.status === 1) { %>
    <span class="layui-badge layui-bg-green">@lang('goodcatch::pages.laravel_modules.module.field.status_enable')</span>
    <%# } else { %>
    <span class="layui-badge layui-bg-red">@lang('goodcatch::pages.laravel_modules.module.field.status_disable')</span>
    <%# } %>
</script>
@section('js')
    <script>
        var laytpl = layui.laytpl;
        laytpl.config ({
            open: '<%',
            close: '%>'
        });

        var laydate = layui.laydate;
        laydate.render ({
            elem: '#created_at',
            range: '~'
        });

        function deleteSchedule (url) {
            layer.confirm ('@lang('goodcatch::pages.laravel_modules.msg.removable')', function (index){
                $.ajax({
                    url: url,
                    data: {'_method': 'DELETE'},
                    success: function (result) {
                        if (result.code !== 0) {
                            layer.msg(result.msg, {shift: 6});
                            return false;
                        }
                        layer.msg (result.msg, {icon: 1}, function () {
                            if (result.reload) {
                                location.reload ();
                            }
                            if (result.redirect) {
                                location.href = '{!! url ()->previous () !!}';
                            }
                        });
                    }
                });

                layer.close (index);
            });
        }

        layui.use('table', function() {
            var table = layui.table;
            table.on('tool(table)', function(obj){

                var event = obj.event, tr = obj.tr;

                var maps = {
                    statusEvent: "status"
                };
                var key = maps[event];

                let data = Object.assign (obj.data, {id: obj.data.id, '_method': 'PUT'});

                data [key] = {
                    "status":tr.find("input[name='" + key + "']").prop('checked') ? {{ Goodcatch\Modules\Laravel\Model\Module::STATUS_ENABLE }} : {{ Goodcatch\Modules\Laravel\Model\Module::STATUS_DISABLE }}
                } [key];


                layer.load ();

                $.ajax({
                    url: '{{ route ('admin::' . module_route_prefix ('.goodcatch.') . 'module.update', ['id' => '_replace_id_']) }}'.replace('_replace_id_', obj.data.id),
                    method: 'put',
                    dataType: 'json',
                    data: data,
                    success: function (result) {
                        layer.closeAll('loading');
                        if (result.code !== 0) {
                            layer.msg(result.msg, {shift: 3});
                            return false;
                        }
                        layer.msg(result.msg, {icon: 1});
                        // location.reload();
                    },
                    error: function (err) {
                        layer.closeAll('loading');
                    }
                });

            });
            table.on('rowDouble(table)', function (obj) {
                var data = obj.data;

                window.location.href = data.editUrl;

            });
        });
    </script>
@endsection
