@extends('front.layout')

@section('page-title', trans("app.hello.detail"))

@section('main-content')
<div>
    <h2>{{ trans("app.hello.detail") }} : {{ $entity->id }}</h2>

    <h3>{{ $entity->title }}</h3>
    <p>{{ $entity->content }}</p>

    <hello message-from-blade="{{ trans("app.hello.detail") }}" :data-from-blade='@json($entity)' />
</div>
@endsection
