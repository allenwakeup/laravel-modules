@extends('admin.base')

@section('content')
    @include('admin.breadcrumb')

    <div class="layui-card">
        <div class="layui-form layui-card-header light-search" style="height: auto">
            <form>
                <input type="hidden" name="action" value="search">
            @include ('admin.searchField', ['data' => Goodcatch\Modules\Laravel\Model\SysModule::$searchField])
            <div class="layui-inline">
                <label class="layui-form-label">@lang('goodcatch::laravel_modules.module.search.created_at')</label>
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
            <table class="layui-table" lay-data="{url:'{{ route ('admin::' . module_route_prefix ('.goodcatch.') . 'module.list') }}?{{ request ()->getQueryString () }}', page:true, limit:50, id:'table', toolbar:'<div><a href=\'{{ route ('admin::' . module_route_prefix ('.goodcatch.') . 'module.create') }}\'><i class=\'layui-icon layui-icon-add-1\'></i>@lang('goodcatch::laravel_modules.module.form.btn.create')</a>'}" lay-filter="table">
                <thead>
                <tr>
                    <th lay-data="{field:'id', width:80, sort: true, event: 'detail', style:'cursor: pointer;', templet:'#id'}">ID</th>
                    @include ('admin.listHead', ['data' => Goodcatch\Modules\Laravel\Model\SysModule::$listField])
                    <th lay-data="{field:'created_at'}">@lang('goodcatch::laravel_modules.module.list.created_at')</th>
                    <th lay-data="{field:'updated_at'}">@lang('goodcatch::laravel_modules.module.list.updated_at')</th>
                    <th lay-data="{width:200, templet:'#action'}">@lang('goodcatch::laravel_modules.module.list.action')</th>
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
    <a href="<% d.editUrl %>" class="layui-table-link" title="@lang('goodcatch::laravel_modules.module.form.btn.edit')"><i class="layui-icon layui-icon-edit"></i></a>
    <a href="javascript:;" class="layui-table-link" title="@lang('goodcatch::laravel_modules.module.form.btn.delete')" style="margin-left: 15px" onclick="deleteSchedule ('<% d.deleteUrl %>')"><i class="layui-icon layui-icon-delete"></i></a>
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
            layer.confirm ('@lang('goodcatch::laravel_modules.msg.removable')', function (index){
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
                    "status":tr.find("input[name='" + key + "']").prop('checked') ? {{ Goodcatch\Modules\Laravel\Model\SysModule::STATUS_ENABLE }} : {{ Goodcatch\Modules\Laravel\Model\SysModule::STATUS_DISABLE }}
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
