@extends('gluon.admin.layout')

@section('page-title', "$type / List")

@section('aside-content')
    <ul>
        @foreach ($typeList as $type)
        <li><a href="{{ url("admin/list", [$type]) }}">{{ $type }}</a></li>
        @endforeach
    </ul>
@endsection

@section('main-content')

    <table>

        <tr>
            <td>id</td>
            <td>type</td>

            @foreach ($firstEntity->getTypes() as $property => $type)
                <td>{{ $property }} ({{ $type }})</td>
            @endforeach


            <td>actions</td>
        </tr>

        @foreach ($entities as $entity)

            <tr>
                <td>{{ $entity->id }}</td>
                <td>{{ $entity->type }}</td>

                @foreach ($entity->getTypes() as $property => $type)
                    <td>{{ $entity->getValue($property) }}</td>
                @endforeach

                <td><a href="{{ url("admin/get", [$entity->id]) }}">détails</a></td>
            </tr>  
        @endforeach


    </table>

@endsection