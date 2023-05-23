@php
    use App\Helpers\ModelHelper;
    $countNumberingElements = count($values['numbering']['elements']);
@endphp

<div class="w-100" wire:key="numbering-component">
    @if ($values['numbering']['choose_column'])
        <div class="d-flex justify-content-between mb-5">
            <div class="col-md-4 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Name') }}</span>
                </label>
                <input type="text" class="form-control form-control-lg form-control-solid"
                    placeholder="{{ __('Name') }}" wire:model.lazy="values.name">
            </div>

            <div class="d-flex align-items-end">
                <button type="button" class="btn btn-success" wire:click="saveNumbering">{{ __('Save') }}</button>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 ps-0 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Table') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.numbering.table"
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
                <select class="form-select form-control-lg form-control-solid" wire:model="values.numbering.column">
                    <option disabled value="">{{ __('Choose type') }}</option>
                    @foreach ($base_data['columns'] as $column)
                        <option value="{{ $column['id'] }}">{{ $column['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.numbering.use_numbering">
        <span class="form-check-label fw-semibold text-muted">{{ __('Use numbering') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.numbering.random">
        <span class="form-check-label fw-semibold text-muted">{{ __('Random numbering') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.numbering.every-day">
        <span class="form-check-label fw-semibold text-muted">{{ __('Every day') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.numbering.every-week">
        <span class="form-check-label fw-semibold text-muted">{{ __('Every week') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.numbering.every-month">
        <span class="form-check-label fw-semibold text-muted">{{ __('Every month') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.numbering.every-year">
        <span class="form-check-label fw-semibold text-muted">{{ __('Every year') }}</span>
    </label>

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.numbering.use_today_date">
        <span class="form-check-label fw-semibold text-muted">{{ __('Use today date') }}</span>
    </label>

    <div class="col-md-3 fv-row mb-10 fv-plugins-icon-container">
        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
            <span>{{ __('Number length') }}</span>
        </label>
        <input type="number" class="form-control form-control-lg form-control-solid" name="number_length"
            placeholder="{{ __('number_length') }}" wire:model.lazy="values.numbering.number_length">
    </div>

    @if ($values['numbering']['choose_column'])
        @if ($values['numbering']['table'] != '' && !$values['numbering']['use_today_date'])
            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Element type') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.numbering.date_field">
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
        @if (count($tables) > 0 && !$values['numbering']['use_today_date'])
            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Element type') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid" wire:model="values.numbering.date_field">
                    <option disabled value="">{{ __('Choose column') }}</option>
                    @foreach ($tables[0]['fields'] as $key => $field)
                        @if (in_array($field['field_type'], ['date', 'datetime']))
                            <option value="{{ $field['field_name'] }}">{{ $field['field_name'] }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        @endif
    @endif

    <label class="form-check form-switch form-check-custom form-check-solid mb-3">
        <input class="form-check-input" type="checkbox" wire:model="values.numbering.custom_number">
        <span class="form-check-label fw-semibold text-muted">{{ __('Start with') }}</span>
    </label>

    @if ($values['numbering']['custom_number'])
        <div class="col-md-3 fv-row mb-10 fv-plugins-icon-container">
            <input type="number" class="form-control form-control-lg form-control-solid" name="number_initiator"
                wire:model.lazy="values.numbering.number_initiator">
        </div>
    @endif

    <div class="row m-0 mt-6">
        <div class="col-md-3 fv-row mb-10 fv-plugins-icon-container">
            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                <span>{{ __('Element name') }}</span>
            </label>
            <input type="text" class="form-control form-control-lg form-control-solid" name="name"
                placeholder="{{ __('name') }}" wire:model.lazy="values.numbering.form.name">
        </div>

        <div class="col-md-3 mb-10 fv-plugins-icon-container">
            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                <span>{{ __('Element type') }}</span>
            </label>
            <select class="form-select form-control-lg form-control-solid" wire:model="values.numbering.form.type">
                <option disabled value="">{{ __('Choose type') }}</option>
                <option value="standard">{{ __('standard') }}</option>
                <option value="custom">{{ __('custom') }}</option>
            </select>
        </div>

        @if ($values['numbering']['form']['type'] == 'standard')
            <div class="col-md-3 mb-10 fv-plugins-icon-container">
                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                    <span>{{ __('Element type') }}</span>
                </label>
                <select class="form-select form-control-lg form-control-solid"
                    wire:model="values.numbering.form.value">
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
                    placeholder="{{ __('like') . ': FAV, -, ID,...' }}" wire:model.lazy="values.numbering.form.text">
            </div>
        @endif

        <div class="col-md-3 d-flex align-items-center">
            @if ($options['element_id'] == '')
                <button type="button" class="btn btn-primary" wire:click="addElement('numbering')">
                    <i class="fa fa-plus p-0"></i>
                </button>
            @else
                <button type="button" class="btn btn-primary" wire:click="saveElement('numbering')">
                    <i class="fa fa-check p-0"></i>
                </button>
            @endif
        </div>
    </div>

    @if ($countNumberingElements > 1)
        <div class="px-4 py-1 bg-secondary rounded">
            @foreach ($values['numbering']['elements'] as $key => $element)
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
                                        wire:click="editElement('numbering', {{ $key }})">
                                        <i class="fa fa-edit p-0"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger"
                                        wire:click="removeElement('numbering', {{ $key }})">
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

        <div class="px-4 py-4 bg-secondary rounded d-flex flex-row" id="numbering-elements">
            @foreach ($values['numbering']['elements'] as $key => $element)
                <div class="p-1" style="cursor: move">
                    <div class="numbering-drag-element badge {{ $element['type'] == 'static' ? 'badge-info' : 'badge-primary' }} flex-shrink-0 align-self-center py-4 px-6 fs-5"
                        draggable="true" data-id="{{ $key }}">
                        {{ $element['name'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
