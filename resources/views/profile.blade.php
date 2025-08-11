@extends('layouts.app')

@section('head')
@endsection

@section('content')
<div id="app">
    <profile-page
        fetch-url="{{ route('profile.data') }}"
        save-url="{{ route('profile.update') }}"
        default-avatar-url="{{ asset('assets/images/profile-default.png') }}"
    ></profile-page>
</div>
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection


