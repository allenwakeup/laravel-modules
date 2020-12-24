<script>
    function addSelectLoadEvent(func) {
        var oldonload = window.onload;
        if (typeof window.onload != 'function') {
            window.onload = func;
        } else {
            window.onload = function () {
                oldonload();
                func();
            }
        }
    }
</script>

@if(sizeof ($select_data) > 3)
    <select name="{{$select_name}}" @if(isset ($select_required)) lay-verify="required" @endif  @if(isset ($disabled)) disabled @endif lay-filter="select_{{$select_name}}">
        @foreach($select_data as $v)
            <option value="{{ $v['id'] }}" @isset($model) @if($v['id'] == Illuminate\Support\Arr::get ($model, $select_name, '')) selected @endif @endisset>{{ $v['name'] }}</option>
        @endforeach
    </select>
    <script>
        addSelectLoadEvent(function () {
            if (typeof onSelect{{\Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::camel ($select_name))}} === 'function')
            {
                layui.form.on ('select(select_{{$select_name}})', onSelect{{\Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::camel ($select_name))}});
            }
        });
    </script>
@else

    @foreach($select_data as $idx => $v)
        <input type="radio"
               @if(isset($model))
               @if($v['id'] == Illuminate\Support\Arr::get ($model, $select_name, '')) checked @endif
               @elseif(isset($select_required))
               @if($idx == 0) checked @endif
               @else

               @endif @if(isset ($disabled)) disabled @endif name="{{$select_name}}" value="{{ $v['id'] }}" title="{{$v['name']}}" lay-filter="select_{{$select_name}}">
    @endforeach
    <script>
        addSelectLoadEvent(function () {
            if (typeof onSelect{{\Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::camel ($select_name))}} === 'function')
            {
                layui.form.on ('radio(select_{{$select_name}})', onSelect{{\Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::camel ($select_name))}});
            }
        });
    </script>
@endif
