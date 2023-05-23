@php
    use App\Helpers\ModelHelper;
    use App\Helpers\TemplateHelper;
@endphp

@if ($countFormFields > 0)
    <div class="px-4 py-1 bg-secondary rounded">
        @foreach ($values['template']['fields'] as $key => $field)
            <div class="card card-flush my-4" wire:key="template-form-field-{{ $key }}">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-row align-items-center">
                        <span class="card-label col-md-4 fw-bold text-dark">Field - {{ $key + 1 }}</span>
                        <select class="form-select form-select-sm form-control-solid"
                            wire:model="values.template.fields.{{ $key }}.order"
                            wire:change="checkFieldOrder({{ $key }})">
                            <option disabled value="">
                                {{ __('Choose Order') }}
                            </option>
                            @for ($i = 0; $i < count($values['template']['fields']); $i++)
                                <option value="{{ $i }}">
                                    {{ __('order') . ' - ' . ($i + 1) }}
                                </option>
                            @endfor
                        </select>
                        {{-- <span class="text-gray-400 mt-1 fw-semibold fs-6">Users from all channels</span> --}}
                    </h3>

                    <div class="card-toolbar">
                        <label class="form-check form-switch form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox"
                                wire:model="values.template.fields.{{ $key }}.active">
                            <span class="form-check-label fw-semibold text-muted">{{ __('Active') }}</span>
                        </label>
                        <button type="button" class="btn btn-danger" wire:click="removeFormField({{ $key }})">
                            <i class="fa fa-trash p-0"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row m-0">
                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">{{ __('Table') }}</span>
                            </label>
                            <select class="form-select form-control-lg form-control-solid"
                                wire:model="values.template.fields.{{ $key }}.table"
                                wire:change="getColumnsForField({{ $key }})">
                                <option disabled value="">
                                    {{ __('Choose Table') }}
                                </option>
                                @foreach ($tables as $tableKey => $table)
                                    <option value="{{ $tableKey }}">
                                        {{ $table['table_name'] }}
                                    </option>
                                @endforeach
                            </select>
                            {!! TemplateHelper::getFormMessage($field['errors']['table']) !!}
                        </div>

                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">{{ __('Column') }}</span>
                            </label>
                            <select class="form-select form-control-lg form-control-solid"
                                wire:model="values.template.fields.{{ $key }}.column"
                                wire:change="getColumnOptions({{ $key }})">
                                <option disabled value="">
                                    {{ __('Choose Column') }}
                                </option>
                                @foreach ($base_data['form']['columns'][$key] as $column)
                                    <option value="{{ $column['id'] }}">
                                        {{ $column['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            {!! TemplateHelper::getFormMessage($field['errors']['column']) !!}
                        </div>

                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">{{ __('Label') }}</span>
                            </label>
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                placeholder="{{ __('Label') }}"
                                wire:model.lazy="values.template.fields.{{ $key }}.label">
                            {!! TemplateHelper::getFormMessage($field['errors']['label']) !!}
                        </div>

                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">{{ __('Type') }}</span>
                            </label>
                            <select class="form-select form-control-lg form-control-solid"
                                wire:model="values.template.fields.{{ $key }}.type">
                                <option disabled value="">
                                    {{ __('Choose Type') }}
                                </option>
                                @foreach ($base_data['form']['form_types'] as $type)
                                    <option value="{{ $type['id'] }}">
                                        {{ $type['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            {!! TemplateHelper::getFormMessage($field['errors']['type']) !!}
                        </div>

                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span>{{ __('Default') }}</span>
                            </label>
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                placeholder="{{ __('Value') }}"
                                wire:model.lazy="values.template.fields.{{ $key }}.default">
                        </div>

                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span>{{ __('Design length') }}</span>
                            </label>
                            <select class="form-select form-control-lg form-control-solid"
                                wire:model="values.template.fields.{{ $key }}.design_length">
                                <option disabled value="">
                                    {{ __('Choose Length') }}
                                </option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">
                                        col-md-{{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        @if ($field['type'] == 'text')
                            <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span>{{ __('Placeholder') }}</span>
                                </label>
                                <input type="text" class="form-control form-control-lg form-control-solid"
                                    placeholder="{{ __('Placeholder') }}"
                                    wire:model.lazy="values.template.fields.{{ $key }}.placeholder">
                            </div>

                            <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span>{{ __('Length') }}</span>
                                </label>
                                <input type="number" class="form-control form-control-lg form-control-solid"
                                    wire:model.lazy="values.template.fields.{{ $key }}.length">
                            </div>
                        @endif

                        @if ($field['type'] == 'number')
                            <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span>{{ __('Min') }}</span>
                                </label>
                                <input type="number" class="form-control form-control-lg form-control-solid"
                                    wire:model.lazy="values.template.fields.{{ $key }}.min">
                            </div>

                            <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span>{{ __('Max') }}</span>
                                </label>
                                <input type="number" class="form-control form-control-lg form-control-solid"
                                    wire:model.lazy="values.template.fields.{{ $key }}.max">
                            </div>
                        @endif

                        @if (in_array($field['type'], ['select', 'radio', 'checkbox']))
                            <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span>{{ __('Data Type') }}</span>
                                </label>
                                <select class="form-select form-control-lg form-control-solid"
                                    wire:model="values.template.fields.{{ $key }}.value.type">
                                    <option value="data">
                                        {{ __('Data') }}
                                    </option>
                                    <option value="custom">
                                        {{ __('Custom') }}
                                    </option>
                                </select>
                            </div>

                            @if ($field['value']['type'] == 'data')
                                <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span>{{ __('Table') }}</span>
                                    </label>
                                    <select class="form-select form-control-lg form-control-solid"
                                        wire:model="values.template.fields.{{ $key }}.value.table"
                                        wire:change="getColumnsForValue({{ $key }})">
                                        <option disabled value="">
                                            {{ __('Choose Table') }}
                                        </option>
                                        @foreach ($base_data['tables'] as $tableKey => $table)
                                            <option value="{{ $table['id'] }}">
                                                {{ $table['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if (!empty($values['template']['fields'][$key]['value']['table']))
                                    <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span>{{ __('Column') }}</span>
                                        </label>
                                        <select class="form-select form-control-lg form-control-solid"
                                            wire:model="values.template.fields.{{ $key }}.value.column">
                                            <option disabled value="">
                                                {{ __('Choose Column') }}
                                            </option>
                                            @foreach ($base_data['form']['value']['columns'][$key] as $column)
                                                <option value="{{ $column['id'] }}">
                                                    {{ $column['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @else
                                <div class="col-md-12">
                                    @if (count($field['value']['custom']) > 0)
                                        <div class="px-4 py-1 bg-secondary rounded">
                                            @foreach ($field['value']['custom'] as $customKey => $custom)
                                                <div class="card card-flush my-4">
                                                    <div class="card-body">
                                                        <div class="row m-0">
                                                            <div class="col-md-5 fv-plugins-icon-container">
                                                                <label
                                                                    class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                                    <span>{{ __('Value') }}</span>
                                                                </label>
                                                                <input type="text"
                                                                    class="form-control form-control-lg form-control-solid"
                                                                    placeholder="{{ __('Value') }}"
                                                                    wire:model.lazy="values.template.fields.{{ $key }}.value.custom.{{ $customKey }}.value">
                                                            </div>

                                                            <div class="col-md-5 fv-plugins-icon-container">
                                                                <label
                                                                    class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                                    <span>{{ __('Text') }}</span>
                                                                </label>
                                                                <input type="text"
                                                                    class="form-control form-control-lg form-control-solid"
                                                                    placeholder="{{ __('Text') }}"
                                                                    wire:model.lazy="values.template.fields.{{ $key }}.value.custom.{{ $customKey }}.text">
                                                            </div>

                                                            <div
                                                                class="col-md-2 d-flex align-items-end justify-content-center">
                                                                <button type="button" class="btn btn-danger mb-2"
                                                                    wire:click="removeFormFieldCustomValue({{ $customKey }}, {{ $key }})">
                                                                    <i class="fa fa-trash p-0"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-end">
                                        <div>
                                            <button type="button" class="btn btn-primary mt-2"
                                                wire:click="addFormFieldCustomValue({{ $key }})">
                                                <i class="fa fa-plus p-0"></i>
                                                {{ __('Custom data') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- NOTE - Form validation -->
                        <div class="mt-2">
                            <div class="row m-0">
                                <label class="col-md-2 form-check form-switch form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input" type="checkbox"
                                        wire:model="values.template.fields.{{ $key }}.options.popover.use">
                                    <span class="form-check-label fw-semibold text-muted">{{ __('Popover') }}</span>
                                </label>

                                @if (isset($field['options']['popover']['use']) && $field['options']['popover']['use'])
                                    <div class="col-md-4 mb-4 fv-plugins-icon-container">
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            placeholder="{{ __('Content') }}"
                                            wire:model.lazy="values.template.fields.{{ $key }}.options.popover.content">
                                    </div>
                                @endif
                            </div>


                            @if ($field['options']['show_required'])
                                <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input" type="checkbox"
                                        wire:model="values.template.fields.{{ $key }}.required">
                                    <span class="form-check-label fw-semibold text-muted">{{ __('Required') }}</span>
                                </label>
                            @endif

                            @if ($field['options']['show_unique'])
                                <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input" type="checkbox"
                                        wire:model="values.template.fields.{{ $key }}.unique">
                                    <span class="form-check-label fw-semibold text-muted">{{ __('Unique') }}</span>
                                </label>
                            @endif

                            @if (ModelHelper::isDateType($field['type']))
                                <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input" type="checkbox"
                                        wire:model="values.template.fields.{{ $key }}.previous_dates">
                                    <span
                                        class="form-check-label fw-semibold text-muted">{{ __('Allow previous dates or times') }}</span>
                                </label>

                                <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                                    <input class="form-check-input" type="checkbox"
                                        wire:model="values.template.fields.{{ $key }}.next_dates">
                                    <span
                                        class="form-check-label fw-semibold text-muted">{{ __('Allow next dates or times') }}</span>
                                </label>
                            @endif

                            @if (in_array($field['type'], ['text', 'number']))
                                <div class="row m-0">
                                    <label
                                        class="col-md-2 form-check form-switch form-check-custom form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox"
                                            wire:model="values.template.fields.{{ $key }}.use_regex">
                                        <span
                                            class="form-check-label fw-semibold text-muted">{{ __('Use regex') }}</span>
                                    </label>

                                    @if ($field['use_regex'])
                                        <div class="col-md-4 mb-4 fv-plugins-icon-container">
                                            <input type="text"
                                                class="form-control form-control-lg form-control-solid"
                                                placeholder="/([A-Z])\w+/g"
                                                wire:model.lazy="values.template.fields.{{ $key }}.regex_value">
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<div class="d-flex justify-content-end">
    <div>
        <button type="button" class="btn btn-primary mt-2" wire:click="addFormField">
            <i class="fa fa-plus p-0"></i>
            {{ __('Field') }}
        </button>
    </div>
</div>
