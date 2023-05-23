@php
    use App\Helpers\ModelHelper;
    use App\Helpers\TemplateHelper;
@endphp

<div class="w-100">
    <div class="d-flex flex-row justify-content-end my-3">
        <button type="button" class="btn btn-info btn-sm btn-shadow btn-icon"
            wire:click="action_options('show_modal_backups')">
            <i class="fa fa-window-restore p-0"></i>
        </button>
    </div>
    <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
            <span class="required">{{ __('Module Name') }}</span>
        </label>
        <input type="text" class="form-control form-control-lg form-control-solid" name="name"
            placeholder="{{ __('Module Name') }}" wire:model.lazy="values.module.name">
        <div class="fs-7 fw-semibold text-muted">The module name must be plural with s at the end</div>
        {!! TemplateHelper::getFormMessage($options['errors']['module_name']) !!}
    </div>

    <div class="col-md-12 fv-row mb-10 fv-plugins-icon-container">
        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
            <span>{{ __('Description') }}</span>
        </label>
        <textarea class="form-control form-control-lg form-control-solid" rows="7" name="description"
            wire:model.lazy="values.module.description"></textarea>
    </div>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.module.empty_when_reinitializating">
        <span class="form-check-label fw-semibold text-muted">{{ __('Empty when reinitializating') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.module.contain_validator">
        <span class="form-check-label fw-semibold text-muted">{{ __('Contain validator') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.module.emailing">
        <span class="form-check-label fw-semibold text-muted">{{ __('Emailing') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.module.notifications">
        <span class="form-check-label fw-semibold text-muted">{{ __('Notifications') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.module.pdf">
        <span class="form-check-label fw-semibold text-muted">{{ __('PDF') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.module.contain_importation">
        <span class="form-check-label fw-semibold text-muted">{{ __('Contain importation') }}</span>
    </label>

    <div class="col-md-4 mb-10 fv-plugins-icon-container">
        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
            <span>{{ __('Module Gate') }}</span>
        </label>
        <select class="form-select form-control-lg form-control-solid" wire:model="values.module.gate">
            <option disabled value="">{{ __('Choose type') }}</option>
            @foreach ($base_data['gates'] as $gate)
                <option value="{{ $gate['id'] }}">{{ __($gate['name']) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="modal black-background-transparent fade {{ $options['show_modal_backups'] ? 'show' : '' }}"
        id="modal-view" tabindex="-1" role="dialog"
        style="display: {{ $options['show_modal_backups'] ? 'block' : 'none' }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ __('Backups') }}</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1" wire:click="action_options('show_modal_backups')">
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
                        {{-- form --}}
                        <div class="col-md-12 mb-2">
                            <label for="backup-files" class="form-label">{{ __('Files') }}</label>

                            <select name="backup-files" class="form-select" id="backup-files"
                                wire:model="options.selected_backup_file">
                                <option value="">{{ __('Choose file') }}</option>
                                @foreach ($base_data['backups'] as $file)
                                    <option value="{{ $file }}">{{ $file }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        wire:click="cancelBackup">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-success"
                        wire:click="getBackup">{{ __('Get Backup') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
