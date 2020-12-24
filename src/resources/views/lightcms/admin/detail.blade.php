<div class="layui-card">
    <div class="layui-card-body">
@if (isset ($model))


        <table class="layui-table" lay-skin="line" lay-size="sm">

            <thead>
                <tr>
                    <th>属性</th>
                    <th>内容</th>
                </tr>
            </thead>
            <tbody>
            @foreach($model->toArray () as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ is_array ($value) ? json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $value }}</td>
                </tr>
            @endforeach



            </tbody>
        </table>

@else
    <p>没有更多数据...</p>

@endif

    </div>
</div>

