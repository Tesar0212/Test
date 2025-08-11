@extends('layouts.app')

@section('content')
    <h2>Вход</h2>

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <div class="field">
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="password">Пароль</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="remember">
                Запомнить меня
            </label>
        </div>

        <button type="submit" class="btn">Войти</button>
    </form>
@endsection


