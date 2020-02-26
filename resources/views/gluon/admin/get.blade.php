@extends('gluon.admin.layout')

@section('page-title', trans("gluon.${entityType}_singular") . " " . $entity->id)

@section('aside-content')
    
@endsection

@section('main-content')
    
    @foreach ($entity->getTypes() as $propertyName => $type)
        <div>
            @include('gluon.admin.form.form_' . $type, ['value' => $entity->getValue($propertyName), 'entity' => $entity, 'propertyName' => $propertyName, 'type' => $type])
        </div>

    @endforeach

    <p><a href="{{ url("admin/list", [$entityType]) }}">{{ trans("gluon.ui.action_list") }}</a></p>




@endsection