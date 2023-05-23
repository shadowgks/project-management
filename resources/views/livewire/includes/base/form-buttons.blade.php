{{-- <div class="row m-0 position-relative"> --}}
<div class="card card-sticky mt-6 sticky-steps-buttons {!! $options['show_form'] ? '' : 'hidden' !!}">
    <div class="card-body">
        <div class="d-flex flex-row justify-content-between">
            <button type="button" class="btn btn-danger btn-sm btn-shadow me-1" onclick="loadingVisibility(true)"
                wire:click="cancel('show_form')">{{ __('Cancel') }}</button>
            <button type="button" class="btn btn-success btn-sm btn-shadow" onclick="loadingVisibility(true)"
                wire:click="save">{{ __('Save') }}</button>
        </div>
    </div>
</div>
{{-- </div> --}}
