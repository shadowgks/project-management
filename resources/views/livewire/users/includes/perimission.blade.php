<div>
    <div class="card mb-5 mb-lg-10">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title flex-column">
                <span class="fw-bold mb-2 text-dark">{{ __('Permissions') }}</span>
                {{-- <div class="fs-6 fw-semibold text-muted">Choose what notifications you’d like to receive.</div> --}}
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body p-0">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <form wire:submit.prevent="submit_permissions" method="POST">
                    
                    {{  method_field('PUT') }}
                    <input  wire:model="user_id"  type="hidden" value="1" > 

                    <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9 border">
                        <!--begin::Tbody-->
                        <tbody class="fw-6 fw-semibold text-gray-600">
                            
                            <tr style="">
                                <td >
                                    {{ __('module_name') }}
                                </td>
                                <td >
                                    {{ __('permission') }}
                                </td>
                                <td >
                                    {{ __('value') }}
                                </td>
                            </tr>
                            @foreach ($modules_permission as $key => $element)
                                @if (count($element['permission']) == 0)
                                    @continue
                                @endif
                                @foreach ($element['permission'] as $key2 => $element2)
                                <tr style="">
                                    @if ($key2 == 0)
                                        
                                    <td rowspan="{{ count($element['permission']) }}" width="20%" style="border-right: 1px solid var(--kt-border-color);">
                                        {{ $element['name'] }}
                                    </td>
                                    @endif
                                        <td class="ps-9">{{ __($element2['pseudo_name']) }}
                                        </td>
                                        <td >

                                            <div class="form-check form-check-custom form-check-solid">
                                                <!--begin::Input-->
                                                <input class="form-check-input me-3" wire:model="permissions.{{ $element2['id'] }}"  type="checkbox" value="true" >
                                                <!--end::Input-->
                                            </div>
                                        </td>  
                                    
                                </tr>  
                                @endforeach
                            @endforeach
                        </tbody>
                        <!--end::Tbody-->
                    </table>
                    
                    <div class="d-flex justify-content-end ">
                        <!--begin::Button-->
                        <button type="submit" class="btn btn-light-primary mx-8">Save
                        </button>
                        <!--end::Button-->
                    </div>
                </form>

                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
</div>