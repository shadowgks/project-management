<div class="card-body border-top p-9">
    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('app_logo') }}</label>

        <div class="col-lg-8">
            <div class="image-input image-input-outline {{ $values['app_logo'] != '' ? '' : 'image-input-empty' }}"
                data-kt-image-input="true"
                style="background-image: url({{ asset($base_data['theme_path'] . 'avatars/blank.png') }})">
                <div class="image-input-wrapper w-125px h-125px"
                    style="background-image: {{ $values['app_logo'] != '' ? 'url(' . asset($values['app_logo']) . ')' : 'none' }};">
                </div>

                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                    <i class="bi bi-pencil-fill fs-7"></i>
                    <input type="file" name="app_logo" accept=".png, .jpg, .jpeg" wire:model="values.app_logo" />
                </label>

                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>

                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>
            </div>

            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
        </div>
    </div>

    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('app_dark_logo') }}</label>

        <div class="col-lg-8">

            <div class="image-input image-input-outline {{ $values['app_dark_logo'] != '' ? '' : 'image-input-empty' }}"
                data-kt-image-input="true"
                style="background-image: url({{ asset($base_data['theme_path'] . 'avatars/blank.png') }})">
                <div class="image-input-wrapper w-125px h-125px"
                    style="background-image: {{ $values['app_dark_logo'] != '' ? 'url(' . asset($values['app_dark_logo']) . ')' : 'none' }};">
                </div>

                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                    <i class="bi bi-pencil-fill fs-7"></i>

                    <input type="file" name="app_dark_logo" accept=".png, .jpg, .jpeg"
                        wire:model="values.app_dark_logo" />
                </label>

                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>

                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>
            </div>

            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
        </div>
    </div>

    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('app_favicon') }}</label>

        <div class="col-lg-8">
            <div class="image-input image-input-outline {{ $values['app_favicon'] != '' ? '' : 'image-input-empty' }}"
                data-kt-image-input="true"
                style="background-image: url({{ asset($base_data['theme_path'] . 'avatars/blank.png') }})">
                <div class="image-input-wrapper w-125px h-125px"
                    style="background-image: {{ $values['app_favicon'] != '' ? 'url(' . asset($values['app_favicon']) . ')' : 'none' }};">
                </div>

                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                    <i class="bi bi-pencil-fill fs-7"></i>

                    <input type="file" name="app_favicon" accept=".png, .jpg, .jpeg"
                        wire:model="values.app_favicon" />
                </label>

                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>

                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>
            </div>

            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
        </div>
    </div>

    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('app_name') }}</label>

        <div class="col-lg-8 fv-row">
            <input type="text" name="app_name" class="form-control form-control-lg form-control-solid"
                placeholder="{{ __('app_name') }}" wire:model.lazy="values.app_name" />
        </div>
    </div>

    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">
            <span class="required">{{ __('app_theme') }}</span>

            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{ __('app_theme') }}"></i>
        </label>

        <div class="col-lg-8 fv-row">
            <select name="app_theme" aria-label="{{ __('select_a_theme') }}" data-control="select2"
                data-placeholder="{{ __('select_a_theme...') }}"
                class="form-select form-select-solid form-select-lg fw-bold" wire:model="values.theme">
                <option value="">{{ __('select_a_theme...') }}</option>
                @foreach ($base_data['themes'] as $theme)
                    <option value="{{ strtolower(str_replace(' ', '', $theme['title'])) }}">
                        {{ $theme['title'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">
            <span class="required">{{ __('Country') }}</span>

            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                title="{{ __('Country of origination') }}"></i>
        </label>

        <div class="col-lg-8 fv-row">
            <select name="country" aria-label="{{ __('Select a Country') }}"
                data-control="select2" data-placeholder="{{ __('Select a country...') }}"
                class="form-select form-select-solid form-select-lg fw-bold">
                <option value="">{{ __('Select a Country...') }}</option>
                @foreach (\App\Core\Data::getCountriesList() as $key => $value)
                    <option data-kt-flag="{{ $value['flag'] }}" value="{{ $key }}"
                        {{ $key === old('country', $info->country ?? '') ? 'selected' : '' }}>
                        {{ $value['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div> --}}

    <div class="row mb-6">
        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('language') }}</label>

        <div class="col-lg-8 fv-row">
            <select name="app_language" aria-label="{{ __('select_a_language') }}" data-control="select2"
                data-placeholder="{{ __('select_a_language...') }}"
                class="form-select form-select-solid form-select-lg" wire:model="values.app_language">
                <option value="">{{ __('select_a_language...') }}</option>
                @foreach ($base_data['languages'] as $key => $value)
                    <option data-kt-flag="{{ $value['country']['flag'] }}" value="{{ $key }}">
                        {{ $value['name'] }}</option>
                @endforeach
            </select>

            <div class="form-text">
                {{ __('Please select a preferred language, including date, time, and number formatting.') }}
            </div>
        </div>
    </div>

    <div class="row mb-6">
        <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Time Zone') }}</label>

        <div class="col-lg-8 fv-row">
            <select name="timezone" aria-label="{{ __('Select a Timezone') }}" data-control="select2"
                data-placeholder="{{ __('Select a timezone..') }}"
                class="form-select form-select-solid form-select-lg" wire:model="values.app_timezone">
                <option value="">{{ __('Select a Timezone..') }}</option>
                @foreach ($base_data['time_zones'] as $key => $value)
                    <option data-bs-offset="{{ $value['offset'] }}" value="{{ $key }}">
                        {{ $value['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-6">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Communication') }}</label>

        <div class="col-lg-8 fv-row">
            <div class="d-flex align-items-center mt-3">
                @foreach ($base_data['communications'] as $communication)
                    <label class="form-check form-check-inline form-check-solid me-5">
                        <input class="form-check-input" name="communication_email" type="checkbox"
                            value="{{ $communication['id'] }}" wire:model="values.communication" />
                        <span class="fw-bold ps-2 fs-6">
                            {{ __($communication['name']) }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row mb-0">
        <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Allow Marketing') }}</label>

        <div class="col-lg-8 d-flex align-items-center">
            <div class="form-check form-check-solid form-check-custom form-switch fv-row">
                <input class="form-check-input w-45px h-30px" type="checkbox" id="allowmarketing"
                    name="allow_marketing" wire:model="values.allow_marketing" />
                <label class="form-check-label" for="allowmarketing"></label>
            </div>
        </div>
    </div>
</div>
