@extends('admin.base')

@section('css')
    <style>
        .layui-layout-admin .layui-header {
            display:none;
        }
        .layui-layout-admin .layui-side {
            display:none;
        }
        .layui-layout-admin .layui-footer {
            display:none;
        }
        .layui-layout-admin .layui-body {
            top: 0;
            left: 0;
            bottom: 0;
        }
    </style>
@endsection
@section('content')
    <div class="layui-card">

        @php
            $user = \Auth::guard('admin')->user();
            $isSuperAdmin = in_array($user->id, config('light.superAdmin'));
        @endphp
        <div class="layui-card-body">
            @if(isset($mapping))
                <div class="layui-transfer-container {{ $mapping }}"></div>
            @else
                <div class="layui-field-box">未授权数据，请联系管理员</div>
            @endif
        </div>
    </div>
@endsection

@section('js')
    <script>

        var left = @json($left, JSON_PRETTY_PRINT);
        var right = @json($right, JSON_UNESCAPED_SLASHES);

        layui.use(['transfer', 'layer', 'util'], function() {
            var transfer = layui.transfer

            transfer.render({
                elem: '.layui-transfer-container.{{ $mapping }}'
                , data: left
                , value: right
                , title: ['未分配', '已分配']
                , showSearch: true
                , width: '42%'
                // , height: '100%'
                ,parseData: function(res){
                    return {
                        "value": res.id //数据值
                        ,"title": res.name //数据标题
                        // ,"disabled": res.disabled  //是否禁用
                        // ,"checked": res.checked //是否选中
                    }
                }
                , onchange: function (data, index) {
                    var method = ['POST', 'DELETE'] [index];
                    $.ajax({
                        url: @json($action)[method],
                        data: {
                            '_method': method,
                            'id': data.reduce ((arr, item) => {
                                arr.push (item ['value']);
                                return arr;
                            }, [])
                        },
                    });
                }
            });
        });

        var form = layui.form;



        //监听提交
        form.on('submit(formAdminUser)', function(data){
            window.form_submit = $('#submitBtn');
            form_submit.prop('disabled', true);
            $.ajax({
                url: data.form.action,
                data: data.field,
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
                            location.href = '{!! url()->previous() !!}';
                        }
                    });
                }
            });

            return false;
        });


    </script>
@endsection
