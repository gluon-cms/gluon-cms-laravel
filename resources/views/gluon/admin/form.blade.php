@extends('gluon.admin.layout')

@section('page-title', trans("gluon.${entityType}_singular") . " " . $entity->id)

@section('aside-content')
    
@endsection

@section('main-content')
    

    <form method="POST" action="{{ url('admin/handleForm/') }}" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="entity[id]" value="{{ $entity->id }}"/>
    <input type="hidden" name="entity[type]" value="{{ $entity->type }}"/>

    @foreach ($entity->getTypes() as $propertyName => $type)

        <div>
            @include('gluon.admin.form.form_' . $type, [
                'type' => $type,
                'value' => $entity->getValue($propertyName), 
                'entity' => $entity, 'propertyName' => $propertyName, 
                'constraints' => isset($entityConstraints["{$type}.{$propertyName}"]) ? $entityConstraints["{$type}.{$propertyName}"] : null
            ])
        </div>

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
    <p><input type="submit" name=""></p>
    </form>

    <p><a href="{{ url("admin/list", [$entityType]) }}">{{ trans("gluon.ui.action_list") }}</a></p>




@endsection