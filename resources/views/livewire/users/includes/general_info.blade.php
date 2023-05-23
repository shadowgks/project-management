<!--begin::Card-->
<div class="card pt-4 mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title">
            <span class="fw-bold mb-2 text-dark">{{ __('General info') }}</span>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0 pb-5">
        <!--begin::Form-->
        <form class="form" wire:submit.prevent="submit_general_info" id="kt_ecommerce_customer_profile"  enctype="multipart/form-data">
            <!--begin::Input group-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 col-form-label fw-bold fs-6">
                    <span>Update Avatar</span>
                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Allowed file types: png, jpg, jpeg."></i>
                </label>
                <!--end::Label-->
                <!--begin::Image input wrapper-->
                <div class="col-lg-8 fv-row">
                    <!--begin::Image input placeholder-->
                    <style>.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
                    <!--end::Image input placeholder-->
                    <!--begin::Image input-->
                    <div class="image-input image-input-outline image-input-placeholder" wire:ignore data-kt-image-input="true">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-125px h-125px" 
                            @if ($user_id != 0)
                            style="background-image: url({{ asset('storage/'.$user['image_name']) }})"
                            @endif
                        ></div>
                        <!--end::Preview existing avatar-->
                        <!--begin::Edit-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                            <i class="bi bi-pencil-fill fs-7"></i>
                            <!--begin::Inputs-->
                            <input type="file" wire:model.defer="avatar">

                            <input type="hidden" wire:model="avatar_remove" name="avatar_remove" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Edit-->
                        <!--begin::Cancel-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Cancel-->
                        <!--begin::Remove-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Remove-->
                    </div>
                    <!--end::Image input-->
                </div>
                <!--end::Image input wrapper-->
            </div>
            
            <div class="row mb-6">
                <label class="col-lg-4 required col-form-label fw-bold fs-6">{{ __('first_name') }}</label>
        
                <div class="col-lg-8 fv-row">
                    <input type="text" name="first_name" class="form-control form-control-lg form-control-solid"
                        placeholder="{{ __('first_name') }}" wire:model="user.first_name" />
                        
                @error('user.first_name')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="first_name" data-validator="notEmpty">This input is required</div>
                </div>
                @enderror
                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 required col-form-label fw-bold fs-6">{{ __('last_name') }}</label>
        
                <div class="col-lg-8 fv-row">
                    <input type="text" name="last_name" class="form-control form-control-lg form-control-solid"
                        placeholder="{{ __('last_name') }}" wire:model="user.last_name"  />
                        @error('user.last_name')
                        <div class="fv-plugins-message-container invalid-feedback">
                            <div data-field="last_name" data-validator="notEmpty">This input is required</div>
                        </div>
                        @enderror
                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 required col-form-label fw-bold fs-6">{{ __('email') }}</label>
        
                <div class="col-lg-8 fv-row">
                    <input type="email" name="email" class="form-control form-control-lg form-control-solid"
                        placeholder="{{ __('email') }}" wire:model="user.email" />
                        @error('user.email')
                        <div class="fv-plugins-message-container invalid-feedback">
                            <div data-field="email" data-validator="notEmpty">This input is required</div>
                        </div>
                        @enderror
                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('password') }}</label>
        
                <div class="col-lg-8 fv-row">
                    <input type="password" class="form-control form-control-lg form-control-solid" wire:model="password" />
                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('phone') }}</label>
        
                <div class="col-lg-8 fv-row">
                    <input type="text" name="phone" class="form-control form-control-lg form-control-solid"
                        placeholder="{{ __('phone') }}" wire:model="user.info.phone"  />
                </div>
            </div>
            <div class="row mb-6">
                
                <label class="col-lg-4 col-form-label fw-bold fs-6">this user is admin </label>
                <div class="col-lg-8 fv-row">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" wire:model="user.is_admin" value="true" />
                        
                </div>
                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">
                    <span class="">{{ __('role') }}</span>
                </label>
        
                <div class="col-lg-8 fv-row">
                    <select name="role" aria-label="{{ __('select_a_role') }}" {{ (isset($user['is_admin']) and $user['is_admin'])?'disabled':'' }} data-control="select2"
                        data-placeholder="{{ __('select_a_role...') }}"
                        class="form-select form-select-solid form-select-lg fw-bold" wire:model="user.role_id">
                        <option value="">{{ __('select_a_role...') }}</option>
                        @foreach ($base_data['roles'] as $role)
                            <option value="{{ $role['id'] }}">
                                {{ $role['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-6">
                <lable class="col-lg-4 col-form-label fw-bold fs-6">
                    <span class="">{{ __('address') }}</span>
                </lable>
                
                <div class="col-lg-8 fv-row">
                    <textarea name="address" wire:model="user.info.address" class="form-control form-control-lg form-control-solid" id="" cols="30" rows="5"></textarea>
                </div>
            </div>
            <!--end::Input group-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <button type="submit" id="kt_ecommerce_customer_profile_submit" class="btn btn-light-primary">{{ __('save') }}
                </button>
                <!--end::Button-->
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->