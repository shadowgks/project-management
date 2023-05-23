<div id="live-component">
    <div id="kt_app_content_container" class="app-container container-xxl mt-5" bis_skin_checked="1"
        data-select2-id="select2-data-kt_app_content_container">

        <div class="d-flex flex-wrap flex-stack mb-6" bis_skin_checked="1" data-select2-id="select2-data-123-etjz">
            <h3 class="fw-bold my-2 ">
                {{ __('Contacts') }}
                <span class="fs-6 fw-semibold ms-1">({{ $base_data['contacts_count'] }})</span>
            </h3>
        </div>

        <div class="row g-6 g-xl-9" bis_skin_checked="1">
            @foreach ($base_data['contacts'] as $contact)
                <div class="col-md-6 col-xxl-4" bis_skin_checked="1">
                    <div class="card" bis_skin_checked="1">
                        <div class="card-body d-flex flex-center flex-column p-9" bis_skin_checked="1">
                            <div class="mb-5" bis_skin_checked="1">
                                <div class="symbol symbol-75px symbol-circle" bis_skin_checked="1">
                                    @if (empty($contact['image_name']))
                                        @php
                                            $random_color = getRandomColorValue();
                                        @endphp
                                        <span
                                            class="symbol-label bg-{{ $random_color['background'] }} text-{{ $random_color['text'] }} fs-2 fw-bolder">{{ \Str::substr($contact['last_name'], 0, 1) }}</span>
                                    @else
                                        <img alt="Pic" src="/metronic8/demo1/assets/media/avatars/300-6.jpg">
                                    @endif

                                    @if (!empty($contact['last_seen']))
                                        <div class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n3 mt-n3"
                                            bis_skin_checked="1"></div>
                                    @endif
                                </div>
                            </div>

                            <a href="#"
                                class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0">{{ $contact['first_name'] . ' ' . $contact['last_name'] }}</a>
                            <a href="mailto:{{ $contact['email'] }}"
                                class="fw-semibold text-gray-400 mb-6">{{ $contact['email'] }}
                            </a>

                            <a href="{{ asset('chat/' . $contact['id']) }}" class="btn btn-sm btn-light-primary fw-bold"
                                data-kt-drawer-show="true">
                                {{ __('Send Message') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex flex-stack flex-wrap pt-10" bis_skin_checked="1">
            <div class="fs-6 fw-semibold text-gray-700" bis_skin_checked="1">
                Showing 12 of {{ $base_data['contacts_count'] }} entries
            </div>

            <ul class="pagination">
                <li class="page-item previous {{ $options['current_page'] == 1 ? 'disabled' : '' }}">
                    <button class="page-link" {{ $options['current_page'] == 1 ? 'disabled' : '' }}
                        wire:click="actionPaginate('prev')"><i class="previous"></i></button>
                </li>

                @for ($i = 1; $i <= $options['pages']; $i++)
                    <li class="page-item {{ $options['current_page'] == $i ? 'active' : '' }}">
                        <button class="page-link"
                            wire:click="actionPaginate({{ $i }})">{{ $i }}</button>
                    </li>
                @endfor

                <li class="page-item next {{ $options['current_page'] == $options['pages'] ? 'disabled' : '' }}">
                    <button class="page-link" {{ $options['current_page'] == $options['pages'] ? 'disabled' : '' }}
                        wire:click="actionPaginate('next')"><i class="next"></i></button>
                </li>
            </ul>
        </div>
    </div>
</div>
