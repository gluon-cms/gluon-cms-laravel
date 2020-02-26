@extends('gluon.admin.layout')

@section('page-title', 'Detail')

@section('aside-content')
    <ul>
        <li>...</li>
    </ul>
@endsection

@section('main-content')
    {{ $entity->type }} : {{ $entity->id }}

@endsection