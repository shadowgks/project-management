<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Profile Details</h3>
        </div>
    </div>

    <div id="kt_account_settings_profile_details" class="collapse show">
        <form id="kt_account_profile_details_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
            novalidate="novalidate">
            <div class="card-body border-top p-9">
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>

                    <div class="col-lg-8">
                        <div class="image-input image-input-outline" data-kt-image-input="true"
                            style="background-image: url('/metronic8/demo1/assets/media/svg/avatars/blank.svg')">
                            <div class="image-input-wrapper w-125px h-125px"
                                style="background-image: url('{{ $user_avatar_url }}')">
                            </div>

                            <label
                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                aria-label="Change avatar" data-bs-original-title="Change avatar"
                                data-kt-initialized="1">
                                <i class="bi bi-pencil-fill fs-7"></i>

                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                <input type="hidden" name="avatar_remove">
                            </label>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                aria-label="Cancel avatar" data-bs-original-title="Cancel avatar"
                                data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>

                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                aria-label="Remove avatar" data-bs-original-title="Remove avatar"
                                data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                        </div>

                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>

                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                <input type="text" name="fname"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    placeholder="First name" value="Max">
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>

                            <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                <input type="text" name="lname"
                                    class="form-control form-control-lg form-control-solid" placeholder="Last name"
                                    value="Smith">
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Company</label>

                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input type="text" name="company" class="form-control form-control-lg form-control-solid"
                            placeholder="Company name" value="Keenthemes">
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                        <span class="required">Contact Phone</span>

                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                            aria-label="Phone number must be active"
                            data-bs-original-title="Phone number must be active" data-kt-initialized="1"></i>
                    </label>

                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input type="tel" name="phone" class="form-control form-control-lg form-control-solid"
                            placeholder="Phone number" value="044 3276 454 935">
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Company Site</label>

                    <div class="col-lg-8 fv-row">
                        <input type="text" name="website" class="form-control form-control-lg form-control-solid"
                            placeholder="Company website" value="keenthemes.com">
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                        <span class="required">Country</span>

                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                            aria-label="Country of origination" data-bs-original-title="Country of origination"
                            data-kt-initialized="1"></i>
                    </label>

                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <select name="country" aria-label="Select a Country" data-control="select2"
                            data-placeholder="Select a country..."
                            class="form-select form-select-solid form-select-lg fw-semibold select2-hidden-accessible"
                            data-select2-id="select2-data-10-wj9w" tabindex="-1" aria-hidden="true"
                            data-kt-initialized="1">
                            <option value="" data-select2-id="select2-data-12-ietd">Select a
                                Country...
                            </option>
                        </select>

                        <span class="select2 select2-container select2-container--bootstrap5" dir="ltr"
                            data-select2-id="select2-data-11-vdcz" style="width: 100%;"><span class="selection"><span
                                    class="select2-selection select2-selection--single form-select form-select-solid form-select-lg fw-semibold"
                                    role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                    aria-disabled="false" aria-labelledby="select2-country-mw-container"
                                    aria-controls="select2-country-mw-container"><span
                                        class="select2-selection__rendered" id="select2-country-mw-container"
                                        role="textbox" aria-readonly="true" title="Select a country..."><span
                                            class="select2-selection__placeholder">Select a
                                            country...</span></span><span class="select2-selection__arrow"
                                        role="presentation"><b role="presentation"></b></span></span></span><span
                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Language</label>

                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <select name="language" aria-label="Select a Language" data-control="select2"
                            data-placeholder="Select a language..."
                            class="form-select form-select-solid form-select-lg select2-hidden-accessible"
                            data-select2-id="select2-data-13-fofj" tabindex="-1" aria-hidden="true"
                            data-kt-initialized="1">
                            <option value="" data-select2-id="select2-data-15-1nqu">Select a
                                Language...
                            </option>
                        </select>

                        <span class="select2 select2-container select2-container--bootstrap5" dir="ltr"
                            data-select2-id="select2-data-14-rp0p" style="width: 100%;"><span class="selection"><span
                                    class="select2-selection select2-selection--single form-select form-select-solid form-select-lg"
                                    role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                    aria-disabled="false" aria-labelledby="select2-language-w0-container"
                                    aria-controls="select2-language-w0-container"><span
                                        class="select2-selection__rendered" id="select2-language-w0-container"
                                        role="textbox" aria-readonly="true" title="Select a language..."><span
                                            class="select2-selection__placeholder">Select a
                                            language...</span></span><span class="select2-selection__arrow"
                                        role="presentation"><b role="presentation"></b></span></span></span><span
                                class="dropdown-wrapper" aria-hidden="true"></span></span>

                        <div class="form-text">
                            Please select a preferred language, including date, time, and number formatting.
                        </div>
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Time Zone</label>

                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <select name="timezone" aria-label="Select a Timezone" data-control="select2"
                            data-placeholder="Select a timezone.."
                            class="form-select form-select-solid form-select-lg select2-hidden-accessible"
                            data-select2-id="select2-data-16-dgyv" tabindex="-1" aria-hidden="true"
                            data-kt-initialized="1">
                            <option value="" data-select2-id="select2-data-18-qvld">Select a
                                Timezone..</option>
                        </select>
                        <span class="select2 select2-container select2-container--bootstrap5" dir="ltr"
                            data-select2-id="select2-data-17-zgnt" style="width: 100%;"><span class="selection"><span
                                    class="select2-selection select2-selection--single form-select form-select-solid form-select-lg"
                                    role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                    aria-disabled="false" aria-labelledby="select2-timezone-2a-container"
                                    aria-controls="select2-timezone-2a-container"><span
                                        class="select2-selection__rendered" id="select2-timezone-2a-container"
                                        role="textbox" aria-readonly="true" title="Select a timezone.."><span
                                            class="select2-selection__placeholder">Select a
                                            timezone..</span></span><span class="select2-selection__arrow"
                                        role="presentation"><b role="presentation"></b></span></span></span><span
                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label  fw-semibold fs-6">Currency</label>

                    <div class="col-lg-8 fv-row">
                        <select name="currnecy" aria-label="Select a Currency" data-control="select2"
                            data-placeholder="Select a currency.."
                            class="form-select form-select-solid form-select-lg select2-hidden-accessible"
                            data-select2-id="select2-data-19-x2sf" tabindex="-1" aria-hidden="true"
                            data-kt-initialized="1">
                            <option value="" data-select2-id="select2-data-21-kfh1">Select a
                                currency..</option>
                        </select>
                        <span class="select2 select2-container select2-container--bootstrap5" dir="ltr"
                            data-select2-id="select2-data-20-kql3" style="width: 100%;"><span class="selection"><span
                                    class="select2-selection select2-selection--single form-select form-select-solid form-select-lg"
                                    role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0"
                                    aria-disabled="false" aria-labelledby="select2-currnecy-f5-container"
                                    aria-controls="select2-currnecy-f5-container"><span
                                        class="select2-selection__rendered" id="select2-currnecy-f5-container"
                                        role="textbox" aria-readonly="true" title="Select a currency.."><span
                                            class="select2-selection__placeholder">Select a
                                            currency..</span></span><span class="select2-selection__arrow"
                                        role="presentation"><b role="presentation"></b></span></span></span><span
                                class="dropdown-wrapper" aria-hidden="true"></span></span>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Communication</label>

                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <div class="d-flex align-items-center mt-3">
                            <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                                <input class="form-check-input" name="communication[]" type="checkbox"
                                    value="1">
                                <span class="fw-semibold ps-2 fs-6">
                                    Email
                                </span>
                            </label>

                            <label class="form-check form-check-custom form-check-inline form-check-solid">
                                <input class="form-check-input" name="communication[]" type="checkbox"
                                    value="2">
                                <span class="fw-semibold ps-2 fs-6">
                                    Phone
                                </span>
                            </label>
                        </div>
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                </div>

                <div class="row mb-0">
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Allow Marketing</label>

                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="allowmarketing"
                                checked="">
                            <label class="form-check-label" for="allowmarketing"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>

                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save
                    Changes</button>
            </div>

            <input type="hidden">
        </form>
    </div>
