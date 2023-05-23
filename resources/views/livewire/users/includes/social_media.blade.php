<!--begin::Card-->
<div class="card pt-4 mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title">
            <span class="fw-bold mb-2 text-dark">{{ __('Social media') }}</span>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0 pb-5">
        <!--begin::Form-->
        <form class="form" action="#" id="kt_ecommerce_customer_profile">
            <!--begin::Row-->
            
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('website') }}</label>
        
                <div class="col-lg-8 fv-row">
                    <input type="text" class="form-control form-control-lg form-control-solid" placeholder="" name="website" wire:model="user.info.website" />
                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('facebook') }}</label>
        
                <div class="col-lg-8 fv-row">
                    <input type="text" class="form-control form-control-lg form-control-solid" placeholder="" name="facebook" wire:model="user.info.facebook" />
                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('linkedin') }}</label>
        
                <div class="col-lg-8 fv-row">
                    <input type="text" class="form-control form-control-lg form-control-solid" placeholder="" name="linkedin" wire:model="user.info.linkedin" />
                </div>
            </div>
            <div class="row mb-6">
                <label class="col-lg-4 col-form-label fw-bold fs-6">{{ __('skype') }}</label>
        
                <div class="col-lg-8 fv-row">
                    <input type="text" class="form-control form-control-lg form-control-solid" placeholder="" name="skype" wire:model="user.info.skype" />
                </div>
            </div>
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