@extends('admin.base')
@section('css')
    <style>
        .layui-layout-admin .layui-side {
            display:none;
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
    <div class="layui-card">

        @include('admin.breadcrumb')

        <div class="layui-card-body">
            <form class="layui-form" lay-filter="form" action="@if (isset ($id)){{ route ('admin::' . module_route_prefix ('.goodcatch.') . 'module.update', ['id' => $id]) }}@else{{ route ('admin::' . module_route_prefix ('.goodcatch.') . 'module.save') }}@endif" method="post">
                @if(isset($id)) {{ method_field('PUT') }} @endif
                <div class="layui-form-item">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.name')</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" required lay-verify="required" autocomplete="off" class="layui-input" value="{{ $model->name ?? ''  }}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.alias')</label>
                    <div class="layui-input-block">
                        <input type="text" name="alias" required lay-verify="required" autocomplete="off" class="layui-input" value="{{ $model->alias ?? ''  }}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.description')</label>
                    <div class="layui-input-block">
                        <textarea name="description" autocomplete="off" class="layui-textarea">{{ $model->description ?? ''  }}</textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.priority')</label>
                    <div class="layui-input-block">
                        <input type="number" name="priority" required lay-verify="required" autocomplete="off" class="layui-input" value="{{ $model->priority ?? 0  }}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.version')</label>
                    <div class="layui-input-block">
                        <input type="text" name="version" autocomplete="off" placeholder="0.1.0" class="layui-input" value="{{ $model->version ?? ''  }}">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.path')</label>
                    <div class="layui-input-block">
                        <input type="text" name="path" autocomplete="off" class="layui-input" value="{{ $model->path ?? ''  }}">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.type')</label>
                    <div class="layui-input-block">
                        <select name="type" lay-verify="required" lay-filter="select_type">
                            @foreach([
    Goodcatch\Modules\Laravel\Model\Module::TYPE_SYSTEM,
    Goodcatch\Modules\Laravel\Model\Module::TYPE_EXTEND,
] as $v)
                                <option value="{{ $v }}" @isset($model) @if($v == $model->type) selected @endif @endisset>@lang('goodcatch::pages.laravel_modules.module.field.type_' . $v)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.sort')</label>
                    <div class="layui-input-block">
                        <input type="number" name="sort" autocomplete="off" class="layui-input" value="{{ $model->sort ?? 0  }}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">@lang('goodcatch::pages.laravel_modules.module.field.status')</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="status" lay-skin="switch" lay-text="@lang('goodcatch::pages.laravel_modules.module.field.status_enable')|@lang('goodcatch::pages.laravel_modules.module.field.status_disable')" value="{{ Goodcatch\Modules\Laravel\Model\Module::STATUS_ENABLE }}" @if(isset($model) && $model->status == Goodcatch\Modules\Laravel\Model\Module::STATUS_ENABLE) checked @endif>
                        </div>
                    </div>

                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formSchedule" id="submitBtn">@lang('goodcatch::pages.laravel_modules.module.form.btn.submit')</button>
                        <button type="reset" class="layui-btn layui-btn-primary">@lang('goodcatch::pages.laravel_modules.module.form.btn.reset')</button>
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

            data.field.status = data.field.status || {{Goodcatch\Modules\Laravel\Model\Module::STATUS_DISABLE}};

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
