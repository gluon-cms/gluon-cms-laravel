@extends('gluon.admin.layout')

@section('page-title', trans("gluon.${entityType}_singular") . " " . $entity->id)

@section('aside-content')
    
@endsection

@section('main-content')
    
    @foreach ($entity->getTypes() as $property => $type)
        <div>
            {{ $property }} ({{ $type }}) : 
            {{ $entity->getValue($property) }} --

            @json($entity->getValue($property), JSON_PRETTY_PRINT)
        </div>

    @endforeach

    <p><a href="{{ url("admin/list", [$entityType]) }}">{{ trans("gluon.ui.action_list") }}</a></p>




@endsection