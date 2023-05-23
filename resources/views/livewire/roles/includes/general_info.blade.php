<!--begin::Card-->
<div class="card pt-4 mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0 pb-5">
        <!--begin::Form-->
        <form wire:submit.prevent="submit_general_info" class="form" method="POST">

            <div class="row mb-6">
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('name') }}</label>
        
                <div class="col-lg-8 fv-row">
                    <input type="text" name="name" wire:model.debounce.500ms="values.name" class="form-control form-control-lg form-control-solid"
                        placeholder="{{ __('name') }}"  />
                @error('values.app_id')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="name" data-validator="notEmpty">This input is required</div>
                </div>
                @enderror
                </div>
            </div>

            <div class="row mb-6">
                
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('app') }}</label>

                <div class="col-lg-8 fv-row">
                    <select name="app_id" aria-label="{{ __('Select a app') }}" data-control="select2"
                        class="form-select form-select-solid form-select-lg" wire:model="values.app_id">
                        <option value="">{{ __('Select a App..') }}</option>
                        @foreach ($base_data['apps'] as  $value)
                            <option value="{{ $value['id']}}">
                                {{ $value['name'] }}</option>
                        @endforeach
                    </select>
                    @error('values.app_id')
                    <div class="fv-plugins-message-container invalid-feedback">
                        <div data-field="app_id" data-validator="notEmpty">This select input is required</div>
                    </div>
                    @enderror
                </div>
            </div>

            
            <div class="row mb-6">
                
                <label class="col-lg-4 col-form-label required fw-bold fs-6">{{ __('gate') }}</label>

                <div class="col-lg-8 fv-row">
                    <select name="gate_id" aria-label="{{ __('Select a gate') }}" data-control="select2"
                        class="form-select form-select-solid form-select-lg" wire:model="values.gate_id">
                        <option value="">{{ __('Select a Gate..') }}</option>
                        @foreach ($base_data['gates'] as  $value)
                            <option  value="{{ $value['id'] }}">
                                {{ $value['name'] }}</option>
                        @endforeach
                    </select>
                    @error('values.gate_id')
                    <div class="fv-plugins-message-container invalid-feedback">
                        <div data-field="gate_id" data-validator="notEmpty">This select input is required</div>
                    </div>
                    @enderror
                </div>
            </div>
            <!--end::Input group-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <button type="submit" class="btn btn-light-primary mr-5">Save
                </button>
                <!--end::Button-->
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->