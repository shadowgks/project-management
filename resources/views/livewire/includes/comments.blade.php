@if ($base_data['permissions']['view_comments'] &&
    count($base_data['app_module']) > 0 &&
    $base_data['app_module']['activate_comments'])
    <div class="tab-pane fade" id="kt_comment_view" role="tabpanel">
        <div data-kt-inbox-message="message_wrapper">
            <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-50 me-4">
                        <span class="symbol-label"
                            style="background-image:url(/metronic8/demo6/assets/media/avatars/300-1.jpg);"></span>
                    </div>
                    <div class="pe-5">
                        <div class="d-flex align-items-center flex-wrap gap-1">
                            <a href="#" class="fw-bold text-dark text-hover-primary">Max
                                Smith</a>
                            <span class="svg-icon svg-icon-7 svg-icon-success mx-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                    viewBox="0 0 24 24" version="1.1">
                                    <circle fill="currentColor" cx="12" cy="12" r="8"></circle>
                                </svg>
                            </span>
                            <span class="text-muted fw-bold">2 days ago</span>
                        </div>
                        <div class="d-none" data-kt-inbox-message="details">
                            <span class="text-muted fw-semibold">to me</span>
                            <a href="#" class="me-1" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-start">
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-4"
                                data-kt-menu="true">
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="w-75px text-muted">From</td>
                                            <td>Emma Bold</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Date</td>
                                            <td>21 Feb 2022, 5:30 pm</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Subject</td>
                                            <td>Trip Reminder. Thank you for flying with
                                                us!
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Reply-to</td>
                                            <td>emma@intenso.com</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="text-muted fw-semibold mw-450px" data-kt-inbox-message="preview">
                            Jornalists call this
                            critical,
                            introductory section the "Lede," and when bridge properly
                            executed....</div>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="fw-semibold text-muted text-end me-3">15 Apr 2022,
                        6:43
                        am</span>
                    <div class="d-flex">
                        {{-- Reply button --}}
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Reply"
                            data-bs-original-title="Reply" data-kt-initialized="1">
                            <span class="svg-icon svg-icon-2 m-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2 4.63158C2 3.1782 3.1782 2 4.63158 2H13.47C14.0155 2 14.278 2.66919 13.8778 3.04006L12.4556 4.35821C11.9009 4.87228 11.1726 5.15789 10.4163 5.15789H7.1579C6.05333 5.15789 5.15789 6.05333 5.15789 7.1579V16.8421C5.15789 17.9467 6.05333 18.8421 7.1579 18.8421H16.8421C17.9467 18.8421 18.8421 17.9467 18.8421 16.8421V13.7518C18.8421 12.927 19.1817 12.1387 19.7809 11.572L20.9878 10.4308C21.3703 10.0691 22 10.3403 22 10.8668V19.3684C22 20.8218 20.8218 22 19.3684 22H4.63158C3.1782 22 2 20.8218 2 19.3684V4.63158Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M10.9256 11.1882C10.5351 10.7977 10.5351 10.1645 10.9256 9.77397L18.0669 2.6327C18.8479 1.85165 20.1143 1.85165 20.8953 2.6327L21.3665 3.10391C22.1476 3.88496 22.1476 5.15129 21.3665 5.93234L14.2252 13.0736C13.8347 13.4641 13.2016 13.4641 12.811 13.0736L10.9256 11.1882Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M8.82343 12.0064L8.08852 14.3348C7.8655 15.0414 8.46151 15.7366 9.19388 15.6242L11.8974 15.2092C12.4642 15.1222 12.6916 14.4278 12.2861 14.0223L9.98595 11.7221C9.61452 11.3507 8.98154 11.5055 8.82343 12.0064Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                        </a>
                        <a href="#" class="btn btn-sm btn-icon btn-clear btn-active-light-primary"
                            data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Settings"
                            data-bs-original-title="Settings" data-kt-initialized="1">
                            <span class="svg-icon svg-icon-2 m-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="10" y="10" width="4" height="4" rx="2"
                                        fill="currentColor"></rect>
                                    <rect x="10" y="3" width="4" height="4" rx="2"
                                        fill="currentColor"></rect>
                                    <rect x="10" y="17" width="4" height="4" rx="2"
                                        fill="currentColor"></rect>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
