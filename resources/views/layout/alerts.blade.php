@if(Session::has('Success_Message'))
    <script>
        var message = "{{ Session::get('Success_Message') }}";
        swal({
            title: "{{ __('views.success') }}",
            html: message,
            type: 'success',
            confirmButtonText: "{{ __('views.close') }}"
        })
    </script>
@elseif(Session::has('Error_Message'))
    <script>
        var message = "{{ Session::get('Error_Message') }}";
        swal({
            title: "{{ __('views.error') }}",
            html: message,
            type: 'error',
            confirmButtonText: "{{ __("views.close") }}"
        })
    </script>
@endif
@if(count($errors) > 0)
    <article class="message is-danger" id="error-container">
        <div class="message-header">
            <p>{{ __("views.error") }}</p>
            <button class="delete" aria-label="delete"></button>
        </div>
        <div class="message-body">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </article>
@endif
