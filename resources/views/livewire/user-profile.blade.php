@php
    $user_avatar_url = $profile_trait['base_data']['user']['image_name'] == null ? asset('images/default-avatar.png') : '';
@endphp

<div id="live-component">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Account Settings
                </h1>

                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="/metronic8/demo1/../demo1/index.html" class="text-muted text-hover-primary">
                            Home </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>

                    <li class="breadcrumb-item text-muted">
                        Account </li>

                </ul>
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <div class="m-0">
                    <a href="#"
                        class="btn btn-sm btn-flex bg-body btn-color-gray-700 btn-active-color-primary fw-bold"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <span class="svg-icon svg-icon-6 svg-icon-muted me-1"><svg width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        Filter
                    </a>

                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                        id="kt_menu_63ea118d5fdcb">
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">Filter Options</div>
                        </div>

                        <div class="separator border-gray-200"></div>

                        <div class="px-7 py-5">
                            <div class="mb-10">
                                <label class="form-label fw-semibold">Status:</label>

                                <div>
                                    <select class="form-select form-select-solid select2-hidden-accessible"
                                        data-kt-select2="true" data-placeholder="Select option"
                                        data-dropdown-parent="#kt_menu_63ea118d5fdcb" data-allow-clear="true"
                                        data-select2-id="select2-data-7-rfed" tabindex="-1" aria-hidden="true"
                                        data-kt-initialized="1">
                                        <option data-select2-id="select2-data-9-0xg3"></option>
                                        <option value="1">Approved</option>
                                        <option value="2">Pending</option>
                                        <option value="2">In Process</option>
                                        <option value="2">Rejected</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5"
                                        dir="ltr" data-select2-id="select2-data-8-8072" style="width: 100%;"><span
                                            class="selection"><span
                                                class="select2-selection select2-selection--single form-select form-select-solid"
                                                role="combobox" aria-haspopup="true" aria-expanded="false"
                                                tabindex="0" aria-disabled="false"
                                                aria-labelledby="select2-gpxj-container"
                                                aria-controls="select2-gpxj-container"><span
                                                    class="select2-selection__rendered" id="select2-gpxj-container"
                                                    role="textbox" aria-readonly="true" title="Select option"><span
                                                        class="select2-selection__placeholder">Select
                                                        option</span></span><span class="select2-selection__arrow"
                                                    role="presentation"><b
                                                        role="presentation"></b></span></span></span><span
                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                </div>
                            </div>

                            <div class="mb-10">
                                <label class="form-label fw-semibold">Member Type:</label>

                                <div class="d-flex">
                                    <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                        <input class="form-check-input" type="checkbox" value="1">
                                        <span class="form-check-label">
                                            Author
                                        </span>
                                    </label>

                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="2"
                                            checked="checked">
                                        <span class="form-check-label">
                                            Customer
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-10">
                                <label class="form-label fw-semibold">Notifications:</label>

                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="" name="notifications"
                                        checked="">
                                    <label class="form-check-label">
                                        Enabled
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                    data-kt-menu-dismiss="true">Reset</button>

                                <button type="submit" class="btn btn-sm btn-primary"
                                    data-kt-menu-dismiss="true">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_create_app">
                    Create</a>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content  flex-column-fluid ">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @include('livewire.includes.profile.header')

            @if ($tab == 'overview')
                @include('livewire.includes.profile.tabs.overview')
            @elseif ($tab == 'settings')
                @include('livewire.includes.profile.tabs.settings')
            @elseif ($tab == 'logs')
                @include('livewire.includes.profile.tabs.logs')
            @endif
        </div>
    </div>
</div>
