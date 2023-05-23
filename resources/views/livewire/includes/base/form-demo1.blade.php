@php
    use App\Helpers\TemplateHelper;
@endphp

@if ($base_data['permissions']['create'] || $base_data['permissions']['update'])
    <div class="modal black-background-transparent fade {{ $options['show_modal'] ? 'show' : '' }}" id="modal-view"
        tabindex="-1" role="dialog" style="display: {{ $options['show_modal'] ? 'block' : 'none' }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ $options['id'] == null ? 'New' : 'Edit' }} Form</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1" wire:click="action_options('show_modal')">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                    rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row m-0">
                        {{-- form - start --}}
                        {{-- form - end --}}
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="loadingVisibility(true)"
                        wire:click="cancel">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-success" onclick="loadingVisibility(true)"
                        wire:click="save">{{ __('Save') }}</button>
                </div>
            </div>
        </div>
    </div>
@endif
