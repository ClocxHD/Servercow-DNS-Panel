@extends('layout.main')

@section('title', $title)

@section('content')
    <form action="{{ Route("records.add") }}" method="post" id="form-add-record">
        <div class="field">
            <label for="domain" class="label">{{ __("views.domain") }}</label>
            <div class="control">
                <div class="select">
                    <select name="domain" id="domain">
                        @foreach($domains as $domain)
                            <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <input type="hidden" name="hash" id="record-hash">

        <div class="field">
            <label for="type" class="label">{{ __("views.type") }}</label>
            <div class="control">
                <div class="select">
                    <select name="type" id="type">
                        <option value="a">A</option>
                        <option value="aaaa">AAAA</option>
                        <option value="cname">CNAME</option>
                        <option value="mx">MX</option>
                        <option value="txt">TXT</option>
                        <option value="tlsa">TLSA</option>
                        <option value="caa">CAA</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label for="name" class="label">{{ __("views.name") }}</label>
            <div class="control">
                <input type="text" name="name" id="name" class="input" placeholder="{{ __('views.name') }}">
            </div>
        </div>

        <div class="field">
            <label for="content" class="label">{{ __("views.content") }}</label>
            <div class="control">
                <input type="text" name="content" id="content" class="input" placeholder="{{ __('views.content') }}" required>
            </div>
        </div>

        <div class="field">
            <label for="ttl" class="label">{{ __("views.ttl") }}</label>
            <div class="control">
                <input type="number" value="20" name="ttl" id="ttl" class="input" placeholder="{{ __('views.ttl') }}" required>
            </div>
        </div>

        {{ csrf_field() }}

        <div class="field">
            <div class="control">
                <button class="button is-link">{{ __("views.save") }}</button>
            </div>
        </div>
    </form>
@endsection
