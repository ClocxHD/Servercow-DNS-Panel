@extends('layout.main')

@section('title', $title)

@section('content')
    <form action="{{ Route("auth-login.post") }}" method="post">
        <div class="field">
            <label for="username" class="label">{{ __("views.username") }}</label>
            <div class="control">
                <input type="text" name="username" id="username" class="input" placeholder="{{ __("views.username") }}" value="{{ Request::old('username') }}" required>
            </div>
        </div>

        <div class="field">
            <label for="password" class="label">{{ __("views.password") }}</label>
            <div class="control">
                <input type="password" name="password" id="password" class="input" placeholder="{{ __("views.password") }}" required>
            </div>
        </div>

        <div class="field">
            <label class="checkbox">
                <input type="checkbox" name="remember"> {{ __("views.remember_me") }}
            </label>
        </div>

        {{ csrf_field() }}

        <div class="field">
            <div class="control">
                <button class="button is-link">{{ __("views.login") }}</button>
            </div>
        </div>
    </form>
@endsection
