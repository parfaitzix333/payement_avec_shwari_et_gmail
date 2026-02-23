@extends('base.base_libre')
@section('content')
    <div id="container alert alert-light">
        <h1>Nom d'utilisateur: {{ $user->name }}</h1>
        <h1>ID: {{ $user->id }}</h1>
    </div>
@endsection