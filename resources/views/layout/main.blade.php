<!doctype html>
<html lang="{{ \App\Http\Controllers\LanguageController::getActiveLanguage() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>

    <script src="https://cdn.jsdelivr.net/sweetalert2/1.3.2/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="page-{{ strtolower(str_replace(" ", "_", $title)) }}">
    <section id="section-navbar">
        <div class="container">@include('layout.nav')</div>
    </section>

    <section class="section">
        <div class="container">
            @include('layout.alerts')

            <h1 class="title">@yield('title')</h1>
            @yield('content')
        </div>
    </section>

    <script defer src="{{ URL::asset("js/libs/fontawesome-5.14.0.js") }}"></script>
    <script src="{{ URL::asset("js/libs/moment.min.js") }}"></script>
    <script src="{{ URL::asset("js/libs/jquery-3.5.1.min.js") }}"></script>
    <script src="{{ URL::asset("js/libs/jquery.dataTables-1.10.23.min.js") }}"></script>
    <script src="{{ URL::asset("js/libs/dataTables.bulma-1.10.23.min.js") }}"></script>
    <script>
        let swalDeleteRecordTitle = "{{ __("views.delete_record") }}";
        let swalDeleteDomainTitle = "{{ __("views.delete_domain") }}"
        let swalDeleteRecordText1 = "{{ __("views.swal_delete_record_sure_1") }}";
        let swalDeleteRecordText2 = "{{ __("views.swal_delete_record_sure_2") }}";
        let swalDeleteRecordYes = "{{ __("views.swal_delete_record_yes") }}";
        let swalDeleteDomainText1 = "{{ __("views.swal_delete_domain_sure_1") }}";
        let swalDeleteDomainText2 = "{{ __("views.swal_delete_domain_sure_2") }}";
        let swalDeleteDomainYes = "{{ __("views.swal_delete_domain_yes") }}";
        let cancel = "{{ __("views.cancel") }}";
    </script>
    <script src="{{ URL::asset("js/main.js") }}"></script>
</body>
</html>
