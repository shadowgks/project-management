@php
    use App\Helpers\TemplateHelper;
@endphp

<div>
    <div class="row">
        <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                <span class="required">{{ __('Validator Name') }}</span>
            </label>
            <input type="text" class="form-control form-control-lg form-control-solid" name="validator-name"
                placeholder="{{ __('Validator Name') }}" wire:model.lazy="values.validator.name">
            {!! TemplateHelper::getFormMessage($options['errors']['validator_name']) !!}
        </div>

        <label class="form-check form-switch form-check-custom form-check-solid col-md-4 mb-3">
            <input class="form-check-input" type="checkbox" wire:model="values.validator.order">
            <span class="form-check-label fw-semibold text-muted">{{ __('Require order') }}</span>
        </label>

        @if ($countValidations > 0)
            <div class="px-4 py-1 bg-secondary">
                @foreach ($values['validator']['validations'] as $key => $validation)
                    <div class="card card-flush my-4">
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">{{ __('Valid') }}
                                    {{ $key + 1 }}</span>
                            </h3>

                            <div class="card-toolbar">
                                <button type="button" class="btn btn-danger btn-icon btn-sm btn-shadow"
                                    wire:click="removeValidation({{ $key }})">
                                    <i class="fa fa-trash p-0"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row m-0">
                                <div class="col-md-3 fv-row mb-10 fv-plugins-icon-container">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span class="required">{{ __('Validation Name') }}</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg form-control-solid"
                                        name="validation-name" placeholder="{{ __('Validation Name') }}"
                                        wire:model.lazy="values.validator.validations.{{ $key }}.name">
                                    {!! TemplateHelper::getFormMessage($validation['errors']['name']) !!}
                                </div>

                                @if ($values['validator']['order'])
                                    <div class="col-md-3 mb-10 fv-plugins-icon-container">
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">{{ __('Order') }}</span>
                                        </label>
                                        <select class="form-select form-control-lg form-control-solid"
                                            wire:model.lazy="values.validator.validations.{{ $key }}.order"
                                            wire:change="checkValidationOrder({{ $key }})">
                                            <option disabled value="">
                                                {{ __('Choose order') }}
                                            </option>
                                            @for ($i = 0; $i < $countValidations; $i++)
                                                <option value="{{ $i }}">
                                                    {{ __('Order') . ' ' . ($i + 1) }}
                                                </option>
                                            @endfor
                                        </select>
                                        {!! TemplateHelper::getFormMessage($validation['errors']['order']) !!}
                                    </div>
                                @endif

                                <div class="col-md-3 fv-row mb-10 fv-plugins-icon-container">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span class="required">{{ __('Status Name') }}</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg form-control-solid"
                                        name="status-name" placeholder="{{ __('Status Name') }}"
                                        wire:model.lazy="values.validator.validations.{{ $key }}.status_name">
                                    {!! TemplateHelper::getFormMessage($validation['errors']['status_name']) !!}
                                </div>

                                <div class="col-md-3 fv-row mb-10 fv-plugins-icon-container">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span class="required">{{ __('Status Color') }}</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg form-control-solid"
                                        name="status-color" placeholder="{{ __('Status Color') }}"
                                        wire:model.lazy="values.validator.validations.{{ $key }}.status_color">
                                    {!! TemplateHelper::getFormMessage($validation['errors']['status_color']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="d-flex justify-content-end">
            <div>
                <button type="button" class="btn btn-primary my-4" wire:click="appedValidation">
                    <i class="fa fa-plus p-0"></i>
                    {{ __('Valid') }}
                </button>
            </div>
        </div>
    </div>
</div>
