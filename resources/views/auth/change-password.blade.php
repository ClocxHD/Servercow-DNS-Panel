@extends('layout.main')

@section('title', $title)

@section('content')
    <form action="{{ Route("auth-password-change.post") }}" method="post">
        <div class="field">
            <label for="old_password" class="label">{{ __("views.old_password") }}</label>
            <div class="control">
                <input type="password" name="old_password" id="old_password" class="input" placeholder="{{ __("views.old_password") }}" required>
            </div>
        </div>

        <div class="field">
            <label for="new_password" class="label">{{ __("views.new_password") }}</label>
            <div class="control">
                <input type="password" name="new_password" id="new_password" class="input" placeholder="{{ __("views.new_password") }}" required>
            </div>
        </div>

        {{ csrf_field() }}

        <div class="field">
            <div class="control">
                <button class="button is-link">{{ __("views.change_password") }}</button>
            </div>
        </div>
    </form>
@endsection
