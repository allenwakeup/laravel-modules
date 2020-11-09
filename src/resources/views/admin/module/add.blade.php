@extends('admin.base')

@section('content')
    <div class="layui-card">

        @include('admin.breadcrumb')

        <div class="layui-card-body">
            <form class="layui-form" lay-filter="form" action="@if (isset ($id)){{ route ('admin::' . module_route_prefix ('.goodcatch.') . 'module.update', ['id' => $id]) }}@else{{ route ('admin::' . module_route_prefix ('.goodcatch.') . 'module.save') }}@endif" method="post">
                @if(isset($id)) {{ method_field('PUT') }} @endif
                <div class="layui-form-item">
                    <label class="layui-form-label">@lang('goodcatch::laravel_modules.module.field.name')</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" required lay-verify="required" autocomplete="off" class="layui-input" value="{{ $model->name ?? ''  }}">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">@lang('goodcatch::laravel_modules.module.field.description')</label>
                    <div class="layui-input-block">
                        <textarea name="description" autocomplete="off" class="layui-textarea">{{ $model->description ?? ''  }}</textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">@lang('goodcatch::laravel_modules.module.field.status')</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="status" lay-skin="switch" lay-text="@lang('goodcatch::laravel_modules.module.field.status_enable')|@lang('goodcatch::laravel_modules.module.field.status_disable')" value="{{ Goodcatch\Modules\Laravel\Model\SysModule::STATUS_ENABLE }}" @if(isset($model) && $model->status == Goodcatch\Modules\Laravel\Model\SysModule::STATUS_ENABLE) checked @endif>
                        </div>
                    </div>

                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formSchedule" id="submitBtn">@lang('goodcatch::laravel_modules.module.form.btn.submit')</button>
                        <button type="reset" class="layui-btn layui-btn-primary">@lang('goodcatch::laravel_modules.module.form.btn.reset')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var form = layui.form;

        //监听提交
        form.on ('submit(formSchedule)', function (data){
            window.form_submit = $ ('#submitBtn');
            form_submit.prop ('disabled', true);

            $.ajax ({
                url: data.form.action,
                data: data.field,
                success: function (result) {
                    if (result.code !== 0) {
                        form_submit.prop ('disabled', false);
                        layer.msg (result.msg, {shift: 6});
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

            return false;
        });

    </script>
@endsection
