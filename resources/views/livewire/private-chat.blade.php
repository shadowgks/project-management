@php
    use App\Models\ChatConversation;
@endphp

<div id="live-component">
    <div id="kt_app_content" class="app-content h-100 flex-column-fluid mt-6">
        <div id="kt_app_content_container" class="app-container h-100 container-xxl">
            <div class="d-flex flex-column flex-lg-row">
                <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
                    <div class="card card-flush">
                        <!-- NOTE - Search -->
                        <div class="card-header pt-7" id="kt_chat_contacts_header">
                            <div class="w-100 position-relative" autocomplete="off">
                                <span
                                    class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y"><svg
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                            height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                            fill="currentColor"></rect>
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>

                                <input type="text" class="form-control form-control-solid px-15" name="search"
                                    placeholder="{{ __('Search by username or email...') }}"
                                    wire:model.lazy="values.search" wire:keydown.enter="searchConversation">
                            </div>
                        </div>

                        <div class="card-body pt-5" id="kt_chat_contacts_body">
                            <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true"
                                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                                data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_toolbar, #kt_app_toolbar, #kt_footer, #kt_app_footer, #kt_chat_contacts_header"
                                data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_contacts_body"
                                data-kt-scroll-offset="5px" style="max-height: 400px;">

                                @if ($base_data['conversations_count'] > 0)
                                    @foreach ($base_data['conversations'] as $key => $conversation)
                                        @php
                                            $count_messages = count($conversation['messages']);
                                            $to_user_name = ChatConversation::getToUserName($conversation);
                                        @endphp

                                        <a class="d-flex flex-stack px-4 py-4 my-2 rounded-4 conversation {{ $values['current_conversation_id'] == $conversation['id'] ? 'active' : '' }}"
                                            style="transition: background-color 0.2s ease;"
                                            wire:click="getMessagesOfConversation({{ $conversation['id'] }})">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-45px symbol-circle">
                                                    <img src="{{ asset_avatar('') }}" alt="{{ $to_user_name }}">
                                                </div>
                                                <div class="ms-5">
                                                    <span
                                                        class="conversation-title fs-5 fw-bold text-gray-900 mb-2">{{ $to_user_name }}</span>
                                                    <div class="fw-semibold text-muted">
                                                        {{ $count_messages > 0 ? $conversation['messages'][0]['content'] : '' }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column align-items-end ms-2">
                                                @if ($count_messages > 0)
                                                    <span
                                                        class="text-muted fs-7 mb-1">{{ _dfh($conversation['messages'][0]['created_at']) }}</span>
                                                    <span
                                                        class="badge badge-sm badge-circle badge-light-success">6</span>
                                                @endif
                                            </div>
                                        </a>

                                        @if ($key < $base_data['conversations_count'] - 1)
                                            <div class="separator separator-dashed d-none"></div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="w-100 d-flex flex-row align-items-center justify-content-center">
                                        <svg id="SvgjsSvg1190" class="m-2" width="80" height="80"
                                            xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            xmlns:svgjs="http://svgjs.com/svgjs">
                                            <defs id="SvgjsDefs1191"></defs>
                                            <g id="SvgjsG1192"><svg xmlns="http://www.w3.org/2000/svg"
                                                    enable-background="new 0 0 50 50" viewBox="0 0 50 50" width="80"
                                                    height="80">
                                                    <path fill="#ffb567"
                                                        d="M46.9,23.1L38.2,27c-0.1-0.8-1.3-2.1-1.6-2.5c-0.6-0.7-0.5-1.4-0.5-1.4c0.4-2.2-3.5-1.8-3.5-1.8
				c-1.9-0.4-1.2-1.7-1.2-1.7c0.5-1-0.5-1.3-0.5-1.3c-0.2-0.4,0.5-0.8,0.5-0.8c-0.5-0.1-0.7-0.4-0.7-0.4c0.6-1.5-0.3-1.6-0.3-1.6
				c-1.6-0.7-0.2-1.7,1.3-3.5C30.9,9.7,33,6.4,33,6.4l1.7-1.9L36.8,3l7,1.6l1.8,6.5l0.3,7.4C45.2,20.7,46.9,23.1,46.9,23.1z"
                                                        class="colorFFCA67 svgShape"></path>
                                                    <path fill="#595bd4"
                                                        d="M45.9,18.5L42.9,19c2.8-8.1-0.7-8.3-0.7-8.3c-1.1-0.5-3.7,1.7-3.7,1.7h-0.7C38.4,9.9,35.6,9,37,5.9
				c0.2-0.5,0.4-1,0.4-1C36.6,4.6,33,6.4,33,6.4c-1.6-8.2,12.9-5.7,15-1.9C51.1,9.9,45.9,18.5,45.9,18.5z"
                                                        class="color444445 svgShape"></path>
                                                    <path fill="#167ffc"
                                                        d="M26.6,3.2v13.3c0,0.7-0.7,1.1-1.3,0.7l-2.8-1.7H7.8c-0.5,0-0.9-0.4-0.9-0.9V3.2c0-0.5,0.4-0.8,0.9-0.8h18
			C26.3,2.3,26.6,2.7,26.6,3.2z"
                                                        class="color59B1E3 svgShape"></path>
                                                    <path fill="#fe9526"
                                                        d="M43.5,30.6V42c0,0.5-0.4,0.8-0.8,0.8H27.9l-2.8,1.7c-0.6,0.3-1.3-0.1-1.3-0.7V30.6c0-0.5,0.4-0.9,0.9-0.9
			h18C43.1,29.7,43.5,30.1,43.5,30.6z"
                                                        class="colorE9715F svgShape"></path>
                                                    <path fill="#ffb567"
                                                        d="M20.2,37.2c0,0-1.1,0.1-1,0.7c0,0,0.4,1.4-0.5,1.5c0,0,1,0.8,0.2,1.3c0,0-0.5,0.3,0,1.4
				c0,0,0.3,2.2-2,1.8c0,0-2.1-0.3-2.3,0.5c0,0-1.3,3.4-1.3,4.6l-9.7-3.3c0,0,2.1-2.4,0.8-5.7l2.3-12.8l4.6-2.7L15,25l1.6,1l0.5,1.1
				c0,0,0.9,0.7,0.7,2.3c-0.1,0.8,0.6,1.4,1,2.6c0.3,0.8-0.6,1,0.1,2.2l1.3,1.8C20.2,36,21.2,36.8,20.2,37.2z"
                                                        class="colorFFCA67 svgShape"></path>
                                                    <path fill="#595bd4"
                                                        d="M17.2,27.2c-2.1-1.5-3.9-0.8-3.9-0.8c2.5,1.9,0,5.7,0,5.7c-0.5,0.8-0.4,3.4-0.4,3.4h-1.1l-0.9-2
				c-4.2-2.3-4.5,3.6-4.5,3.6c-0.5,3.1-2,2.8-2,2.8c-2.1-2-4.5-7.8-2.6-11.9c3.5-7.8,13.9-4.2,14.3-4.3
				C19.1,25.1,17.2,27.2,17.2,27.2z"
                                                        class="color444445 svgShape"></path>
                                                    <path fill="#53d86a"
                                                        d="M24 6.2h-8.8c-.2 0-.4-.2-.4-.4 0-.2.2-.4.4-.4H24c.2 0 .4.2.4.4C24.4 6 24.2 6.2 24 6.2zM12.7 6.2H9.6C9.4 6.2 9.2 6 9.2 5.8c0-.2.2-.4.4-.4h3.1c.2 0 .4.2.4.4C13.2 6 13 6.2 12.7 6.2zM24 9.3h-4.2c-.2 0-.4-.2-.4-.4s.2-.4.4-.4H24c.2 0 .4.2.4.4S24.2 9.3 24 9.3zM17.2 9.3H9.6c-.2 0-.4-.2-.4-.4s.2-.4.4-.4h7.6c.2 0 .4.2.4.4S17.5 9.3 17.2 9.3zM24 12.4h-8.2c-.2 0-.4-.2-.4-.4s.2-.4.4-.4H24c.2 0 .4.2.4.4S24.2 12.4 24 12.4zM13.7 12.4H9.6c-.2 0-.4-.2-.4-.4s.2-.4.4-.4h4.1c.2 0 .4.2.4.4S14 12.4 13.7 12.4zM40.8 33.6H32c-.2 0-.4-.2-.4-.4s.2-.4.4-.4h8.8c.2 0 .4.2.4.4S41 33.6 40.8 33.6zM29.6 33.6h-3.1c-.2 0-.4-.2-.4-.4s.2-.4.4-.4h3.1c.2 0 .4.2.4.4S29.8 33.6 29.6 33.6zM40.8 36.7h-4.2c-.2 0-.4-.2-.4-.4s.2-.4.4-.4h4.2c.2 0 .4.2.4.4S41 36.7 40.8 36.7zM34.1 36.7h-7.6c-.2 0-.4-.2-.4-.4s.2-.4.4-.4h7.6c.2 0 .4.2.4.4S34.3 36.7 34.1 36.7zM40.8 39.8h-8.2c-.2 0-.4-.2-.4-.4 0-.2.2-.4.4-.4h8.2c.2 0 .4.2.4.4C41.2 39.6 41 39.8 40.8 39.8zM30.6 39.8h-4.1c-.2 0-.4-.2-.4-.4 0-.2.2-.4.4-.4h4.1c.2 0 .4.2.4.4C31 39.6 30.8 39.8 30.6 39.8z"
                                                        class="colorE4E4E3 svgShape"></path>
                                                </svg></g>
                                        </svg>

                                        <div class="d-flex flex-column">
                                            <span class="fs-3 fw-bold text-dark">{{ __('No conversations') }}</span>
                                            <span
                                                class="text-gray-400 mt-1 fw-semibold fs-6">{{ __('You have no active conversations') }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="flex-lg-row-fluid ms-lg-7 ms-xl-10 {{ $values['current_conversation_id'] == null ? 'bg-white' : '' }}">
                    <div class="card" id="kt_chat_messenger">
                        <div class="card-header {{ $values['current_conversation_id'] == null ? 'hidden' : '' }}"
                            id="kt_chat_messenger_header">
                            <div class="card-title">
                                <div class="d-flex justify-content-center flex-column me-3">
                                    <a href="#"
                                        class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">{{ ChatConversation::getToUserName($values['current_conversation']) }}</a>

                                    <div class="mb-0 lh-1">
                                        <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                                        <span class="fs-7 fw-semibold text-muted">{{ __('Active') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-toolbar">
                                <div class="me-n3">
                                    <button class="btn btn-sm btn-icon btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots fs-2"></i>
                                    </button>

                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                Contacts
                                            </div>
                                        </div>

                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_users_search">
                                                Add Contact
                                            </a>
                                        </div>

                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link flex-stack px-3"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
                                                Invite Contacts

                                                <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                    data-bs-toggle="tooltip"
                                                    aria-label="Specify a contact email to send an invitation"
                                                    data-bs-original-title="Specify a contact email to send an invitation"
                                                    data-kt-initialized="1"></i>
                                            </a>
                                        </div>

                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                            data-kt-menu-placement="right-start">
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">Groups</span>
                                                <span class="menu-arrow"></span>
                                            </a>

                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                                        data-bs-original-title="Coming soon" data-kt-initialized="1">
                                                        Create Group
                                                    </a>
                                                </div>

                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                                        data-bs-original-title="Coming soon" data-kt-initialized="1">
                                                        Invite Members
                                                    </a>
                                                </div>

                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                                        data-bs-original-title="Coming soon" data-kt-initialized="1">
                                                        Settings
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="menu-item px-3 my-1">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="tooltip"
                                                data-bs-original-title="Coming soon" data-kt-initialized="1">
                                                Settings
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body {{ $values['current_conversation_id'] == null ? 'hidden' : '' }}"
                            id="kt_chat_messenger_body">
                            <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto d-flex flex-column-reverse"
                                data-kt-element="messages" data-kt-scroll="true"
                                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                                data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                                data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body"
                                data-kt-scroll-offset="5px" style="max-height: 252px;">

                                @if ($base_data['messages_count'] > 0)
                                    @foreach ($base_data['messages'] as $message)
                                        @if ($message['user_id'] == $base_data['user_id'])
                                            <div class="d-flex justify-content-end mb-10 ">
                                                <div class="d-flex flex-column align-items-end">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="me-3">
                                                            <span
                                                                class="text-muted fs-7 mb-1">{{ _dfh($message['created_at']) }}</span>
                                                            <a href="#"
                                                                class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">{{ __('You') }}</a>
                                                        </div>

                                                        <div class="symbol symbol-35px symbol-circle">
                                                            <img src="{{ asset_avatar('') }}"
                                                                alt="{{ __('You') }}">
                                                        </div>
                                                    </div>

                                                    <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end"
                                                        data-kt-element="message-text">{{ $message['content'] }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex justify-content-start mb-10 ">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="symbol  symbol-35px symbol-circle ">
                                                            <img src="{{ asset_avatar('') }}"
                                                                alt="{{ $message['created_by'] == null ? '-' : $message['created_by']['first_name'] . ' ' . $message['created_by']['last_name'] }}">
                                                        </div>
                                                        <div class="ms-3">
                                                            <a href="#"
                                                                class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">{{ $message['created_by'] == null ? '-' : $message['created_by']['first_name'] . ' ' . $message['created_by']['last_name'] }}</a>
                                                            <span
                                                                class="text-muted fs-7 mb-1">{{ _dfh($message['created_at']) }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start"
                                                        data-kt-element="message-text">{{ $message['content'] }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div
                                        class="w-100 p-10 d-flex flex-column align-items-center justify-content-center">
                                        <svg id="SvgjsSvg1167" width="150" height="150"
                                            xmlns="http://www.w3.org/2000/svg" version="1.1"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            xmlns:svgjs="http://svgjs.com/svgjs">
                                            <defs id="SvgjsDefs1168"></defs>
                                            <g id="SvgjsG1169"><svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 132 132" width="150" height="150">
                                                    <circle cx="66" cy="66" r="64"
                                                        fill="#595bd4" class="color705C85 svgShape"></circle>
                                                    <g fill="#167ffc" class="color5F4D77 svgShape">
                                                        <path
                                                            d="M52.036 74.785c0 11.235 11.947 20.343 26.684 20.343 1.932 0 3.822-.156 5.638-.459 8.985 5.59 20.237 2.185 20.237 2.185-3.388-2.226-5.597-5.196-6.972-7.708 4.811-3.682 7.782-8.756 7.782-14.361 0-11.227-11.947-20.343-26.685-20.343s-26.684 9.116-26.684 20.343z"
                                                            fill="#000000" class="color000 svgShape"></path>
                                                        <path
                                                            d="M102.282 95.073c.701.623 1.469 1.224 2.314 1.78 0 0-11.257 3.403-20.233-2.18a34.77 34.77 0 0 1-5.64.456c-9.209 0-17.329-3.56-22.122-8.977 4.882 4.338 12.135 7.086 20.221 7.086 1.935 0 3.826-.156 5.64-.467 7.952 4.95 17.696 2.847 19.82 2.302zm-6.551-7.82c4.805-3.681 7.775-8.753 7.775-14.36 0-4.204-1.669-8.119-4.55-11.356 4.016 3.549 6.452 8.187 6.452 13.248 0 5.606-2.97 10.678-7.786 14.36a22.586 22.586 0 0 0 2.914 4.16c-2.202-1.925-3.76-4.116-4.805-6.051z"
                                                            fill="#000000" class="color000 svgShape"></path>
                                                        <path
                                                            d="M97.402 57.64c0 15.271-16.24 27.65-36.272 27.65-2.625 0-5.195-.21-7.664-.622-12.213 7.597-27.507 2.97-27.507 2.97 4.605-3.026 7.608-7.063 9.477-10.478-6.54-5.005-10.578-11.902-10.578-19.52 0-15.261 16.24-27.652 36.272-27.652s36.272 12.39 36.272 27.651z"
                                                            fill="#000000" class="color000 svgShape"></path>
                                                        <path
                                                            d="M97.402 57.64c0 15.271-16.24 27.65-36.272 27.65-2.625 0-5.195-.21-7.664-.622-12.213 7.597-27.507 2.97-27.507 2.97a27.11 27.11 0 0 0 2.503-1.869c5.55.69 14.426.734 22.079-4.026 2.469.411 5.038.623 7.663.623 20.033 0 36.272-12.38 36.272-27.652 0-5.617-2.202-10.856-5.995-15.227 5.55 4.86 8.92 11.2 8.92 18.152z"
                                                            fill="#000000" class="color000 svgShape"></path>
                                                        <circle cx="42.248" cy="57.318" r="4.677"
                                                            fill="#000000" class="color000 svgShape"></circle>
                                                        <circle cx="61.13" cy="57.318" r="4.677"
                                                            fill="#000000" class="color000 svgShape"></circle>
                                                        <circle cx="80.012" cy="57.318" r="4.677"
                                                            fill="#000000" class="color000 svgShape"></circle>
                                                        <path
                                                            d="M76.264 37.797a.83.83 0 0 1-.32-.063 37.455 37.455 0 0 0-8.78-2.414.836.836 0 0 1-.702-.949.829.829 0 0 1 .95-.7c3.204.48 6.29 1.328 9.172 2.521a.834.834 0 0 1-.32 1.605zm-35.33 2.607a.834.834 0 0 1-.445-1.54c5.798-3.649 13.128-5.658 20.64-5.658a.834.834 0 0 1 0 1.668c-7.2 0-14.216 1.919-19.751 5.402a.828.828 0 0 1-.443.128zM29.964 54.442a.833.833 0 0 1-.81-1.04c1.09-4.275 3.638-8.28 7.37-11.58a.835.835 0 0 1 1.106 1.25c-3.481 3.078-5.852 6.792-6.86 10.742a.834.834 0 0 1-.806.628zm1.451 13.182a.834.834 0 0 1-.748-.464c-1.407-2.844-2.12-5.843-2.12-8.915a.834.834 0 0 1 1.668 0c0 2.813.655 5.563 1.946 8.175a.834.834 0 0 1-.746 1.204z"
                                                            fill="#000000" class="color000 svgShape"></path>
                                                    </g>
                                                    <path fill="#ededed"
                                                        d="M50.181 72.93c0 11.235 11.947 20.343 26.685 20.343 1.93 0 3.821-.156 5.638-.458C91.489 98.404 102.74 95 102.74 95c-3.388-2.226-5.597-5.197-6.972-7.709 4.812-3.682 7.782-8.755 7.782-14.36 0-11.228-11.947-20.343-26.684-20.343S50.18 61.703 50.18 72.93z"
                                                        class="colorEDEDED svgShape"></path>
                                                    <path fill="#53d86a"
                                                        d="M100.428 93.218c.7.623 1.468 1.224 2.313 1.78 0 0-11.256 3.404-20.232-2.18-1.825.3-3.715.456-5.64.456-9.21 0-17.33-3.56-22.123-8.976 4.883 4.338 12.135 7.085 20.221 7.085 1.936 0 3.827-.156 5.64-.467 7.953 4.95 17.696 2.847 19.82 2.302zm-6.552-7.82c4.806-3.68 7.775-8.753 7.775-14.359 0-4.204-1.668-8.12-4.55-11.356 4.016 3.548 6.452 8.186 6.452 13.247 0 5.606-2.97 10.678-7.786 14.36a22.586 22.586 0 0 0 2.915 4.16c-2.203-1.924-3.76-4.116-4.806-6.051z"
                                                        class="colorDDDCE0 svgShape"></path>
                                                    <path fill="#fe9526"
                                                        d="M95.547 55.785c0 15.271-16.24 27.651-36.272 27.651-2.625 0-5.194-.211-7.664-.623-12.213 7.597-27.507 2.97-27.507 2.97 4.605-3.025 7.609-7.063 9.477-10.478-6.54-5.005-10.578-11.901-10.578-19.52 0-15.261 16.24-27.652 36.272-27.652s36.272 12.391 36.272 27.652z"
                                                        class="colorF34B50 svgShape"></path>
                                                    <path fill="#e59139"
                                                        d="M95.547 55.785c0 15.271-16.24 27.651-36.272 27.651-2.625 0-5.194-.211-7.664-.623-12.213 7.597-27.507 2.97-27.507 2.97a27.11 27.11 0 0 0 2.503-1.868c5.55.69 14.426.734 22.08-4.027 2.468.412 5.038.623 7.663.623 20.032 0 36.272-12.38 36.272-27.652 0-5.617-2.203-10.856-5.996-15.227 5.55 4.86 8.92 11.2 8.92 18.153z"
                                                        class="colorE53946 svgShape"></path>
                                                    <circle cx="40.393" cy="55.463" r="4.677"
                                                        fill="#ffffff" class="colorFFF svgShape"></circle>
                                                    <circle cx="59.275" cy="55.463" r="4.677"
                                                        fill="#ffffff" class="colorFFF svgShape"></circle>
                                                    <circle cx="78.157" cy="55.463" r="4.677"
                                                        fill="#ffffff" class="colorFFF svgShape"></circle>
                                                    <path fill="#ffb86c"
                                                        d="M74.41 35.943a.829.829 0 0 1-.32-.064 37.455 37.455 0 0 0-8.78-2.413.836.836 0 0 1-.703-.95.829.829 0 0 1 .95-.7c3.204.48 6.29 1.329 9.172 2.522a.834.834 0 0 1-.32 1.605zM39.08 38.55a.834.834 0 0 1-.445-1.54c5.797-3.65 13.128-5.659 20.64-5.659a.834.834 0 0 1 0 1.669c-7.201 0-14.216 1.918-19.752 5.402a.828.828 0 0 1-.443.128zM28.108 52.588a.833.833 0 0 1-.81-1.04c1.09-4.276 3.639-8.28 7.371-11.58a.835.835 0 0 1 1.106 1.25c-3.482 3.077-5.853 6.792-6.86 10.741a.834.834 0 0 1-.807.629zm1.451 13.181a.834.834 0 0 1-.748-.464c-1.407-2.844-2.12-5.843-2.12-8.915a.834.834 0 0 1 1.668 0c0 2.813.655 5.563 1.947 8.175a.834.834 0 0 1-.747 1.204z"
                                                        class="colorFF6C77 svgShape"></path>
                                                </svg></g>
                                        </svg>

                                        <span class="fs-3 fw-bold text-dark">{{ __('No messages') }}</span>
                                        <span
                                            class="text-gray-400 mt-1 fw-semibold fs-6">{{ __('You have no active chats') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer {{ $values['current_conversation_id'] == null ? 'hidden' : '' }} pt-4"
                            id="kt_chat_messenger_footer">
                            {{-- <textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input"
                                placeholder="Type a message" wire:model="values.content"></textarea> --}}
                            <input type="text" class="form-control form-control-flush mb-3"
                                placeholder="Type a message" wire:model.lazy="values.content"
                                wire:keydown.enter="saveMessage" />

                            <div class="d-flex flex-stack">
                                <div class="d-flex align-items-center me-2">
                                    <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button"
                                        data-bs-toggle="tooltip" aria-label="Coming soon"
                                        data-bs-original-title="Coming soon" data-kt-initialized="1"><i
                                            class="bi bi-paperclip fs-3"></i></button>
                                    <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button"
                                        data-bs-toggle="tooltip" aria-label="Coming soon"
                                        data-bs-original-title="Coming soon" data-kt-initialized="1"><i
                                            class="bi bi-upload fs-3"></i></button>
                                </div>

                                <button class="btn btn-primary" type="button" data-kt-element="send"
                                    wire:click="saveMessage">{{ __('Send') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="kt_modal_view_users" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog mw-650px">
                    <div class="modal-content">
                        <div class="modal-header pb-0 border-0 justify-content-end">
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <span class="svg-icon svg-icon-1"><svg width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16"
                                            height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                            fill="currentColor"></rect>
                                        <rect x="7.41422" y="6" width="16" height="2"
                                            rx="1" transform="rotate(45 7.41422 6)" fill="currentColor">
                                        </rect>
                                    </svg>

                                </span>
                            </div>
                        </div>

                        <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                            <div class="text-center mb-13">
                                <h1 class="mb-3">Browse Users</h1>

                                <div class="text-muted fw-semibold fs-5">
                                    If you need more info, please check out our
                                    <a href="#" class="link-primary fw-bold">Users Directory</a>.
                                </div>
                            </div>

                            <div class="mb-15">
                                <div class="mh-375px scroll-y me-n7 pe-7">
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic"
                                                    src="/metronic8/demo1/assets/media/avatars/300-6.jpg">
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Emma Smith

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        Art Director </span>
                                                </a>

                                                <div class="fw-semibold text-muted">smith@kpmg.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$23,000</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-danger text-danger fw-semibold">
                                                    M </span>
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Melody Macy

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        Marketing Analytic </span>
                                                </a>

                                                <div class="fw-semibold text-muted">melody@altbox.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$50,500</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic"
                                                    src="/metronic8/demo1/assets/media/avatars/300-1.jpg">
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Max Smith

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        Software Enginer </span>
                                                </a>

                                                <div class="fw-semibold text-muted">max@kt.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$75,900</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic"
                                                    src="/metronic8/demo1/assets/media/avatars/300-5.jpg">
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Sean Bean

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        Web Developer </span>
                                                </a>

                                                <div class="fw-semibold text-muted">sean@dellito.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$10,500</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic"
                                                    src="/metronic8/demo1/assets/media/avatars/300-25.jpg">
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Brian Cox

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        UI/UX Designer </span>
                                                </a>

                                                <div class="fw-semibold text-muted">brian@exchange.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$20,000</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-warning text-warning fw-semibold">
                                                    C </span>
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Mikaela Collins

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        Head Of Marketing </span>
                                                </a>

                                                <div class="fw-semibold text-muted">mik@pex.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$9,300</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic"
                                                    src="/metronic8/demo1/assets/media/avatars/300-9.jpg">
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Francis Mitcham

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        Software Arcitect </span>
                                                </a>

                                                <div class="fw-semibold text-muted">f.mit@kpmg.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$15,000</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-danger text-danger fw-semibold">
                                                    O </span>
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Olivia Wild

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        System Admin </span>
                                                </a>

                                                <div class="fw-semibold text-muted">olivia@corpmail.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$23,000</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-primary text-primary fw-semibold">
                                                    N </span>
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Neil Owen

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        Account Manager </span>
                                                </a>

                                                <div class="fw-semibold text-muted">owen.neil@gmail.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$45,800</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic"
                                                    src="/metronic8/demo1/assets/media/avatars/300-23.jpg">
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Dan Wilson

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        Web Desinger </span>
                                                </a>

                                                <div class="fw-semibold text-muted">dam@consilting.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$90,500</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-danger text-danger fw-semibold">
                                                    E </span>
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Emma Bold

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        Corporate Finance </span>
                                                </a>

                                                <div class="fw-semibold text-muted">emma@intenso.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$5,000</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <img alt="Pic"
                                                    src="/metronic8/demo1/assets/media/avatars/300-12.jpg">
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Ana Crown

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        Customer Relationship </span>
                                                </a>

                                                <div class="fw-semibold text-muted">ana.cf@limtel.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$70,000</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-stack py-5 ">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-info text-info fw-semibold">
                                                    A </span>
                                            </div>

                                            <div class="ms-6">
                                                <a href="#"
                                                    class="d-flex align-items-center fs-5 fw-bold text-dark text-hover-primary">
                                                    Robert Doe

                                                    <span class="badge badge-light fs-8 fw-semibold ms-2">
                                                        Marketing Executive </span>
                                                </a>

                                                <div class="fw-semibold text-muted">robert@benko.com</div>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <div class="text-end">
                                                <div class="fs-5 fw-bold text-dark">$45,500</div>

                                                <div class="fs-7 text-muted">Sales</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div class="fw-semibold">
                                    <label class="fs-6">Adding Users by Team Members</label>

                                    <div class="fs-7 text-muted">If you need more info, please check budget planning
                                    </div>
                                </div>

                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value=""
                                        checked="checked">

                                    <span class="form-check-label fw-semibold text-muted">
                                        Allowed
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="kt_modal_users_search" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <div class="modal-content">
                        <div class="modal-header pb-0 border-0 justify-content-end">
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <span class="svg-icon svg-icon-1"><svg width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16"
                                            height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                            fill="currentColor"></rect>
                                        <rect x="7.41422" y="6" width="16" height="2"
                                            rx="1" transform="rotate(45 7.41422 6)" fill="currentColor">
                                        </rect>
                                    </svg>

                                </span>
                            </div>
                        </div>

                        <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                            <div class="text-center mb-13">
                                <h1 class="mb-3">Search Users</h1>

                                <div class="text-muted fw-semibold fs-5">
                                    Invite Collaborators To Your Project
                                </div>
                            </div>

                            <div id="kt_modal_users_search_handler" data-kt-search-keypress="true"
                                data-kt-search-min-length="2" data-kt-search-enter="enter"
                                data-kt-search-layout="inline" data-kt-search="true">

                                <form data-kt-search-element="form" class="w-100 position-relative mb-5"
                                    autocomplete="off">
                                    <input type="hidden">

                                    <span
                                        class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute top-50 ms-5 translate-middle-y"><svg
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                                fill="currentColor"></rect>
                                            <path
                                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>

                                    <input type="text"
                                        class="form-control form-control-lg form-control-solid px-15" name="search"
                                        value="" placeholder="Search by username, full name or email..."
                                        data-kt-search-element="input">

                                    <span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5"
                                        data-kt-search-element="spinner">
                                        <span class="spinner-border h-15px w-15px align-middle text-muted"></span>
                                    </span>

                                    <span
                                        class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none"
                                        data-kt-search-element="clear">
                                        <span class="svg-icon svg-icon-2 svg-icon-lg-1 me-0"><svg width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                    height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                                    fill="currentColor"></rect>
                                                <rect x="7.41422" y="6" width="16" height="2"
                                                    rx="1" transform="rotate(45 7.41422 6)"
                                                    fill="currentColor"></rect>
                                            </svg>

                                        </span>
                                    </span>
                                </form>

                                <div class="py-5">
                                    <div data-kt-search-element="suggestions">
                                        <h3 class="fw-semibold mb-5">Recently searched:</h3>

                                        <div class="mh-375px scroll-y me-n7 pe-7">
                                            <a href="#"
                                                class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                                <div class="symbol symbol-35px symbol-circle me-5">
                                                    <img alt="Pic"
                                                        src="/metronic8/demo1/assets/media/avatars/300-6.jpg">
                                                </div>

                                                <div class="fw-semibold">
                                                    <span class="fs-6 text-gray-800 me-2">Emma Smith</span>
                                                    <span class="badge badge-light">Art Director</span>
                                                </div>
                                            </a>
                                            <a href="#"
                                                class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                                <div class="symbol symbol-35px symbol-circle me-5">
                                                    <span class="symbol-label bg-light-danger text-danger fw-semibold">
                                                        M </span>
                                                </div>

                                                <div class="fw-semibold">
                                                    <span class="fs-6 text-gray-800 me-2">Melody Macy</span>
                                                    <span class="badge badge-light">Marketing Analytic</span>
                                                </div>
                                            </a>
                                            <a href="#"
                                                class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                                <div class="symbol symbol-35px symbol-circle me-5">
                                                    <img alt="Pic"
                                                        src="/metronic8/demo1/assets/media/avatars/300-1.jpg">
                                                </div>

                                                <div class="fw-semibold">
                                                    <span class="fs-6 text-gray-800 me-2">Max Smith</span>
                                                    <span class="badge badge-light">Software Enginer</span>
                                                </div>
                                            </a>
                                            <a href="#"
                                                class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                                <div class="symbol symbol-35px symbol-circle me-5">
                                                    <img alt="Pic"
                                                        src="/metronic8/demo1/assets/media/avatars/300-5.jpg">
                                                </div>

                                                <div class="fw-semibold">
                                                    <span class="fs-6 text-gray-800 me-2">Sean Bean</span>
                                                    <span class="badge badge-light">Web Developer</span>
                                                </div>
                                            </a>
                                            <a href="#"
                                                class="d-flex align-items-center p-3 rounded bg-state-light bg-state-opacity-50 mb-1">
                                                <div class="symbol symbol-35px symbol-circle me-5">
                                                    <img alt="Pic"
                                                        src="/metronic8/demo1/assets/media/avatars/300-25.jpg">
                                                </div>

                                                <div class="fw-semibold">
                                                    <span class="fs-6 text-gray-800 me-2">Brian Cox</span>
                                                    <span class="badge badge-light">UI/UX Designer</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div data-kt-search-element="results" class="d-none">
                                        <div class="mh-375px scroll-y me-n7 pe-7">
                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="0">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='0']" value="0">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic"
                                                            src="/metronic8/demo1/assets/media/avatars/300-6.jpg">
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma
                                                            Smith</a>

                                                        <div class="fw-semibold text-muted">smith@kpmg.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-10-ozxx" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected=""
                                                            data-select2-id="select2-data-12-lhvg">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-11-uzf8"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-ijhq-container"
                                                                aria-controls="select2-ijhq-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-ijhq-container" role="textbox"
                                                                    aria-readonly="true"
                                                                    title="Owner">Owner</span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="1">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='1']" value="1">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span
                                                            class="symbol-label bg-light-danger text-danger fw-semibold">
                                                            M </span>
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Melody
                                                            Macy</a>

                                                        <div class="fw-semibold text-muted">melody@altbox.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-13-477u" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1" selected=""
                                                            data-select2-id="select2-data-15-bd7k">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-14-4v93"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-hota-container"
                                                                aria-controls="select2-hota-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-hota-container" role="textbox"
                                                                    aria-readonly="true"
                                                                    title="Guest">Guest</span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="2">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='2']" value="2">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic"
                                                            src="/metronic8/demo1/assets/media/avatars/300-1.jpg">
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Max
                                                            Smith</a>

                                                        <div class="fw-semibold text-muted">max@kt.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-16-ymq5" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected=""
                                                            data-select2-id="select2-data-18-fhsr">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-17-1h3q"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-45qx-container"
                                                                aria-controls="select2-45qx-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-45qx-container" role="textbox"
                                                                    aria-readonly="true" title="Can Edit">Can
                                                                    Edit</span><span class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="3">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='3']" value="3">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic"
                                                            src="/metronic8/demo1/assets/media/avatars/300-5.jpg">
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Sean
                                                            Bean</a>

                                                        <div class="fw-semibold text-muted">sean@dellito.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-19-emgj" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected=""
                                                            data-select2-id="select2-data-21-tyz6">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-20-k9zx"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-z6px-container"
                                                                aria-controls="select2-z6px-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-z6px-container" role="textbox"
                                                                    aria-readonly="true"
                                                                    title="Owner">Owner</span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="4">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='4']" value="4">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic"
                                                            src="/metronic8/demo1/assets/media/avatars/300-25.jpg">
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Brian
                                                            Cox</a>

                                                        <div class="fw-semibold text-muted">brian@exchange.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-22-0a6a" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected=""
                                                            data-select2-id="select2-data-24-mwwt">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-23-0opy"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-jls9-container"
                                                                aria-controls="select2-jls9-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-jls9-container" role="textbox"
                                                                    aria-readonly="true" title="Can Edit">Can
                                                                    Edit</span><span class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="5">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='5']" value="5">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span
                                                            class="symbol-label bg-light-warning text-warning fw-semibold">
                                                            C </span>
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Mikaela
                                                            Collins</a>

                                                        <div class="fw-semibold text-muted">mik@pex.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-25-hs65" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected=""
                                                            data-select2-id="select2-data-27-mzbc">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-26-twgu"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-qjls-container"
                                                                aria-controls="select2-qjls-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-qjls-container" role="textbox"
                                                                    aria-readonly="true"
                                                                    title="Owner">Owner</span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="6">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='6']"
                                                            value="6">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic"
                                                            src="/metronic8/demo1/assets/media/avatars/300-9.jpg">
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Francis
                                                            Mitcham</a>

                                                        <div class="fw-semibold text-muted">f.mit@kpmg.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-28-7n5v" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected=""
                                                            data-select2-id="select2-data-30-fl96">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-29-8dyx"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-3q3w-container"
                                                                aria-controls="select2-3q3w-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-3q3w-container" role="textbox"
                                                                    aria-readonly="true" title="Can Edit">Can
                                                                    Edit</span><span class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="7">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='7']"
                                                            value="7">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span
                                                            class="symbol-label bg-light-danger text-danger fw-semibold">
                                                            O </span>
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Olivia
                                                            Wild</a>

                                                        <div class="fw-semibold text-muted">olivia@corpmail.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-31-8y7v" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected=""
                                                            data-select2-id="select2-data-33-gtny">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-32-pwnp"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-bvy9-container"
                                                                aria-controls="select2-bvy9-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-bvy9-container" role="textbox"
                                                                    aria-readonly="true"
                                                                    title="Owner">Owner</span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="8">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='8']"
                                                            value="8">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span
                                                            class="symbol-label bg-light-primary text-primary fw-semibold">
                                                            N </span>
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Neil
                                                            Owen</a>

                                                        <div class="fw-semibold text-muted">owen.neil@gmail.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-34-z2d1" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1" selected=""
                                                            data-select2-id="select2-data-36-8602">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-35-ojqd"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-y3cu-container"
                                                                aria-controls="select2-y3cu-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-y3cu-container" role="textbox"
                                                                    aria-readonly="true"
                                                                    title="Guest">Guest</span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="9">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='9']"
                                                            value="9">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic"
                                                            src="/metronic8/demo1/assets/media/avatars/300-23.jpg">
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Dan
                                                            Wilson</a>

                                                        <div class="fw-semibold text-muted">dam@consilting.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-37-v0xx" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected=""
                                                            data-select2-id="select2-data-39-cjp8">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-38-izsd"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-ekuk-container"
                                                                aria-controls="select2-ekuk-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-ekuk-container" role="textbox"
                                                                    aria-readonly="true" title="Can Edit">Can
                                                                    Edit</span><span class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="10">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='10']"
                                                            value="10">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span
                                                            class="symbol-label bg-light-danger text-danger fw-semibold">
                                                            E </span>
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma
                                                            Bold</a>

                                                        <div class="fw-semibold text-muted">emma@intenso.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-40-zbwu" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected=""
                                                            data-select2-id="select2-data-42-f47r">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-41-0s2q"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-ksfk-container"
                                                                aria-controls="select2-ksfk-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-ksfk-container" role="textbox"
                                                                    aria-readonly="true"
                                                                    title="Owner">Owner</span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="11">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='11']"
                                                            value="11">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic"
                                                            src="/metronic8/demo1/assets/media/avatars/300-12.jpg">
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Ana
                                                            Crown</a>

                                                        <div class="fw-semibold text-muted">ana.cf@limtel.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-43-31r3" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1" selected=""
                                                            data-select2-id="select2-data-45-63qa">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-44-foa9"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-okqu-container"
                                                                aria-controls="select2-okqu-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-okqu-container" role="textbox"
                                                                    aria-readonly="true"
                                                                    title="Guest">Guest</span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="12">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='12']"
                                                            value="12">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span
                                                            class="symbol-label bg-light-info text-info fw-semibold">
                                                            A </span>
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Robert
                                                            Doe</a>

                                                        <div class="fw-semibold text-muted">robert@benko.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-46-2x9c" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected=""
                                                            data-select2-id="select2-data-48-aqj3">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-47-mrg1"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-n4ph-container"
                                                                aria-controls="select2-n4ph-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-n4ph-container" role="textbox"
                                                                    aria-readonly="true" title="Can Edit">Can
                                                                    Edit</span><span class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="13">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='13']"
                                                            value="13">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic"
                                                            src="/metronic8/demo1/assets/media/avatars/300-13.jpg">
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">John
                                                            Miller</a>

                                                        <div class="fw-semibold text-muted">miller@mapple.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-49-cdye" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected=""
                                                            data-select2-id="select2-data-51-s1ib">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-50-8nda"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-7dy9-container"
                                                                aria-controls="select2-7dy9-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-7dy9-container" role="textbox"
                                                                    aria-readonly="true" title="Can Edit">Can
                                                                    Edit</span><span class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="14">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='14']"
                                                            value="14">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span
                                                            class="symbol-label bg-light-success text-success fw-semibold">
                                                            L </span>
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Lucy
                                                            Kunic</a>

                                                        <div class="fw-semibold text-muted">lucy.m@fentech.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-52-ejy9" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2" selected=""
                                                            data-select2-id="select2-data-54-4i0w">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-53-fgjz"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-o1cu-container"
                                                                aria-controls="select2-o1cu-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-o1cu-container" role="textbox"
                                                                    aria-readonly="true"
                                                                    title="Owner">Owner</span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="15">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='15']"
                                                            value="15">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic"
                                                            src="/metronic8/demo1/assets/media/avatars/300-21.jpg">
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Ethan
                                                            Wilder</a>

                                                        <div class="fw-semibold text-muted">ethan@loop.com.au</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-55-l8bw" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1" selected=""
                                                            data-select2-id="select2-data-57-pcpa">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-56-fu3v"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-y2i0-container"
                                                                aria-controls="select2-y2i0-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-y2i0-container" role="textbox"
                                                                    aria-readonly="true"
                                                                    title="Guest">Guest</span><span
                                                                    class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-gray-300 border-bottom-dashed"></div>

                                            <div class="rounded d-flex flex-stack bg-active-lighten p-4"
                                                data-user-id="16">
                                                <div class="d-flex align-items-center">
                                                    <label class="form-check form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="users" data-kt-check="true"
                                                            data-kt-check-target="[data-user-id='16']"
                                                            value="16">
                                                    </label>

                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <span
                                                            class="symbol-label bg-light-danger text-danger fw-semibold">
                                                            E </span>
                                                    </div>

                                                    <div class="ms-5">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma
                                                            Bold</a>

                                                        <div class="fw-semibold text-muted">emma@intenso.com</div>
                                                    </div>
                                                </div>

                                                <div class="ms-2 w-100px">
                                                    <select
                                                        class="form-select form-select-solid form-select-sm select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-select2-id="select2-data-58-gijs" tabindex="-1"
                                                        aria-hidden="true" data-kt-initialized="1">
                                                        <option value="1">Guest</option>
                                                        <option value="2">Owner</option>
                                                        <option value="3" selected=""
                                                            data-select2-id="select2-data-60-giic">Can Edit</option>
                                                    </select><span
                                                        class="select2 select2-container select2-container--bootstrap5"
                                                        dir="ltr" data-select2-id="select2-data-59-ifnv"
                                                        style="width: 100%;"><span class="selection"><span
                                                                class="select2-selection select2-selection--single form-select form-select-solid form-select-sm"
                                                                role="combobox" aria-haspopup="true"
                                                                aria-expanded="false" tabindex="0"
                                                                aria-disabled="false"
                                                                aria-labelledby="select2-fk1z-container"
                                                                aria-controls="select2-fk1z-container"><span
                                                                    class="select2-selection__rendered"
                                                                    id="select2-fk1z-container" role="textbox"
                                                                    aria-readonly="true" title="Can Edit">Can
                                                                    Edit</span><span class="select2-selection__arrow"
                                                                    role="presentation"><b
                                                                        role="presentation"></b></span></span></span><span
                                                            class="dropdown-wrapper"
                                                            aria-hidden="true"></span></span>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="d-flex flex-center mt-15">
                                            <button type="reset" id="kt_modal_users_search_reset"
                                                data-bs-dismiss="modal" class="btn btn-active-light me-3">
                                                Cancel
                                            </button>

                                            <button type="submit" id="kt_modal_users_search_submit"
                                                class="btn btn-primary">
                                                Add Selected Users
                                            </button>
                                        </div>
                                    </div>
                                    <div data-kt-search-element="empty" class="text-center d-none">
                                        <div class="fw-semibold py-10">
                                            <div class="text-gray-600 fs-3 mb-2">No users found</div>

                                            <div class="text-muted fs-6">Try to search by username, full name or
                                                email...</div>
                                        </div>

                                        <div class="text-center px-5">
                                            <img src="/metronic8/demo1/assets/media/illustrations/sketchy-1/1.png"
                                                alt="" class="w-100 h-200px h-sm-325px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
