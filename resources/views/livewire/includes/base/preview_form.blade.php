{{-- preview_form - start --}}
<div class="modal black-background-transparent fade {{ $appOptions['modal']['show'] ? 'show' : '' }}" id="modal-view"
    tabindex="-1" role="dialog" style="display: {{ $appOptions['modal']['show'] ? 'block' : 'none' }}"
    wire:click="app_cancel_option">
    <div class="modal-dialog modal-lg" role="document" stop-propagation="true">
        <div class="modal-content">

            @if ($appOptions['modal']['current'] != 'upload_file')
                <div class="modal-header">
                    <h2>{{ $appOptions['modal']['current'] ?? '' }}</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1" wire:click="app_action_modal()">
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
            @endif

            <div class="modal-body">
                <div class="row m-0">
                    @if ($appOptions['modal']['current'] == 'reminders')
                        <div class="col-md-4 mb-2">
                            <label class="form-label">{{ __('User') }}</label>

                            <select class="form-select" wire:model="appValues.reminders.user">
                                <option value="">{{ __('Choose user') }}</option>
                                @foreach ($base_data['users'] as $user)
                                    <option value="{{ $user['id'] }}">
                                        {{ $user['first_name'] . ' ' . $user['last_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label class="form-label">{{ __('Date') }}</label>
                            <input type="date" class="form-control col-md-12"
                                wire:model="appValues.reminders.date" />
                        </div>

                        <label class="col-md-4 form-check form-switch form-check-custom form-check-solid mb-3">
                            <input class="form-check-input" type="checkbox" wire:model="appValues.reminders.by_email">
                            <span class="form-check-label fw-semibold text-muted">{{ __('By email') }}</span>
                        </label>

                        <textarea class="col-md-12 form-control form-control-lg form-control-solid" rows="7" placeholder="Reminder"
                            wire:model="appValues.reminders.value"></textarea>
                    @elseif ($appOptions['modal']['current'] == 'upload_file')
                        <livewire:input-file class="w-100" :_id="$appValues['upload_file']['id']" model="appValues.upload_file.files"
                            onchange="joinFiles" />
                    @elseif ($appOptions['modal']['current'] == 'comments')
                        <textarea class="col-md-12 form-control form-control-lg form-control-solid" rows="7"
                            placeholder="{{ __('Comment') }}" wire:model="appValues.comments.value"></textarea>
                    @endif
                </div>
            </div>

            @if ($appOptions['modal']['current'] != 'upload_file')
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="loadingVisibility(true)"
                        wire:click="app_cancel_option">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-success" onclick="loadingVisibility(true)"
                        wire:click="save_option">{{ __('Save') }}</button>
                </div>
            @endif
        </div>
    </div>
</div>
{{-- preview_form - end --}}
