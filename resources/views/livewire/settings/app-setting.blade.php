<div>
    <div class="row me-0">
        {{-- <x-settingsHeader /> --}}
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Menu') }}</h3>
                </div>

                <div class="card-body">
                    <div class="row m-0">
                        @foreach ($base_data['menuElements'] as $key => $element)
                            <button
                                class="btn btn-light-primary w-100 mb-2 {{ $key == $options['selectedTab'] ? 'active' : '' }}"
                                wire:click="select_tab({{ $key }})">{{ __($element['name']) }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                    data-bs-target="#kt_account_profile_details" aria-expanded="true"
                    aria-controls="kt_account_profile_details">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">{{ __($base_data['menuElements'][$options['selectedTab']]['name']) }}
                        </h3>
                    </div>
                </div>

                <div id="kt_account_profile_details" class="collapse show">
                    <div id="kt_account_profile_details_form" class="form" enctype="multipart/form-data">
                        @if ($options['selectedTab'] == 0)
                            @include('livewire.settings.includes.general_settings')
                        @elseif ($options['selectedTab'] == 1)
                            {{-- @include('livewire.settings.includes.general_settings') --}}
                        @endif

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="button" class="btn btn-white btn-active-light-primary me-2"
                                wire:click="discard">{{ __('Discard') }}</button>

                            <button type="button" class="btn btn-primary" id="kt_account_profile_details_submit"
                                wire:click="save_settings">
                                @include('partials.general._button-indicator', [
                                    'label' => __('Save Changes'),
                                ])
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
