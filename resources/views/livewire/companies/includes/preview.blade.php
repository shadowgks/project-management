{{-- preveiw - start --}}
<div class="col-md-6{{ $options['show_content'] ? '' : ' ' . 'hidden' }}">
    <div class="card mt-6" id="content">
        <div class="card-header">
            <h3 class="card-title">
                <div class="py-2">
                    <div>{{ $options['title_content'] }}</div>
                    <div class="badge py-2 px-3 mt-2 fs-7 badge-{{ $options['status_color_content'] }}">
                        {{ $options['status_content'] }}</div>
                </div>
            </h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-warning btn-shadow btn-icon me-1"
                    onclick="loadingVisibility(true)" wire:click="cancel('show_content')">
                    <i class="fa fa-chevron-left p-0"></i>
                </button>
                @if ($base_data['permissions']['update'])
                    <button type="button" class="btn btn-sm btn-secondary btn-shadow btn-icon me-1"
                        onclick="loadingVisibility(true)" wire:click="_edit">
                        <i class="fa fa-pencil p-0"></i>
                    </button>
                @endif
                <button type="button" class="btn btn-sm btn-success btn-shadow me-1" onclick="loadingVisibility(true)"
                    wire:click="validateData">
                    {{-- <i class="fa fa-check p-0"></i> --}}
                    {{ __('Validate') }}
                </button>

                <div class="dropdown dropleft">
                    <button class="btn btn-sm btn-primary dropleft" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" onclick="loadingVisibility(true)"
                        wire:click="action_options('show_dropdown')">
                        <div class="svg-icon svg-icon-2 m-0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="10" y="10" width="4" height="4" rx="2"
                                    fill="currentColor"></rect>
                                <rect x="17" y="10" width="4" height="4" rx="2"
                                    fill="currentColor"></rect>
                                <rect x="3" y="10" width="4" height="4" rx="2"
                                    fill="currentColor"></rect>
                            </svg>
                        </div>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right {{ $options['show_dropdown'] ? 'show' : '' }}"
                        aria-labelledby="dropdownMenuButton" style="right: 0;">
                        @if (
                            $base_data['permissions']['create_reminders'] &&
                                count($base_data['app_module']) > 0 &&
                                $base_data['app_module']['activate_reminders']
                        )
                            <a class="dropdown-item py-3 cursor-pointer" onclick="loadingVisibility(true)"
                                wire:click="app_click_option('reminders')">
                                <i class="fa fa-bell p-0 me-1"></i>
                                {{ __('Add reminder') }}
                            </a>
                        @endif

                        @if (count($base_data['app_module']) > 0 && $base_data['app_module']['activate_duplicate'])
                            <a class="dropdown-item py-3 cursor-pointer" onclick="loadingVisibility(true)"
                                wire:click="app_click_option('duplicate')">
                                <i class="fa fa-clone p-0 me-1"></i>
                                {{ __('duplicate') }}
                            </a>
                        @endif

                        @if (
                            $base_data['permissions']['create_file_upload'] &&
                                count($base_data['app_module']) > 0 &&
                                $base_data['app_module']['activate_file_upload']
                        )
                            <a class="dropdown-item py-3 cursor-pointer" onclick="loadingVisibility(true)"
                                wire:click="app_click_option('upload_file')">
                                <i class="fa fa-file p-0 me-1"></i>
                                {{ __('Join file') }}
                            </a>
                        @endif

                        @if (count($base_data['app_module']) > 0 && $base_data['app_module']['emailing'])
                            <a class="dropdown-item py-3 cursor-pointer" onclick="loadingVisibility(true)"
                                wire:click="app_click_option('mails')">
                                <i class="fa fa-paper-plane p-0 me-1"></i>
                                {{ __('Send mail') }}
                            </a>
                        @endif

                        @if (count($base_data['app_module']) > 0 && $base_data['app_module']['pdf'])
                            <a class="dropdown-item py-3 cursor-pointer" onclick="loadingVisibility(true)"
                                wire:click="app_click_option('pdf')">
                                <i class="fa fa-file-pdf p-0 me-1"></i>
                                {{ __('Print PDF') }}
                            </a>
                        @endif

                        @if (
                            $base_data['permissions']['create_comments'] &&
                                count($base_data['app_module']) > 0 &&
                                $base_data['app_module']['activate_comments']
                        )
                            <a class="dropdown-item py-3 cursor-pointer" onclick="loadingVisibility(true)"
                                wire:click="app_click_option('comments')">
                                <i class="fa fa-comment p-0 me-1"></i>
                                {{ __('Comment') }}
                            </a>
                        @endif

                        <a class="dropdown-item link link-danger py-3 cursor-pointer" onclick="loadingVisibility(true)"
                            wire:click="deleteData">{{ __('Delete') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="d-flex gap-7 align-items-center">
                <div class="symbol symbol-circle symbol-100px">
                    <img src="https://preview.keenthemes.com/metronic8/demo6/assets/media/avatars/300-6.jpg"
                        alt="image">
                </div>
                <div class="d-flex flex-column gap-2">
                    <h3 class="mb-0">Emma Smith</h3>
                    <div class="d-flex align-items-center gap-2">
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z"
                                    fill="currentColor"></path>
                                <path
                                    d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <a href="#" class="text-muted text-hover-primary">smith@kpmg.com</a>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 20H19V21C19 21.6 18.6 22 18 22H6C5.4 22 5 21.6 5 21V20ZM19 3C19 2.4 18.6 2 18 2H6C5.4 2 5 2.4 5 3V4H19V3Z"
                                    fill="currentColor"></path>
                                <path opacity="0.3" d="M19 4H5V20H19V4Z" fill="currentColor"></path>
                            </svg>
                        </span>
                        <a href="#" class="text-muted text-hover-primary">+6141 234 567</a>
                    </div>
                </div>
            </div>

            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x fs-6 fw-semibold mt-6 mb-8"
                role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                        href="#kt_contact_view_general" aria-selected="true" role="tab">
                        <span class="svg-icon svg-icon-4 me-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        {{ __('General') }}
                    </a>
                </li>

                @if (count($base_data['app_module']) > 0 && $base_data['app_module']['activate_reminders'])
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_reminder_view"
                            aria-selected="false" tabindex="-1" role="tab">
                            <i class="fa fa-bell p-0"></i>
                            {{ __('Reminders') }}
                            <div class="badge badge-light-primary">1</div>
                        </a>
                    </li>
                @endif

                @if (count($base_data['app_module']) > 0 && $base_data['app_module']['activate_file_upload'])
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_upload_file_view"
                            aria-selected="false" tabindex="-1" role="tab">
                            <i class="fa fa-file p-0"></i>
                            {{ __('Join file') }}
                            <div class="badge badge-light-primary">2</div>
                        </a>
                    </li>
                @endif

                @if (count($base_data['app_module']) > 0 && $base_data['app_module']['activate_comments'])
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_comment_view"
                            aria-selected="false" tabindex="-1" role="tab">
                            <i class="fa fa-comment p-0"></i>
                            {{ __('Comments') }}
                            <div class="badge badge-light-primary">9</div>
                        </a>
                    </li>
                @endif

                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                        href="#kt_contact_view_activity" aria-selected="false" tabindex="-1" role="tab">
                        <span class="svg-icon svg-icon-4 me-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.0077 19.2901L12.9293 17.5311C12.3487 17.1993 11.6407 17.1796 11.0426 17.4787L6.89443 19.5528C5.56462 20.2177 4 19.2507 4 17.7639V5C4 3.89543 4.89543 3 6 3H17C18.1046 3 19 3.89543 19 5V17.5536C19 19.0893 17.341 20.052 16.0077 19.2901Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        {{ __('Log') }}
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="">
                <div class="tab-pane fade show active" id="kt_contact_view_general" role="tabpanel">
                    <div class="d-flex flex-column gap-5 mt-7">
                        <div class="d-flex flex-column gap-1">
                            <div class="fw-bold fs-5">Keenthemes Inc</div>
                            <div class="fw-bold text-muted">Company Name</div>
                        </div>
                    </div>
                </div>

                @if (
                    $base_data['permissions']['view_reminders'] &&
                        count($base_data['app_module']) > 0 &&
                        $base_data['app_module']['activate_reminders']
                )
                    <div class="tab-pane fade" id="kt_reminder_view" role="tabpanel">
                        <livewire:table
                            _id="{{ $base_data['module_name'] }}-{{ $appValues['reminders']['datatable']['name'] }}"
                            :columns="$appValues['reminders']['datatable']['columns']"
                            route="{{ route($base_data['module_name'] . '.' . $appValues['reminders']['datatable']['name']) }}"
                            :module_id="$options['module_id'] ?? null" />
                    </div>
                @endif

                @if (
                    $base_data['permissions']['view_file_upload'] &&
                        count($base_data['app_module']) > 0 &&
                        $base_data['app_module']['activate_file_upload']
                )
                    <div class="tab-pane fade" id="kt_upload_file_view" role="tabpanel">
                        <livewire:table
                            _id="{{ $base_data['module_name'] }}-{{ $appValues['upload_file']['datatable']['name'] }}"
                            :columns="$appValues['upload_file']['datatable']['columns']"
                            route="{{ route($base_data['module_name'] . '.' . $appValues['upload_file']['datatable']['name']) }}"
                            :module_id="$options['module_id'] ?? null" />
                    </div>
                @endif

                @if (
                    $base_data['permissions']['view_comments'] &&
                        count($base_data['app_module']) > 0 &&
                        $base_data['app_module']['activate_comments']
                )
                    <div class="tab-pane fade" id="kt_comment_view" role="tabpanel">
                        <div data-kt-inbox-message="message_wrapper">
                            <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer"
                                data-kt-inbox-message="header">
                                @foreach ($appValues['comments']['rows'] as $comment)
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-50 me-4">
                                            <span class="symbol-label"
                                                style="background-image:url(/metronic8/demo6/assets/media/avatars/300-1.jpg);"></span>
                                        </div>
                                        <div class="pe-5">
                                            <div class="d-flex align-items-center flex-wrap gap-1">
                                                <a href="#"
                                                    class="fw-bold text-dark text-hover-primary">{{ $comment['created_by'] == null ? '-' : $comment['created_by']['first_name'] . ' ' . $comment['created_by']['last_name'] }}</a>
                                                <span class="svg-icon svg-icon-7 svg-icon-success mx-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <circle fill="currentColor" cx="12" cy="12"
                                                            r="8"></circle>
                                                    </svg>
                                                </span>
                                                <span
                                                    class="text-muted fw-bold">{{ _dfh($comment['created_at']) }}</span>
                                            </div>
                                            <div class="text-muted fw-semibold mw-450px"
                                                data-kt-inbox-message="preview">{{ $comment['description'] }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <span
                                            class="fw-semibold text-muted text-end me-3">{{ _dt($comment['created_at']) }}</span>
                                        <div class="d-flex">
                                            {{-- Reply button --}}
                                            <a href="#"
                                                class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                                                data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Reply"
                                                data-bs-original-title="Reply" data-kt-initialized="1"
                                                wire:click="editComment({{ $comment['id'] }})">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="#"
                                                class="btn btn-sm btn-icon btn-clear btn-active-light-primary"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                aria-label="Settings" data-bs-original-title="Settings"
                                                data-kt-initialized="1"
                                                wire:click="deleteComment({{ $comment['id'] }})">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="tab-pane fade" id="kt_contact_view_activity" role="tabpanel">
                    <div class="timeline-label">
                        <div class="timeline-item">
                            <div class="timeline-label fw-bold text-gray-800 fs-6">08:42</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-warning fs-1"></i>
                            </div>
                            <div class="fw-mormal timeline-content text-muted ps-3">Outlines keep
                                you
                                honest. And keep structure</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-label fw-bold text-gray-800 fs-6">10:00</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-success fs-1"></i>
                            </div>
                            <div class="timeline-content d-flex">
                                <span class="fw-bold text-gray-800 ps-3">AEOL meeting</span>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-label fw-bold text-gray-800 fs-6">14:37</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-danger fs-1"></i>
                            </div>
                            <div class="timeline-content fw-bold text-gray-800 ps-3">Make deposit
                                <a href="#" class="text-primary">USD 700</a>. to ESL
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-label fw-bold text-gray-800 fs-6">16:50</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-primary fs-1"></i>
                            </div>
                            <div class="timeline-content fw-mormal text-muted ps-3">Indulging in
                                poorly
                                driving and keep structure keep great</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-label fw-bold text-gray-800 fs-6">21:03</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-danger fs-1"></i>
                            </div>
                            <div class="timeline-content fw-semibold text-gray-800 ps-3">New order
                                placed
                                <a href="#" class="text-primary">#XF-2356</a>.
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-label fw-bold text-gray-800 fs-6">16:50</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-primary fs-1"></i>
                            </div>
                            <div class="timeline-content fw-mormal text-muted ps-3">Indulging in
                                poorly
                                driving and keep structure keep great</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-label fw-bold text-gray-800 fs-6">21:03</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-danger fs-1"></i>
                            </div>
                            <div class="timeline-content fw-semibold text-gray-800 ps-3">New order
                                placed
                                <a href="#" class="text-primary">#XF-2356</a>.
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-label fw-bold text-gray-800 fs-6">10:30</div>
                            <div class="timeline-badge">
                                <i class="fa fa-genderless text-success fs-1"></i>
                            </div>
                            <div class="timeline-content fw-mormal text-muted ps-3">Finance KPI
                                Mobile
                                app launch preparion meeting</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- preveiw - end --}}
