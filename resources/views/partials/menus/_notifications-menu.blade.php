<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="notification-layout">
    <div class="d-flex flex-column bgi-no-repeat rounded-top"
        style="background-image:url('{{ asset(theme()->getMediaUrlPath() . 'misc/pattern-1.jpg') }}')">
        <h3 class="text-white fw-semibold px-9 mt-10 mb-6">{{ __('Notifications') }}
            <span class="fs-8 opacity-75 ps-3" id="notifications-count"></span>
        </h3>
        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
            <li class="nav-item">
                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                    href="#kt_topbar_notifications_1">{{ __('Alerts') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab"
                    href="#kt_topbar_notifications_2">{{ __('Updates') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                    href="#kt_topbar_notifications_3">{{ __('Logs') }}</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <!-- NOTE - Alerts -->
        <div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
            <div class="scroll-y mh-325px my-5 px-8" id="all-notifications"></div>

            <div class="py-3 text-center border-top">
                <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">View All
                    <span class="svg-icon svg-icon-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                            <path
                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                fill="currentColor" />
                        </svg>
                    </span>
            </div>
        </div>
        <!-- NOTE - Updates -->
        <div class="tab-pane fade show active" id="kt_topbar_notifications_2" role="tabpanel">
            <div class="d-flex flex-column px-9">
                <div class="pt-10 pb-0">
                    <h3 class="text-dark text-center fw-bold">Get Pro Access</h3>
                    <div class="text-center text-gray-600 fw-semibold pt-1">Outlines keep you honest. They stoping you
                        from amazing poorly about drive</div>
                    <div class="text-center mt-5 mb-9">
                        <a href="#" class="btn btn-sm btn-primary px-6" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_upgrade_plan">Upgrade</a>
                    </div>
                </div>
                <div class="text-center px-4">
                    <img class="mw-100 mh-200px" alt="image"
                        src="{{ asset(theme()->getIllustrationUrl('1.png')) }}" />
                </div>
            </div>
        </div>
        <!-- NOTE - Logs -->
        <div class="tab-pane fade" id="kt_topbar_notifications_3" role="tabpanel">
            <div class="scroll-y mh-325px my-5 px-8" id="all-logs"></div>

            <div class="py-3 text-center border-top">
                <a href="{{ route('profile.index', ['tab' => 'logs']) }}"
                    class="btn btn-color-gray-600 btn-active-color-primary">{{ __('View All') }}
                    <span class="svg-icon svg-icon-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                            <path
                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
