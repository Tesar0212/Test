@extends('layouts.app')

@section('content')
    <h2>Регистрация</h2>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="field">
            <label for="name">Имя</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="email">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
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
            <label for="password_confirmation">Подтверждение пароля</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn">Создать аккаунт</button>
    </form>
@endsection


