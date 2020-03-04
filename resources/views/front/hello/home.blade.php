@extends('front.layout')

@section('page-title', trans("app.hello.title"))

@section('main-content')
<div>
    <h2>{{ trans("app.hello.title") }}</h2>

    <ul>
        @foreach($entityList as $entity)
        <li><a href="{{ route('hello.detail', ['id'=>$entity->id, 'slug'=> 'abcd', 'locale' => App::getLocale() ])}}">{{ $entity }}</a></li>
        @endforeach
    </ul>

    <hello message-from-blade="{{ trans("app.hello.title") }}" :data-from-blade='@json(["key"=>"value"])' />
</div>
@endsection
