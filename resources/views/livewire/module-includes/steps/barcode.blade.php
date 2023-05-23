@php
    use App\Helpers\ModelHelper;
    $countBarcodeElements = count($values['barcode']['elements']);
@endphp

<div class="w-100" wire:key="barcode-component">
    @if ($values['barcode']['choose_column'])
        <div class="d-flex justify-content-between mb-5">
            <div class="col-md-4 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Name') }}</span>
                </label>
                <input type="text" class="form-control form-control-lg form-control-solid"
                    placeholder="{{ __('Name') }}" wire:model.lazy="values.name">
            </div>

            <div class="d-flex align-items-end">
                <button type="button" class="btn btn-success" wire:click="saveBarcode">{{ __('Save') }}</button>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 ps-0 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Table') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.barcode.table"
                    wire:change="getColumnOfTable">
                    <option disabled value="">{{ __('Choose type') }}</option>
                    @foreach ($base_data['tables'] as $table)
                        <option value="{{ $table['id'] }}">{{ $table['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Column') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.barcode.column">
                    <option disabled value="">{{ __('Choose type') }}</option>
                    @foreach ($base_data['columns'] as $column)
                        <option value="{{ $column['id'] }}">{{ $column['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    <div class="col-md-3 mb-10 fv-plugins-icon-container">
        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
            <span>{{ __('Barcode type') }}</span>
        </label>
        <select class="form-select form-control-lg form-control-solid" wire:model="values.barcode.form.barcode_type">
            <option disabled value="">{{ __('Choose type') }}</option>
            @foreach ($base_data['barcode_types'] as $type)
                <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
    </div>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.barcode.use_numbering">
        <span class="form-check-label fw-semibold text-muted">{{ __('Use barcode') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.barcode.random">
        <span class="form-check-label fw-semibold text-muted">{{ __('Random barcode') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.barcode.every-day">
        <span class="form-check-label fw-semibold text-muted">{{ __('Every day') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.barcode.every-week">
        <span class="form-check-label fw-semibold text-muted">{{ __('Every week') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.barcode.every-month">
        <span class="form-check-label fw-semibold text-muted">{{ __('Every month') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.barcode.every-year">
        <span class="form-check-label fw-semibold text-muted">{{ __('Every year') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.barcode.use_today_date">
        <span class="form-check-label fw-semibold text-muted">{{ __('Use today date') }}</span>
    </label>

    <div class="col-md-3 fv-row mb-10 fv-plugins-icon-container">
        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
            <span>{{ __('Number length') }}</span>
        </label>
        <input type="number" class="form-control form-control-lg form-control-solid" name="number_length"
            placeholder="{{ __('number_length') }}" wire:model.lazy="values.barcode.number_length">
    </div>

    @if ($values['barcode']['choose_column'])
        @if ($values['barcode']['table'] != '' && !$values['barcode']['use_today_date'])
            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Element type') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.barcode.date_field">
                    <option disabled value="">{{ __('Choose column') }}</option>
                    @foreach ($base_data['columns'] as $key => $column)
                        @if (ModelHelper::isDateType($column['type']))
                            <option value="{{ $column['id'] }}">{{ $column['name'] }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        @endif
    @else
        @if (count($tables) > 0 && !$values['barcode']['use_today_date'])
            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Element type') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.barcode.date_field">
                    <option disabled value="">{{ __('Choose column') }}</option>
                    @foreach ($tables[0]['fields'] as $key => $field)
                        @if (ModelHelper::isDateType($field['field_type']))
                            <option value="{{ $field['field_name'] }}">{{ $field['field_name'] }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        @endif
    @endif

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.barcode.custom_number">
        <span class="form-check-label fw-semibold text-muted">{{ __('Start with') }}</span>
    </label>

    @if ($values['barcode']['custom_number'])
        <div class="col-md-3 fv-row mb-10 fv-plugins-icon-container">
            <input type="number" class="form-control form-control-lg form-control-solid" name="number_initiator"
                wire:model.lazy="values.barcode.number_initiator">
        </div>
    @endif

    <div class="row m-0 mt-6">
        <div class="col-md-3 fv-row mb-10 fv-plugins-icon-container">
            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                <span>{{ __('Element name') }}</span>
            </label>
            <input type="text" class="form-control form-control-lg form-control-solid" name="name"
                placeholder="{{ __('name') }}" wire:model.lazy="values.barcode.form.name">
        </div>

        <div class="col-md-3 mb-10 fv-plugins-icon-container">
            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                <span>{{ __('Element type') }}</span>
            </label>
            <select class="form-select form-control-lg form-control-solid" wire:model="values.barcode.form.type">
                <option disabled value="">{{ __('Choose type') }}</option>
                <option value="standard">{{ __('standard') }}</option>
                <option value="custom">{{ __('custom') }}</option>
            </select>
        </div>

        @if ($values['barcode']['form']['type'] == 'standard')
            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Element type') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.barcode.form.value">
                    <option disabled value="">{{ __('Choose type') }}</option>
                    @foreach ($base_data['element_types'] as $type)
                        <option value="{{ $type['id'] }}">{{ __($type['text']) }}
                        </option>
                    @endforeach
                </select>
            </div>
        @else
            <div class="col-md-3 fv-row mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Value') }}</span>
                </label>
                <input type="text" class="form-control form-control-lg form-control-solid" name="text"
                    placeholder="{{ __('like') . ': FAV, -, ID,...' }}" wire:model.lazy="values.barcode.form.text">
            </div>
        @endif

        <div class="col-md-3 d-flex align-items-center">
            @if ($options['element_id'] == '')
                <button type="button" class="btn btn-primary" wire:click="addElement('barcode')">
                    <i class="fa fa-plus p-0"></i>
                </button>
            @else
                <button type="button" class="btn btn-primary" wire:click="saveElement('barcode')">
                    <i class="fa fa-check p-0"></i>
                </button>
            @endif
        </div>
    </div>

    @if ($countBarcodeElements > 1)
        <div class="px-4 py-1 bg-secondary rounded">
            @foreach ($values['barcode']['elements'] as $key => $element)
                @if ($element['type'] != 'static')
                    <div class="card card-flush my-4">
                        <div class="card-body">
                            <div class="row m-0">
                                <div class="col-md-10 d-flex align-items-center">
                                    <h3 class="m-0">
                                        {{ $element['name'] }} <span
                                            class="text-muted fs-6">({{ __($element['type']) }})</span>
                                    </h3>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary"
                                        wire:click="editElement('barcode', {{ $key }})">
                                        <i class="fa fa-edit p-0"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger"
                                        wire:click="removeElement('barcode', {{ $key }})">
                                        <i class="fa fa-xmark p-0"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <div class="row m-0 mt-6">
        <h4>{{ __('order') }}</h4>

        <div class="px-4 py-4 bg-secondary rounded d-flex flex-row" id="barcode-elements">
            @foreach ($values['barcode']['elements'] as $key => $element)
                <div class="p-1" style="cursor: move">
                    <div class="barcode-drag-element badge {{ $element['type'] == 'static' ? 'badge-info' : 'badge-primary' }} flex-shrink-0 align-self-center py-4 px-6 fs-5"
                        draggable="true" data-id="{{ $key }}">
                        {{ $element['name'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
