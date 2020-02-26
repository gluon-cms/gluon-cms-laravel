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
            <th>{{ trans("gluon.entity_type") }}</th>

            @foreach ($firstEntity->getTypes() as $parameter => $parameterType)
                <th>
                    <span class="parameter">{{ trans("gluon.parameter_$parameter") }}</span>
                    <span class="parameterType">{{ trans("gluon.parameter_type_$parameterType") }}</span>
                </th>
            @endforeach

            <th>{{ trans("gluon.ui.actions") }}</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($entityList as $entity)

            <tr>
                <td>{{ $entity->id }}</td>
                <td>{{ $entity->type }}</td>

                @foreach ($entity->getTypes() as $property => $type)
                    <td>{{ $entity->getValue($property) }}</td>
                @endforeach

                <td><a href="{{ url("admin/get", [$entity->id]) }}">{{ trans("gluon.ui.action_details") }}</a></td>
            </tr>  
        @endforeach
        </tbody>

    </table>

    

@endsection