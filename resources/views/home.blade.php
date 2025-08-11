@extends('layouts.app')

@section('content')
    <h2>Главная</h2>
    <p>Вы вошли как <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }}).</p>
@endsection