</div>

<div class="card  mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_signin_method">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Sign-in Method</h3>
        </div>
    </div>

    <div id="kt_account_settings_signin_method" class="collapse show">
        <div class="card-body border-top p-9">
            <div class="d-flex flex-wrap align-items-center">
                <div id="kt_signin_email">
                    <div class="fs-6 fw-bold mb-1">{{ __('Email Address') }}</div>
                    <div class="fw-semibold text-gray-600">
                        {{ $profile_trait['base_data']['user']['email'] ?? '' }}</div>
                </div>
            </div>

            <div class="separator separator-dashed my-6"></div>

            <!-- NOTE - Password -->
            <div class="d-flex flex-wrap align-items-center mb-10">
                @if ($profile_trait['options']['changing_password'])
                    <div id="kt_signin_password_edit" class="flex-row-fluid">
                        <form id="kt_signin_change_password" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                            novalidate="novalidate">
                            <div class="row mb-1">
                                {{-- <div class="col-lg-4">
                                                <div class="fv-row mb-0 fv-plugins-icon-container">
                                                    <label for="currentpassword"
                                                        class="form-label fs-6 fw-bold mb-3">Current Password</label>
                                                    <input type="password"
                                                        class="form-control form-control-lg form-control-solid"
                                                        name="currentpassword" id="currentpassword">
                                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                                </div>
                                            </div> --}}

                                <div class="col-lg-4">
                                    <div class="fv-row mb-0 fv-plugins-icon-container">
                                        <label for="newpassword"
                                            class="form-label fs-6 fw-bold mb-3">{{ __('New Password') }}</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid"
                                            name="newpassword" id="newpassword"
                                            wire:model.lazy="profile_trait.values.password.new_password">
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="fv-row mb-0 fv-plugins-icon-container">
                                        <label for="confirmpassword"
                                            class="form-label fs-6 fw-bold mb-3">{{ __('Confirm New Password') }}</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid"
                                            name="confirmpassword" id="confirmpassword"
                                            wire:model.lazy="profile_trait.values.password.second_password">
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-text mb-5">
                                {{ __('Password must be at least 8 character and contain symbols') }}
                            </div>

                            <div class="d-flex">
                                <button id="kt_password_submit" type="button" class="btn btn-primary me-2 px-6"
                                    wire:click="profile_show_confirm_modal">{{ __('Update Password') }}</button>
                                <button id="kt_password_cancel" type="button"
                                    class="btn btn-color-gray-400 btn-active-light-primary px-6"
                                    wire:click="profile_change_password(false)">{{ __('Cancel') }}</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div id="kt_signin_password">
                        <div class="fs-6 fw-bold mb-1">{{ __('Password') }}</div>
                        <div class="fw-semibold text-gray-600">************</div>
                    </div>

                    <div id="kt_signin_password_button" class="ms-auto">
                        <button class="btn btn-light btn-active-light-primary"
                            wire:click="profile_change_password(true)">{{ __('Reset Password') }}</button>
                    </div>
                @endif
            </div>

            {{-- <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed  p-6">
                            <span class="svg-icon svg-icon-2tx svg-icon-primary me-4"><svg width="24"
                                    height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>

                            <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                <div class="mb-3 mb-md-0 fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">Secure Your Account</h4>

                                    <div class="fs-6 text-gray-700 pe-7">Two-factor authentication adds an extra layer
                                        of
                                        security to your account. To log in, in addition you'll need to provide a 6
                                        digit
                                        code</div>
                                </div>

                                <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap"
                                    data-bs-toggle="modal" data-bs-target="#kt_modal_two_factor_authentication">
                                    Enable </a>
                            </div>
                        </div> --}}
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_connected_accounts" aria-expanded="true"
        aria-controls="kt_account_connected_accounts">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Connected Accounts</h3>
        </div>
    </div>

    <div id="kt_account_settings_connected_accounts" class="collapse show">
        <div class="card-body border-top p-9">
            <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                <span class="svg-icon svg-icon-2tx svg-icon-primary me-4"><svg width="24" height="24"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3"
                            d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z"
                            fill="currentColor"></path>
                        <path
                            d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z"
                            fill="currentColor"></path>
                    </svg>
                </span>

                <div class="d-flex flex-stack flex-grow-1 ">
                    <div class=" fw-semibold">

                        <div class="fs-6 text-gray-700 ">Two-factor authentication adds an extra layer of
                            security to your account. To log in, in you'll need to provide a 4 digit amazing
                            code. <a href="#" class="fw-bold">Learn More</a></div>
                    </div>
                </div>
            </div>

            <div class="py-2">
                <div class="d-flex flex-stack">
                    <div class="d-flex">
                        <img src="/metronic8/demo1/assets/media/svg/brand-logos/google-icon.svg" class="w-30px me-6"
                            alt="">

                        <div class="d-flex flex-column">
                            <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">Google</a>
                            <div class="fs-6 fw-semibold text-gray-400">Plan properly your workflow</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="form-check form-check-solid form-check-custom form-switch">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="googleswitch"
                                checked="">
                            <label class="form-check-label" for="googleswitch"></label>
                        </div>
                    </div>
                </div>

                <div class="separator separator-dashed my-5"></div>

                <div class="d-flex flex-stack">
                    <div class="d-flex">
                        <img src="/metronic8/demo1/assets/media/svg/brand-logos/github.svg" class="w-30px me-6"
                            alt="">

                        <div class="d-flex flex-column">
                            <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">Github</a>
                            <div class="fs-6 fw-semibold text-gray-400">Keep eye on on your Repositories
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="form-check form-check-solid form-check-custom form-switch">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="githubswitch"
                                checked="">
                            <label class="form-check-label" for="githubswitch"></label>
                        </div>
                    </div>
                </div>

                <div class="separator separator-dashed my-5"></div>

                <div class="d-flex flex-stack">
                    <div class="d-flex">
                        <img src="/metronic8/demo1/assets/media/svg/brand-logos/slack-icon.svg" class="w-30px me-6"
                            alt="">

                        <div class="d-flex flex-column">
                            <a href="#" class="fs-5 text-dark text-hover-primary fw-bold">Slack</a>
                            <div class="fs-6 fw-semibold text-gray-400">Integrate Projects Discussions
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="form-check form-check-solid form-check-custom form-switch">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="slackswitch">
                            <label class="form-check-label" for="slackswitch"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button class="btn btn-light btn-active-light-primary me-2">Discard</button>
            <button class="btn btn-primary">Save Changes</button>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_email_preferences" aria-expanded="true"
        aria-controls="kt_account_email_preferences">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Email Preferences</h3>
        </div>
    </div>

    <div id="kt_account_settings_email_preferences" class="collapse show">
        <form class="form">
            <div class="card-body border-top px-9 py-9">
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <input class="form-check-input me-3" type="checkbox" name="email-preferences[]" value="1">

                    <span class="form-check-label d-flex flex-column align-items-start">
                        <span class="fw-bold fs-5 mb-0">Successful Payments</span>
                        <span class="text-muted fs-6">Receive a notification for every successful
                            payment.</span>
                    </span>
                </label>

                <div class="separator separator-dashed my-6"></div>
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <input class="form-check-input me-3" type="checkbox" name="email-preferences[]"
                        checked="checked" value="1">

                    <span class="form-check-label d-flex flex-column align-items-start">
                        <span class="fw-bold fs-5 mb-0">Payouts</span>
                        <span class="text-muted fs-6">Receive a notification for every initiated
                            payout.</span>
                    </span>
                </label>

                <div class="separator separator-dashed my-6"></div>
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <input class="form-check-input me-3" type="checkbox" name="email-preferences[]" value="1">

                    <span class="form-check-label d-flex flex-column align-items-start">
                        <span class="fw-bold fs-5 mb-0">Fee Collection</span>
                        <span class="text-muted fs-6">Receive a notification each time you collect a fee
                            from
                            sales</span>
                    </span>
                </label>

                <div class="separator separator-dashed my-6"></div>
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <input class="form-check-input me-3" type="checkbox" name="email-preferences[]"
                        checked="checked" value="1">

                    <span class="form-check-label d-flex flex-column align-items-start">
                        <span class="fw-bold fs-5 mb-0">Customer Payment Dispute</span>
                        <span class="text-muted fs-6">Receive a notification if a payment is disputed by a
                            customer and for dispute purposes.</span>
                    </span>
                </label>

                <div class="separator separator-dashed my-6"></div>
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <input class="form-check-input me-3" type="checkbox" name="email-preferences[]" value="1">

                    <span class="form-check-label d-flex flex-column align-items-start">
                        <span class="fw-bold fs-5 mb-0">Refund Alerts</span>
                        <span class="text-muted fs-6">Receive a notification if a payment is stated as
                            risk by
                            the Finance Department.</span>
                    </span>
                </label>

                <div class="separator separator-dashed my-6"></div>
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <input class="form-check-input me-3" type="checkbox" name="email-preferences[]"
                        checked="checked" value="1">

                    <span class="form-check-label d-flex flex-column align-items-start">
                        <span class="fw-bold fs-5 mb-0">Invoice Payments</span>
                        <span class="text-muted fs-6">Receive a notification if a customer sends an
                            incorrect
                            amount to pay their invoice.</span>
                    </span>
                </label>

                <div class="separator separator-dashed my-6"></div>
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <input class="form-check-input me-3" type="checkbox" name="email-preferences[]" value="1">

                    <span class="form-check-label d-flex flex-column align-items-start">
                        <span class="fw-bold fs-5 mb-0">Webhook API Endpoints</span>
                        <span class="text-muted fs-6">Receive notifications for consistently failing
                            webhook
                            API endpoints.</span>
                    </span>
                </label>
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button class="btn btn-light btn-active-light-primary me-2">Discard</button>
                <button class="btn btn-primary  px-6">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div class="card  mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_notifications" aria-expanded="true" aria-controls="kt_account_notifications">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Notifications</h3>
        </div>
    </div>

    <div id="kt_account_settings_notifications" class="collapse show">
        <form class="form">
            <div class="card-body border-top px-9 pt-3 pb-4">
                <div class="table-responsive">
                    <table class="table table-row-dashed border-gray-300 align-middle gy-6">
                        <tbody class="fs-6 fw-semibold">
                            <tr>
                                <td class="min-w-250px fs-4 fw-bold">Notifications</td>
                                <td class="w-125px">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="kt_settings_notification_email" checked="" data-kt-check="true"
                                            data-kt-check-target="[data-kt-settings-notification=email]">
                                        <label class="form-check-label ps-2" for="kt_settings_notification_email">
                                            Email
                                        </label>
                                    </div>
                                </td>
                                <td class="w-125px">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="kt_settings_notification_phone" checked="" data-kt-check="true"
                                            data-kt-check-target="[data-kt-settings-notification=phone]">
                                        <label class="form-check-label ps-2" for="kt_settings_notification_phone">
                                            Phone
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>Billing Updates</td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1"
                                            id="billing1" checked="" data-kt-settings-notification="email">
                                        <label class="form-check-label ps-2" for="billing1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="billing2" checked="" data-kt-settings-notification="phone">
                                        <label class="form-check-label ps-2" for="billing2"></label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>New Team Members</td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="team1" checked="" data-kt-settings-notification="email">
                                        <label class="form-check-label ps-2" for="team1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="team2" data-kt-settings-notification="phone">
                                        <label class="form-check-label ps-2" for="team2"></label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>Completed Projects</td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="project1" data-kt-settings-notification="email">
                                        <label class="form-check-label ps-2" for="project1"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="project2" checked="" data-kt-settings-notification="phone">
                                        <label class="form-check-label ps-2" for="project2"></label>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="border-bottom-0">Newsletters</td>
                                <td class="border-bottom-0">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="newsletter1" data-kt-settings-notification="email">
                                        <label class="form-check-label ps-2" for="newsletter1"></label>
                                    </div>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="newsletter2" data-kt-settings-notification="phone">
                                        <label class="form-check-label ps-2" for="newsletter2"></label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button class="btn btn-light btn-active-light-primary me-2">Discard</button>
                <button class="btn btn-primary  px-6">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">Deactivate Account</h3>
        </div>
    </div>

    <div id="kt_account_settings_deactivate" class="collapse show">
        <form id="kt_account_deactivate_form" class="form fv-plugins-bootstrap5 fv-plugins-framework"
            novalidate="novalidate">
            <div class="card-body border-top p-9">
                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                    <span class="svg-icon svg-icon-2tx svg-icon-warning me-4"><svg width="24" height="24"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                rx="10" fill="currentColor"></rect>
                            <rect x="11" y="14" width="7" height="2" rx="1"
                                transform="rotate(-90 11 14)" fill="currentColor">
                            </rect>
                            <rect x="11" y="17" width="2" height="2" rx="1"
                                transform="rotate(-90 11 17)" fill="currentColor">
                            </rect>
                        </svg>
                    </span>

                    <div class="d-flex flex-stack flex-grow-1 ">
                        <div class=" fw-semibold">
                            <h4 class="text-gray-900 fw-bold">You Are Deactivating Your Account</h4>

                            <div class="fs-6 text-gray-700 ">For extra security, this requires you to
                                confirm
                                your email or phone number when you reset yousignr password. <br><a class="fw-bold"
                                    href="#">Learn more</a></div>
                        </div>
                    </div>
                </div>

                <div class="form-check form-check-solid fv-row fv-plugins-icon-container">
                    <input name="deactivate" class="form-check-input" type="checkbox" value=""
                        id="deactivate">
                    <label class="form-check-label fw-semibold ps-2 fs-6" for="deactivate">I confirm my
                        account deactivation</label>
                    <div class="fv-plugins-message-container invalid-feedback"></div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button id="kt_account_deactivate_account_submit" type="submit"
                    class="btn btn-danger fw-semibold">Deactivate Account</button>
            </div>

            <input type="hidden">
        </form>
    </div>
</div>
