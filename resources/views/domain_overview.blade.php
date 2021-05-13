@extends('layout.main')

@section('title', $title)

@section('content')
    <div class="card">
        <div class="card-header">
            <p class="card-header-title">{{ __("views.add_domain") }}</p>
        </div>
        <div class="card-content">
            <form action="{{ Route("domains.add") }}" method="post">
                <div class="field">
                    <label for="name" class="label">{{ __("views.name") }}</label>
                    <div class="control">
                        <input type="text" name="name" id="name" class="input" placeholder="{{ __('views.name') }}" autofocus required>
                    </div>
                </div>

                {{ csrf_field() }}

                <div class="field">
                    <div class="control">
                        <button class="button is-link">{{ __("views.save") }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr>

    @if($domains->isEmpty())
        <article class="message is-warning">
            <div class="message-header">
                <p>{{ __("views.no_domains_text_header") }}!</p>
            </div>
            <div class="message-body">
                {{ __("views.no_domains_text_body") }}!
            </div>
        </article>
    @else
        Domains: {{ $domains->count() }}

        <table class="table is-bordered is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>{{ __("views.domain") }}</th>
                    <th>{{ __("views.delete") }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($domains as $domain)
                    <tr>
                        <td>{{ $domain->name }}</td>
                        <td>
                            <form action="{{ Route("domains.delete") }}" method="post">
                                <input type="hidden" name="domain_name" value="{{ $domain->name }}">
                                <input type="hidden" name="domain_id" value="{{ $domain->id }}">
                                {{ csrf_field() }}
                                <span class="delete-btn" aria-label="{{ __("views.delete_domain") }}" data-microtip-position="top" data-name="{{ $domain->name }}" data-delete="domain" role="tooltip"><i class="fas fa-trash-alt"></i></span>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
