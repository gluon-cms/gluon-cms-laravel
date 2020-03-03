@extends('gluon.admin.layout')

@section('page-title', trans("gluon.${entityType}_plural"))

@section('aside-content')
    <ul class="entityTypeList">
        @foreach ($entityTypeList as $type)
        <li class="entityTypeList__entity $type"><a href="{{ url("admin/list", [$type]) }}">{{ trans("gluon.${type}_plural") }}</a></li>
        @endforeach
    </ul>
@endsection

@section('main-content')

    <table class="entityList">


        <thead>
        <tr>
            <th>{{ trans("gluon.entity_id") }}</th>
            
            @foreach ($entityDefinition as $parameter)
                <th>
                    <span class="parameter">{{ trans("gluon.parameter_{$parameter['key']}") }}</span><br>
                    <span class="parameterType">{{ trans("gluon.parameter_type_{$parameter['type']}") }}</span>
                </th>
            @endforeach

            <th>{{ trans("gluon.ui.actions") }}</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($entityList as $entity)

            <tr>
                <td>{{ $entity->id }}</td>

                @foreach ($entityDefinition as $parameter)
                    @php($value = $entity->getValue($parameter['key']))
                    @php($max = 3) 

                    @if(is_array($value))
                    <td>
                        <ul>
                        @foreach (array_slice($value, 0, $max) as $item)
                            <li class="item">{{ $item }}</li>
                        @endforeach

                        @if(count($value) > $max)
                        <li class="item">and {{ count($value) - $max }} more</li>
                        @endif


                        </ul>
                    </td>

                    @elseif(! "$value")
                    <td><span class="noValue">{{ trans("gluon.ui.noValue") }}</span></td>
                    
                    @else
                    <td>{{ $value }}</td>

                    @endif

                @endforeach

                <td><a href="{{ url("admin/edit", [$entity->type, $entity->id]) }}">{{ trans("gluon.ui.action_edit") }}</a></td>
            </tr>  
        @endforeach
        </tbody>

    </table>

    <p><a href="{{ url("admin/create", [$entityType]) }}">{{ trans("gluon.ui.action_create") }}</a></p>

@endsection