@extends('layout.main')

@section('title', $title)

@section('content')
    @if($domains->isEmpty())
    @else
        @include('modals.record-edit')

        <div class="select" id="domain-select">
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label" for="select_domain">{{ __("views.domain") }}</label>
                </div>
                <div class="field-body">
                    <select id="select_domain">
                        @foreach($domains as $domain)
                            <option value="{{ $domain->id }}">{{ $domain->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <hr>

        @foreach($domains as $domain)
            <nav class="panel domain-panel domain-panel-{{ $domain->id }} {{ $loop->first ? 'is-active' : 'is-hidden' }}">
                <p class="panel-heading">{{ __("views.domain") }}: {{ $domain->name }}</p>
                <!-- TODO: Check for Domain specific records -->
                @if($records->isEmpty())
                    <div class="panel-block">
                        <article class="message is-warning">
                            <div class="message-header">
                                <p>{{ __("views.no_data_available_header") }}!</p>
                            </div>
                            <div class="message-body">
                                {{ __("views.no_data_available_body") }}!
                            </div>
                        </article>
                    </div>
                @elseif(empty($recordCount[$domain->id]))
                    <div class="panel-block">
                        <article class="message is-warning">
                            <div class="message-header">
                                <p>{{ __("views.no_records_available_header") }}!</p>
                            </div>
                            <div class="message-body">
                                {{ __("views.no_records_available_body") }}!<br />
                                <a href="{{ Route('records.add') }}?domain={{ $domain->id }}">{{ __("views.add_record") }}</a>
                            </div>
                        </article>
                    </div>
                @else
                    <div class="panel-block">
                        <table id="overviewTable-{{ $domain->id }}" class="table is-bordered is-striped is-hoverable is-fullwidth record-table">
                            <thead>
                            <tr>
                                <th>{{ __("views.name") }}</th>
                                <th>{{ __("views.type") }}</th>
                                <th>{{ __("views.content") }}</th>
                                <th>{{ __("views.ttl") }}</th>
                                <th>{{ __("views.edit") }}</th>
                                <th>{{ __("views.delete") }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                @if($record->domains_id == $domain->id)
                                    <tr>
                                        <td>{{ $record->name }}
                                        <td>{{ $record->type }}</td>
                                        <td>
                                            {{ \Illuminate\Support\Str::of($record->content)->limit(70) }}
                                            @if($record->type == "SRV")
                                            TTL: {{ explode(" ", $record->content)[0] }}
                                            Priority: {{ explode(" ", $record->content)[1] }}
                                            Port: {{ explode(" ", $record->content)[2] }}
                                            Ziel: {{ explode(" ", $record->content)[3] }}
                                            @endif
                                        </td>
                                        <td>{{ $record->ttl }}</td>
                                        <td align="center"><span class="edit-btn" data-edit="record" data-url="{{ Route("records.data.json", ["id" => $record->id]) }}"><i class="far fa-edit"></i></span></td>
                                        <td align="center">
                                            <form action="{{ Route('records.delete') }}" method="post">
                                                <input type="hidden" name="type" value="{{ $record->type }}">
                                                <input type="hidden" name="name" value="{{ $record->name }}">
                                                <input type="hidden" name="domain_name" value="{{ $domain->name }}">
                                                <input type="hidden" name="domain_id" value="{{ $domain->id }}">
                                                {{ csrf_field() }}
                                                <span class="delete-btn" aria-label="{{ __("views.delete_record") }}" data-microtip-position="top" data-name="{{ $record->name }}" data-delete="record" role="tooltip"><i class="fas fa-trash-alt"></i></span>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if(!empty($update[$domain->id]))
                    <div class="panel-block">
                        <p>{{ $update[$domain->id]["text"] }}</p>
                    </div>
                    <div class="panel-block">
                        <a class="button btn-refresh-records is-link" @if($update[$domain->id]["diff"]->i < env('RECORD_FETCH_LIMIT_MINUTES') and $update[$domain->id]["diff"]->h == 0) disabled aria-label="{{ __("views.update_disabled_text", ["minutes" => env('RECORD_FETCH_LIMIT_MINUTES')]) }}!" data-microtip-position="right" role="tooltip" @else href="{{ Route("fetch-records.get", ['domain' => $domain->name, 'id' => $domain->id]) }}" @endif><i class="fas fa-sync"></i>&nbsp;{{ __("views.update_records") }}</a>
                    </div>
                @else
                    <div class="panel-block">
                        <p>{{ __("views.last_update") }}: {{ __("views.never") }}</p>
                    </div>
                    <div class="panel-block">
                        <a class="button btn-refresh-records is-link" href="{{ Route("fetch-records.get", ['domain' => $domain->name, 'id' => $domain->id]) }}"><i class="fas fa-sync"></i>&nbsp;{{ __("views.update_records") }}</a>
                    </div>
                @endif
            </nav>
        @endforeach
    @endif
@endsection
