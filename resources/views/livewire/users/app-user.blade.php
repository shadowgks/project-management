<div class="mt-10">
    <div class="d-flex flex-column flex-xl-row">
        <!--begin::Sidebar-->
        @if ($user_id != 0)
            
        <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10 mt-20">
            <!--begin::Card-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Card body-->
                <div class="card-body pt-15">
                    <!--begin::Summary-->
                    <div class="d-flex flex-center flex-column mb-5">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-150px symbol-circle mb-7">
                            <img src="{{ asset('storage/'.$user['image_name']) }}" alt="image" />
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Name-->
                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">{{ $user['first_name'].' '.$user['last_name'] }}</a>
                        <!--end::Name-->
                        <!--begin::Email-->
                        <a href="#" class="fs-5 fw-semibold text-muted text-hover-primary mb-6">{{ $user['email'] }}</a>
                        <!--end::Email-->
                    </div>
                    <!--end::Summary-->
                    <!--begin::Details toggle-->
                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold">Details</div>
                        <!--begin::Badge-->
                        @if ($user['is_admin'])
                        <div class="badge badge-light-success d-inline">{{ __('admin') }}</div>
                            
                        @else
                        <div class="badge badge-light-info d-inline">{{ __('normal_user') }}</div>

                        @endif
                        <!--begin::Badge-->
                    </div>
                    <!--end::Details toggle-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--begin::Details content-->
                    <div class="pb-5 fs-6">
                        <!--begin::Details item-->
                        {{-- <div class="fw-bold mt-5">Account ID</div>
                        <div class="text-gray-600">ID-45453423</div> --}}
                        <!--begin::Details item-->
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">phone</div>
                        <div class="text-gray-600">
                            <a href="#" class="text-gray-600 text-hover-primary">{{ $user['info']['phone'] }}</a>
                        </div>
                        <!--begin::Details item-->
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5"> Address</div>
                        <div class="text-gray-600">{{ $user['info']['address'] }}</div>
                        <!--begin::Details item-->
                        <!--begin::Details item-->
                        <div class="fw-bold mt-5">{{ __('website') }}</div>
                        <div class="text-gray-600">{{ $user['info']['website'] }}</div>
                        <!--begin::Details item-->
                    </div>
                    <!--end::Details content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        @endif
        <!--end::Sidebar-->
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->
            
        @if ($user_id != 0)
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                <!--begin:::Tab item-->
                @foreach ($base_data['menuElements'] as $key => $element)
                
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 {{ ($user['is_admin'] and $element['component'] == 'perimission')?'disabled':'' }} {{ $element['component'] == $options['selectedTab'] ? 'active' : '' }}" 
                        wire:click="select_tab('{{ $element['component'] }}')" >{{ __($element['name']) }}</a>
                    </li>
                @endforeach
                <!--end:::Tab item-->
            </ul>
                
        @endif
            <div id="kt_account_profile_details_form" class="form" enctype="multipart/form-data">
                @include('livewire.users.includes.'.$options['selectedTab'])
                
            </div>
        </div>
        <!--end::Content-->

    </div>
    
    @if ($options['alert']['show'])
        <livewire:app-alert :type="$options['alert']['type']" :content="$options['alert']['content']" />
    @endif
</div>
