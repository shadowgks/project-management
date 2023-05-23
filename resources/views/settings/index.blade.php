@php
    use App\Helpers\SettingsHelper;
@endphp
<x-base-layout>
    <div class="row me-0">
        {{-- <x-settingsHeader /> --}}
    </div>
    <div class="row">
        <div class="col-md-3">
            {{-- <x-settingsSideMenu /> --}}
        </div>

        <div class="col-md-9">
            <!--begin::Col-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                    data-bs-target="#kt_account_profile_details" aria-expanded="true"
                    aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">{{ __('general_settings') }}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->

                <!--begin::Content-->
                <div id="kt_account_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form id="kt_account_profile_details_form" class="form" method="POST"
                        action="{{ route('settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Input group-->
                            <!--Logo-->
                            @php
                                $app_logo = SettingsHelper::get_settings('app_logo');
                            @endphp
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __($app_logo->key) }}</label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-outline {{ isset($app_logo) && $app_logo->value ? '' : 'image-input-empty' }}"
                                        data-kt-image-input="true"
                                        style="background-image: url({{ asset(theme()->getMediaUrlPath() . 'avatars/blank.png') }})">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-125px h-125px"
                                            style="background-image: {{ isset($app_logo) && $app_logo->value ? 'url(' . asset($app_logo) . ')' : 'none' }};">
                                        </div>
                                        <!--end::Preview existing avatar-->

                                        <!--begin::Label-->
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Change avatar">
                                            <i class="bi bi-pencil-fill fs-7"></i>

                                            <!--begin::Inputs-->
                                            <input type="file" name="{{ $app_logo->key }}"
                                                accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Cancel-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            title="Cancel avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Cancel-->

                                        <!--begin::Remove-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->

                                    <!--begin::Hint-->
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                    <!--end::Hint-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <!--Dark Logo-->
                            @php
                                $app_dark_logo = SettingsHelper::get_settings('app_dark_logo');
                            @endphp
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label
                                    class="col-lg-4 col-form-label fw-bold fs-6">{{ __($app_dark_logo->key) }}</label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <div class="col-lg-8">

                                    <!--begin::Image input-->
                                    <div class="image-input image-input-outline {{ isset($app_dark_logo) && $app_dark_logo->value ? '' : 'image-input-empty' }}"
                                        data-kt-image-input="true"
                                        style="background-image: url({{ asset(theme()->getMediaUrlPath() . 'avatars/blank.png') }})">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-125px h-125px"
                                            style="background-image: {{ isset($app_dark_logo) && $app_dark_logo->value ? 'url(' . asset($app_dark_logo->value) . ')' : 'none' }};">
                                        </div>
                                        <!--end::Preview existing avatar-->

                                        <!--begin::Label-->
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Change avatar">
                                            <i class="bi bi-pencil-fill fs-7"></i>

                                            <!--begin::Inputs-->
                                            <input type="file" name="{{ $app_dark_logo->key }}"
                                                accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Cancel-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            title="Cancel avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Cancel-->

                                        <!--begin::Remove-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->

                                    <!--begin::Hint-->
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                    <!--end::Hint-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <!--Favicon-->
                            @php
                                $app_favicon = SettingsHelper::get_settings('app_favicon');
                            @endphp
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __($app_favicon->key) }}</label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-outline {{ isset($app_favicon) && $app_favicon->value ? '' : 'image-input-empty' }}"
                                        data-kt-image-input="true"
                                        style="background-image: url({{ asset(theme()->getMediaUrlPath() . 'avatars/blank.png') }})">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-125px h-125px"
                                            style="background-image: {{ isset($app_favicon) && $app_favicon->value ? 'url(' . asset($app_favicon->value) . ')' : 'none' }};">
                                        </div>
                                        <!--end::Preview existing avatar-->

                                        <!--begin::Label-->
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="Change avatar">
                                            <i class="bi bi-pencil-fill fs-7"></i>

                                            <!--begin::Inputs-->
                                            <input type="file" name="{{ $app_favicon->key }}"
                                                accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Label-->

                                        <!--begin::Cancel-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            title="Cancel avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Cancel-->

                                        <!--begin::Remove-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            title="Remove avatar">
                                            <i class="bi bi-x fs-2"></i>
                                        </span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->

                                    <!--begin::Hint-->
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                    <!--end::Hint-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <!--app_name-->
                            @php
                                $app_name = SettingsHelper::get_settings('app_name');
                            @endphp
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __($app_name->key) }}</label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="{{ $app_name->key }}"
                                        class="form-control form-control-lg form-control-solid"
                                        placeholder="{{ __($app_name->key) }}"
                                        value="{{ old('company', $app_name->value ?? '') }}" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <!--Themes-->
                            @php
                                $app_theme = SettingsHelper::get_settings('theme');
                            @endphp
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    <span class="required">{{ __($app_theme->key) }}</span>

                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                        title="{{ __($app_theme->key) }}"></i>
                                </label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="{{ $app_theme->key }}" aria-label="{{ __('select_a_theme') }}"
                                        data-control="select2" data-placeholder="{{ __('select_a_theme...') }}"
                                        class="form-select form-select-solid form-select-lg fw-bold">
                                        <option value="">{{ __('select_a_theme...') }}</option>
                                        @foreach ($themes as $theme)
                                            <option value="{{ strtolower(str_replace(' ', '', $theme['title'])) }}"
                                                {{ $app_theme->value == strtolower(str_replace(' ', '', $theme['title'])) ? 'selected' : '' }}>
                                                {{ $theme['title'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <!--Country list-->
                            {{-- <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">
                                    <span class="required">{{ __('Country') }}</span>

                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                        title="{{ __('Country of origination') }}"></i>
                                </label>
                                <!--end::Label-->

                                <!--begin::Col-->
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
                                <!--end::Col-->
                            </div> --}}
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <!--Language-->
                            @php
                                $app_language = SettingsHelper::get_settings('app_language');
                            @endphp
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label
                                    class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('language') }}</label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <!--begin::Input-->
                                    <select name="{{ $app_language->key }}"
                                        aria-label="{{ __('select_a_language') }}" data-control="select2"
                                        data-placeholder="{{ __('select_a_language...') }}"
                                        class="form-select form-select-solid form-select-lg">
                                        <option value="">{{ __('select_a_language...') }}</option>
                                        @foreach (\App\Core\Data::getLanguagesList() as $key => $value)
                                            <option data-kt-flag="{{ $value['country']['flag'] }}"
                                                value="{{ $key }}"
                                                {{ $key === $app_language->value ? 'selected' : '' }}>
                                                {{ $value['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->

                                    <!--begin::Hint-->
                                    <div class="form-text">
                                        {{ __('Please select a preferred language, including date, time, and number formatting.') }}
                                    </div>
                                    <!--end::Hint-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <!--Time zone-->
                            @php
                                $app_timezone = SettingsHelper::get_settings('app_timezone');
                            @endphp
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label
                                    class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('Time Zone') }}</label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="timezone" aria-label="{{ __('Select a Timezone') }}"
                                        data-control="select2" data-placeholder="{{ __('Select a timezone..') }}"
                                        class="form-select form-select-solid form-select-lg">
                                        <option value="">{{ __('Select a Timezone..') }}</option>
                                        @foreach (\App\Core\Data::getTimeZonesList() as $key => $value)
                                            <option data-bs-offset="{{ $value['offset'] }}"
                                                value="{{ $key }}"
                                                {{ $key === old('timezone', $info->timezone ?? '') ? 'selected' : '' }}>
                                                {{ $value['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <!--Checkbox-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Communication') }}</label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <!--begin::Options-->
                                    <div class="d-flex align-items-center mt-3">
                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid me-5">
                                            <input type="hidden" name="communication[email]" value="0">
                                            <input class="form-check-input" name="communication[email]"
                                                type="checkbox" value="1"
                                                {{ old('marketing', $info->communication['email'] ?? '') ? 'checked' : '' }} />
                                            <span class="fw-bold ps-2 fs-6">
                                                {{ __('Email') }}
                                            </span>
                                        </label>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        <label class="form-check form-check-inline form-check-solid">
                                            <input type="hidden" name="communication[phone]" value="0">
                                            <input class="form-check-input" name="communication[phone]"
                                                type="checkbox" value="1"
                                                {{ old('email', $info->communication['phone'] ?? '') ? 'checked' : '' }} />
                                            <span class="fw-bold ps-2 fs-6">
                                                {{ __('Phone') }}
                                            </span>
                                        </label>
                                        <!--end::Option-->
                                    </div>
                                    <!--end::Options-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <!--Switch button-->
                            <div class="row mb-0">
                                <!--begin::Label-->
                                <label
                                    class="col-lg-4 col-form-label fw-bold fs-6">{{ __('Allow Marketing') }}</label>
                                <!--begin::Label-->

                                <!--begin::Label-->
                                <div class="col-lg-8 d-flex align-items-center">
                                    <div class="form-check form-check-solid form-check-custom form-switch fv-row">
                                        <input type="hidden" name="marketing" value="0">
                                        <input class="form-check-input w-45px h-30px" type="checkbox"
                                            id="allowmarketing" name="marketing" value="1"
                                            {{ old('marketing', $info->marketing ?? '') ? 'checked' : '' }} />
                                        <label class="form-check-label" for="allowmarketing"></label>
                                    </div>
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card body-->

                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="reset"
                                class="btn btn-white btn-active-light-primary me-2">{{ __('Discard') }}</button>

                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                                @include('partials.general._button-indicator', [
                                    'label' => __('Save Changes'),
                                ])
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>

        </div>
    </div>
</x-base-layout>
