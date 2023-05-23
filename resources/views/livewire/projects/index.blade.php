@section('title', 'Project builder')

<div class="card card-flush">
    <div class="card-body">
        <!-- NOTE - App body -->
        <div class="app-content flex-column-fluid">
            <div class="app-container container-fluid">
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
                    data-kt-stepper="true">
                    <!-- NOTE - Steps header -->
                    <div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
                        <div class="stepper-nav ps-lg-10">
                            <div class="stepper-item {{ $options['selected_step'] == 1 ? 'current' : '' }} {{ $options['selected_step'] > 1 ? 'completed' : '' }}"
                                data-kt-stepper-element="nav">
                                <div class="stepper-wrapper">
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">1</span>
                                    </div>
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">{{ __('Details') }}</h3>
                                        <div class="stepper-desc">Name and details</div>
                                    </div>
                                </div>
                                <div class="stepper-line h-40px"></div>
                            </div>

                            <div class="stepper-item {{ $options['selected_step'] == 2 ? 'current' : '' }} {{ $options['selected_step'] > 2 ? 'completed' : '' }}"
                                data-kt-stepper-element="nav">
                                <div class="stepper-wrapper">
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">2</span>
                                    </div>
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">{{ __('Database') }}</h3>
                                        <div class="stepper-desc">Config database</div>
                                    </div>
                                </div>
                                <div class="stepper-line h-40px"></div>
                            </div>

                            <div class="stepper-item {{ $options['selected_step'] == 3 ? 'current' : '' }} mark-completed"
                                data-kt-stepper-element="nav">
                                <div class="stepper-wrapper">
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">3</span>
                                    </div>
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">{{ __('Completed') }}</h3>
                                        <div class="stepper-desc">Preview and Save</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- NOTE - Steps body -->
                    <div class="flex-row-fluid py-lg-5 px-lg-15">
                        <div class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate"
                            id="kt_modal_create_app_form">
                            <div class="{{ $options['selected_step'] == 1 ? 'current' : 'pending' }}"
                                data-kt-stepper-element="content">
                                <div class="w-100">
                                    @include('livewire.projects.steps.details')
                                </div>
                            </div>

                            <div class="{{ $options['selected_step'] == 2 ? 'current' : 'pending' }}"
                                data-kt-stepper-element="content">
                                <div class="w-100">
                                    @include('livewire.projects.steps.database')
                                </div>
                            </div>

                            <div class="{{ $options['selected_step'] == 3 ? 'current' : 'pending' }}"
                                data-kt-stepper-element="content">
                                <div class="w-100 text-center">
                                    <h1 class="fw-bold text-dark mb-3">Release!</h1>
                                    <div class="text-muted fw-semibold fs-3">Submit your app to kickstart your
                                        project.
                                    </div>
                                    <div class="text-center px-4 py-15">
                                        <img src="/metronic8/demo1/assets/media/illustrations/sketchy-1/9.png"
                                            alt="" class="mw-100 mh-300px">
                                    </div>
                                </div>
                            </div>

                            <!-- NOTE - Actions -->
                            <div class="d-flex flex-stack pt-10">
                                <div class="me-2">
                                    @if ($options['selected_step'] > 1)
                                        <button type="button" class="btn btn-lg btn-light-primary me-3"
                                            wire:click="action_step('previous')">
                                            <span class="svg-icon svg-icon-3 me-1">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="6" y="11" width="13"
                                                        height="2" rx="1" fill="currentColor"></rect>
                                                    <path
                                                        d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>{{ __('Back') }}
                                        </button>
                                    @endif
                                </div>

                                <div>
                                    @if ($options['selected_step'] == 3)
                                        <button type="button" class="btn btn-lg btn-success px-4 me-1"
                                            wire:click="save_modal">
                                            {{ __('Save') }}
                                        </button>
                                    @endif

                                    <button type="button" class="btn btn-lg btn-danger" wire:click="cancel">
                                        {{ __('Cancel') }}
                                    </button>

                                    @if ($options['selected_step'] < 3)
                                        <button type="button" class="btn btn-lg btn-primary"
                                            wire:click="action_step('next')">Continue
                                            <span class="svg-icon svg-icon-3 ms-1 me-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="18" y="13" width="13"
                                                        height="2" rx="1" transform="rotate(-180 18 13)"
                                                        fill="currentColor"></rect>
                                                    <path
                                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
