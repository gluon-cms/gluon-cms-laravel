@extends('gluon.admin.layout')

@if ($entity)
@section('main-title', trans("gluon.${entityType}_singular") . " : " . $entity->id . " - " . $entity )
@else
@section('main-title', trans("gluon.${entityType}_singular"))
@endif

@section('aside-content')
    @include('gluon.admin.modules.entityTypeList', ['entityTypeList' => $entityTypeList, 'settings' => $settings, 'entityType' => $entityType])
@endsection

@section('main-content')
    
    
    <form method="POST" action="{{ url('admin/handleForm/') }}" enctype="multipart/form-data" class="standardForm">
    @csrf

    <input type="hidden" name="entity[id]" value="{{ $entity->id }}"/>
    <input type="hidden" name="entity[type]" value="{{ $entity->type }}"/>

    @foreach ($entityDefinition as $parameter)

        @include('gluon.admin.form.form_' . $parameter['type'], [
            'type' => $parameter['type'],
            'key' => $parameter['key'], 
            'value' => $entity->getValue($parameter['key']), 
            'entity' => $entity, 
            'constraints' => isset($entityConstraints[ $parameter['property'] ]) ? $entityConstraints[ $parameter['property'] ] : null
        ])

    @endforeach

    <!--
    <input type="file" name="entity[1][file][imagefile]">
    <input type="file" name="testimage">
    

    <input type="file" name="entity[file.azerty][file]" />
    <input type="checkbox" name="entity[file.azerty][greyscale]" />
    <input type="file" name="entity[file.azerty][whateverfile]" />
    <input type="checkbox" name="entity[file.azerty][super]" />

    <input type="file" name="entity[file.querty][super]" />
-->
    @include('gluon.admin.form.form_submit')
    </form>

    <p class="actionMenu"><a class="standardLink" href="{{ url("admin/list", [$entityType]) }}">{{ trans("gluon.ui.action_list") }}</a></p>




@endsection