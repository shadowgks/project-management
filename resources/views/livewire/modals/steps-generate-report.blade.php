@php
    $listing_tables = $listing['base_data']['tables'];
    $length_columns = count($listing['base_data']['columns']);
@endphp

<div class="modal black-background-transparent fade {{ $listing['options']['show_steps_modal'] ? 'show' : '' }}"
    tabindex="-1" style="display: {{ $listing['options']['show_steps_modal'] ? 'block' : 'none' }};" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ __('Create List') }}</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary"
                    wire:click="action_modal('hide', 'show_steps_modal')">
                    <span class="svg-icon svg-icon-1">
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

            <div class="modal-body py-lg-10 px-lg-10">
                @include('livewire.module-includes.listing')
            </div>
        </div>
    </div>
</div>
