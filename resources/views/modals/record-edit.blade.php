<div class="modal" id="recordEditModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title">{{ __("views.edit_record") }}</p>
            <button class="delete modal-closer" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
            <form action="{{ Route("records.edit") }}" method="post">
                <input type="hidden" name="record_id" id="edit_record_id">
                <input type="hidden" name="hash" id="record-hash">

                <div class="field">
                    <label for="edit_name">{{ __("views.name") }}</label>
                    <div class="control">
                        <input type="text" name="name" id="edit_name" class="input" disabled>
                    </div>
                </div>

                <div class="field">
                    <label for="edit_type">{{ __("views.type") }}</label>
                    <div class="control">
                        <input type="text" name="type" id="edit_type" class="input" disabled>
                    </div>
                </div>

                <div class="field">
                    <label for="edit_content">{{ __("views.content") }}</label>
                    <div class="control">
                        <input type="text" name="content" id="edit_content" class="input">
                    </div>
                </div>

                <div class="field">
                    <label for="edit_ttl">{{ __("views.ttl") }}</label>
                    <div class="control">
                        <input type="number" name="ttl" id="edit_ttl" class="input">
                    </div>
                </div>

                {{ csrf_field() }}

                <div class="field">
                    <div class="control">
                        <button class="button is-link">{{ __("views.save") }}</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
