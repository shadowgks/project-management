<div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" data-kt-stepper="true">
    <!-- NOTE - Steps header -->
    <div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
        <div class="stepper-nav ps-lg-10">
            <div class="stepper-item {{ $listing['options']['selected_step'] == 1 ? 'current' : '' }} {{ $listing['options']['selected_step'] > 1 ? 'completed' : '' }}"
                wire:key="step-label-1-{{ $time }}" data-kt-stepper-element="nav">
                <div class="stepper-wrapper">
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">1</span>
                    </div>
                    <div class="stepper-label">
                        <h3 class="stepper-title">Details</h3>
                        <div class="stepper-desc">Name and table of list</div>
                    </div>
                </div>
                <div class="stepper-line h-40px"></div>
            </div>

            <div class="stepper-item {{ $listing['options']['selected_step'] == 2 ? 'current' : '' }} {{ $listing['options']['selected_step'] > 2 ? 'completed' : '' }}"
                wire:key="step-label-2-{{ $time }}" data-kt-stepper-element="nav">
                <div class="stepper-wrapper">
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">2</span>
                    </div>
                    <div class="stepper-label">
                        <h3 class="stepper-title">Columns & order</h3>
                        <div class="stepper-desc">Select columns and order</div>
                    </div>
                </div>
                <div class="stepper-line h-40px"></div>
            </div>

            <div class="stepper-item {{ $listing['options']['selected_step'] == 3 ? 'current' : '' }} {{ $listing['options']['selected_step'] > 3 ? 'completed' : '' }}"
                wire:key="step-label-3-{{ $time }}" data-kt-stepper-element="nav">
                <div class="stepper-wrapper">
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">3</span>
                    </div>
                    <div class="stepper-label">
                        <h3 class="stepper-title">Customize columns</h3>
                        <div class="stepper-desc">Add or edit columns</div>
                    </div>
                </div>
                <div class="stepper-line h-40px"></div>
            </div>

            <div class="stepper-item {{ $listing['options']['selected_step'] == 4 ? 'current' : '' }} {{ $listing['options']['selected_step'] > 4 ? 'completed' : '' }}"
                wire:key="step-label-4-{{ $time }}" data-kt-stepper-element="nav">
                <div class="stepper-wrapper">
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">4</span>
                    </div>
                    <div class="stepper-label">
                        <h3 class="stepper-title">Conditions & filters</h3>
                        <div class="stepper-desc">Choose condition and filters</div>
                    </div>
                </div>
                <div class="stepper-line h-40px"></div>
            </div>

            <div class="stepper-item {{ $listing['options']['selected_step'] == 5 ? 'current' : '' }} mark-completed"
                wire:key="step-label-5-{{ $time }}" data-kt-stepper-element="nav">
                <div class="stepper-wrapper">
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">5</span>
                    </div>
                    <div class="stepper-label">
                        <h3 class="stepper-title">Completed</h3>
                        <div class="stepper-desc">Preview and Save</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- NOTE - Steps body -->
    <div class="flex-row-fluid py-lg-5 px-lg-15">
        <form class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate"
            id="kt_modal_create_app_form">

            <div class="{{ $listing['options']['selected_step'] == 1 ? 'current' : 'pending' }}"
                wire:key="step-content-1-{{ $time }}" data-kt-stepper-element="content">
                <div class="w-100">
                    <div class="fv-row mb-10 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">Name of table</span>
                        </label>
                        <input type="text" class="form-control form-control-lg form-control-solid"
                            placeholder="example: Sales, purchases..." wire:model.lazy="listing.values.name_table">
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>

                    <div class="fv-row mb-10">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                            <span class="required">Table</span>
                        </label>
                        <select name="tables" class="form-select" id="tables" wire:model="listing.values.table"
                            wire:change="listing_get_columns">
                            <option value=""></option>
                            @foreach ($listing_tables as $table)
                                <option value="{{ $table['id'] }}">{{ $table['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="{{ $listing['options']['selected_step'] == 2 ? 'current' : 'pending' }}"
                wire:key="step-content-2-{{ $time }}" data-kt-stepper-element="content">
                <div class="w-100">
                    <div class="fv-row mb-10 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                            <span class="required">Select columns</span>
                        </label>

                        <!-- NOTE - Columns -->
                        @if ($listing['values']['table'] != '')
                            <div id="columns">
                                @if ($length_columns > 0)
                                    <div class="row px-4">
                                        @foreach ($listing['base_data']['columns'] as $column)
                                            <div class="form-check form-check-click col-md-4 mb-3"
                                                wire:key="column-{{ $column['id'] }}">
                                                <input class="form-check-input mt-2" type="checkbox"
                                                    value="{{ $column['id'] }}" id="column-{{ $column['id'] }}"
                                                    wire:model="listing.values.selected_columns"
                                                    wire:change="listing_check_column('{{ $column['id'] }}', '{{ $column['type'] }}')" />
                                                <label class="form-check-label" for="column-{{ $column['id'] }}">
                                                    <span
                                                        class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $column['name'] }}</span>
                                                    <span
                                                        class="text-gray-400 fw-semibold d-block fs-7">{{ $column['type'] }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div>
                                        <span class="text-danger">Select Table</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="fv-row fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                            <span>Select order</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                data-kt-initialized="1"></i>
                        </label>

                        @if ($listing['values']['table'] != '')
                            <div class="row">
                                @if ($length_columns > 0)
                                    <div class="col-md-6 mt-3">
                                        <label for="order-columns" class="form-label">Order By</label>
                                        <select name="order-columns" class="form-select" id="order-columns"
                                            wire:model="listing.values.order_by">
                                            <option value=""></option>
                                            @foreach ($listing['base_data']['columns'] as $column)
                                                <option value="{{ $column['id'] }}">
                                                    {{ $column['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                @if ($length_columns > 0)
                                    <div class="col-md-6 mt-3">
                                        <label for="order-columns" class="form-label">Order</label>
                                        <select name="order-columns" class="form-select" id="order-columns"
                                            wire:model="listing.values.order_type">
                                            <option value="asc">Asc</option>
                                            <option value="desc">Desc</option>
                                        </select>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="{{ $listing['options']['selected_step'] == 3 ? 'current' : 'pending' }}"
                wire:key="step-content-3-{{ $time }}" data-kt-stepper-element="content">
                <div class="w-100">
                    <!-- NOTE - Selected columns -->
                    <div class="fv-row mb-10 fv-plugins-icon-container">
                        <label class="fs-5 fw-semibold mb-2">Selected columns</label>
                        @if ($length_columns > 0)
                            <div class="d-flex flex-row align-items-center flex-wrap">
                                @foreach ($listing['values']['selected_columns'] as $column)
                                    <div class="btn {{ $column == $listing['values']['column_option_helper'] ? 'btn-light-primary' : 'btn-primary' }} me-3 mb-3"
                                        wire:click="listing_action_options('{{ $column }}')">
                                        {{ $column }}
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                            <input class="form-check-input" type="checkbox" wire:model="listing.options.checkbox">
                            <span class="form-check-label fw-semibold text-muted">{{ __('Use Checkbox') }}</span>
                        </label>

                        <span class="fs-5 fw-semibold mb-2">{{ __('Principal columns') }}</span>
                        @if (
                            (count($listing['options']['table']) > 0 &&
                                isset($listing['options']['table']['table_contain_numbering']) &&
                                $listing['options']['table']['table_contain_numbering']) ||
                                count($listing['options']['table']) == 0)
                            <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox"
                                    wire:model="listing.values.settings.show_numbering">
                                <span class="form-check-label fw-semibold text-muted">{{ __('Numbering') }}</span>
                            </label>
                        @endif

                        @if (
                            (count($listing['options']['table']) > 0 &&
                                isset($listing['options']['table']['table_contain_barcode']) &&
                                $listing['options']['table']['table_contain_barcode']) ||
                                count($listing['options']['table']) == 0)
                            <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox"
                                    wire:model="listing.values.settings.show_barcode">
                                <span class="form-check-label fw-semibold text-muted">{{ __('Barcode') }}</span>
                            </label>
                        @endif

                        <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                            <input class="form-check-input" type="checkbox"
                                wire:model="listing.values.settings.show_flagged">
                            <span class="form-check-label fw-semibold text-muted">{{ __('Flagged') }}</span>
                        </label>

                        <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                            <input class="form-check-input" type="checkbox"
                                wire:model="listing.values.settings.show_created_by">
                            <span class="form-check-label fw-semibold text-muted">{{ __('Created by') }}</span>
                        </label>

                        <span class="fs-5 fw-semibold mb-2">{{ __('Buttons') }}</span>
                        <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                            <input class="form-check-input" type="checkbox"
                                wire:model="listing.values.settings.buttons.edit">
                            <span class="form-check-label fw-semibold text-muted">{{ __('Button edit') }}</span>
                        </label>

                        <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                            <input class="form-check-input" type="checkbox"
                                wire:model="listing.values.settings.buttons.delete">
                            <span class="form-check-label fw-semibold text-muted">{{ __('Button delete') }}</span>
                        </label>

                        <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                            <input class="form-check-input" type="checkbox"
                                wire:model="listing.values.settings.buttons.print">
                            <span class="form-check-label fw-semibold text-muted">{{ __('Button print') }}</span>
                        </label>

                        <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                            <input class="form-check-input" type="checkbox"
                                wire:model="listing.values.settings.buttons.validate">
                            <span class="form-check-label fw-semibold text-muted">{{ __('Button validate') }}</span>
                        </label>

                        <!-- NOTE - Totals -->
                        @if ($listing['options']['show_totals'])
                            <div class="row mt-3">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="form-check-input" id="show-total"
                                        wire:model="listing.values.column_total"
                                        wire:change="listing_append_column_total" />
                                    <label class="form-check-label" for="show-total">Total</label>
                                </div>
                            </div>
                        @endif

                        <!-- NOTE - Options -->
                        @if ($listing['options']['show_options'])
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="order-table-options" class="form-label">Table</label>
                                    <select name="order-table-options" class="form-select" id="order-table-options"
                                        wire:model="listing.values.table_option"
                                        wire:change="listing_choose_table_options">
                                        <option value=""></option>
                                        @foreach ($listing_tables as $table)
                                            <option value="{{ $table['id'] }}">
                                                {{ $table['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="order-column-options" class="form-label">Column</label>
                                    <select name="order-column-options" class="form-select" id="order-column-options"
                                        wire:model="listing.values.column_option"
                                        wire:change="listing_append_column_option">
                                        <option value=""></option>
                                        @foreach ($listing['base_data']['columns_options'] as $column)
                                            <option value="{{ $column['id'] }}">
                                                {{ $column['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- NOTE - Operations -->
                    <div class="fv-row mb-10 fv-plugins-icon-container">
                        <label class="fs-5 fw-semibold mb-2">Custom columns</label>
                        @if ($length_columns > 0)
                            @php
                                $length_operations = count($listing['values']['operations']);
                            @endphp

                            <div class="bg-light-secondary p-4">
                                @if ($length_operations > 0)
                                    @foreach ($listing['values']['operations'] as $key => $operation)
                                        <div class="card card-flush p-4 {{ $length_operations - 1 > $key ? 'mb-4' : '' }}"
                                            id="operation-{{ $key }}"
                                            wire:key="operation-{{ $key }}">
                                            <h5 class="card-label fw-bold text-dark">
                                                Column - {{ $key + 1 }}</h5>
                                            <div class="card-body p-0">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <select name="order-table-options" class="form-select"
                                                            id="order-table-options-{{ $key }}"
                                                            wire:model="listing.values.operations.{{ $key }}.type">
                                                            <option value="" disabled>
                                                                {{ __('Choose type') }}</option>
                                                            @foreach ($listing['base_data']['column_types'] as $column_type)
                                                                <option value="{{ $column_type['id'] }}"
                                                                    wire:key="operation-column-{{ $column_type['id'] }}">
                                                                    {{ $column_type['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6 mb-2">
                                                        <input type="text" class="form-control"
                                                            placeholder="Column name"
                                                            wire:model.lazy="listing.values.operations.{{ $key }}.name" />
                                                    </div>

                                                    @if ($operation['type'] == 4)
                                                        <div class="col-md-6 mb-2">
                                                            <input type="text" class="form-control"
                                                                placeholder="Custom
                                                                                        calcul"
                                                                wire:model.lazy="listing.values.operations.{{ $key }}.value" />
                                                        </div>
                                                    @endif

                                                    <div class="col-md-12 text-end my-2">
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            wire:click="listing_remove_column({{ $key }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-trash2-fill" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225zm9.89-.69C10.966 2.214 9.578 2 8 2c-1.58 0-2.968.215-3.926.534-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466-.18-.14-.498-.307-.975-.466z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card col-md-12">
                                        <div class="card-body">
                                            <span class="text-danger">{{ __('No custom columns yet!') }}</span>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-sm btn-primary"
                                    wire:click="listing_append_column">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="{{ $listing['options']['selected_step'] == 4 ? 'current' : 'pending' }}"
                wire:key="step-content-4-{{ $time }}" data-kt-stepper-element="content">
                <div class="w-100">

                    <!-- NOTE - Where -->
                    @if ($options['target'] == 'outside' && $length_columns > 0)
                        <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                            <label class="fs-5 fw-semibold mb-2">{{ __('Conditions') }}</label>
                            @php
                                $where_length = count($listing['values']['where']);
                            @endphp

                            <div class="bg-light-secondary p-4" id="where">
                                @if ($where_length > 0)
                                    @foreach ($listing['values']['where'] as $key => $wh)
                                        <div class="card card-flush p-4 {{ $where_length - 1 > $key ? 'mb-4' : '' }}"
                                            id="wh-{{ $key }}" wire:key="wh-{{ $key }}">
                                            <h5 class="card-label fw-bold text-dark">
                                                Condition - {{ $key + 1 }}</h5>
                                            <div class="card-body p-0">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="filter-where-type-{{ $key }}"
                                                            class="form-label">Type</label>
                                                        <select name="filter-where-type" class="form-select"
                                                            id="filter-where-type-{{ $key }}"
                                                            wire:model="listing.values.where.{{ $key }}.type"
                                                            wire:change="listing_init_filter_type({{ $key }})">
                                                            <option value=""></option>
                                                            @foreach ($listing['base_data']['filter_types'] as $type)
                                                                <option value="{{ $type['id'] }}">
                                                                    {{ $type['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    @if ($wh['type'] == 1)
                                                        <div class="col-md-6">
                                                            <label for="filter-where-column-{{ $key }}"
                                                                class="form-label">Column</label>
                                                            <select name="filter-where-column" class="form-select"
                                                                id="filter-where-column-{{ $key }}"
                                                                wire:model="listing.values.where.{{ $key }}.column.value"
                                                                wire:change="listing_choose_column({{ $key }})">
                                                                <option value=""></option>
                                                                @foreach ($listing['base_data']['columns'] as $column)
                                                                    <option value="{{ $column['id'] }}">
                                                                        {{ $column['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        @if (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp', 'integer', 'float', 'double']))
                                                            <div class="col-md-6">
                                                                <label
                                                                    for="filter-where-operation-{{ $key }}"
                                                                    class="form-label">Operation</label>
                                                                <select name="filter-where-operation"
                                                                    class="form-select"
                                                                    id="filter-where-operation-{{ $key }}"
                                                                    wire:model="listing.values.where.{{ $key }}.operation">
                                                                    @foreach ($listing['base_data']['operations'] as $operation)
                                                                        <option value="{{ $operation['id'] }}">
                                                                            {{ $operation['name'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @endif

                                                        @if ($wh['column']['value'] != '')
                                                            @if (in_array($wh['column']['type'], ['integer', 'float', 'double']))
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Value</label>
                                                                    <input type="text" class="form-control"
                                                                        wire:model.lazy="listing.values.where.{{ $key }}.value" />
                                                                </div>

                                                                @if ($wh['operation'] == 'between')
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Second
                                                                            Value</label>
                                                                        <input type="text" class="form-control"
                                                                            wire:model.lazy="listing.values.where.{{ $key }}.value_2" />
                                                                    </div>
                                                                @endif
                                                            @elseif (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp']))
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Value</label>
                                                                    <input type="date" class="form-control"
                                                                        wire:model="listing.values.where.{{ $key }}.value" />
                                                                </div>

                                                                @if ($wh['operation'] == 'between')
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Second
                                                                            Value</label>
                                                                        <input type="date" class="form-control"
                                                                            wire:model="listing.values.where.{{ $key }}.value_2" />
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="col-md-6">
                                                                    <label
                                                                        for="filter-where-value-{{ $key }}"
                                                                        class="form-label">Value</label>
                                                                    <select name="filter-where-value"
                                                                        class="form-select"
                                                                        id="filter-where-value-{{ $key }}"
                                                                        wire:model="listing.values.where.{{ $key }}.value">
                                                                        <option value="">
                                                                        </option>
                                                                        @foreach ($listing['values']['values_helper'][$key] as $value)
                                                                            <option value="{{ $value['val'] }}">
                                                                                {{ $value['val'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @elseif ($wh['type'] == 2)
                                                        <div class="col-md-6">
                                                            <label for="filter-where-join-table-{{ $key }}"
                                                                class="form-label">Table</label>
                                                            <select name="filter-where-join-table" class="form-select"
                                                                id="filter-where-join-table-{{ $key }}"
                                                                wire:model="listing.values.where.{{ $key }}.joins.join_table"
                                                                wire:change="listing_get_columns_of_table_join({{ $key }})">
                                                                <option value=""></option>
                                                                @foreach ($listing_tables as $table)
                                                                    <option value="{{ $table['id'] }}">
                                                                        {{ $table['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="filter-where-join-column-{{ $key }}"
                                                                class="form-label">Column</label>
                                                            <select name="filter-where-join-column"
                                                                class="form-select"
                                                                id="filter-where-join-column-{{ $key }}"
                                                                wire:model="listing.values.where.{{ $key }}.joins.value">
                                                                <option value=""></option>
                                                                @foreach ($listing['values']['columns_helper'][$key] as $column)
                                                                    <option value="{{ $column['id'] }}">
                                                                        {{ $column['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        @if ($wh['joins']['value'] != '')
                                                            <div class="col-md-6">
                                                                <label
                                                                    for="filter-where-join-data-type-{{ $key }}"
                                                                    class="form-label">Data
                                                                    type</label>
                                                                <select name="filter-where-join-data-type"
                                                                    class="form-select"
                                                                    id="filter-where-join-data-type-{{ $key }}"
                                                                    wire:model="listing.values.where.{{ $key }}.data_type">
                                                                    @foreach ($listing['base_data']['column_data_types'] as $data_type)
                                                                        <option value="{{ $data_type['id'] }}">
                                                                            {{ $data_type['name'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label
                                                                    for="filter-where-join-operation-{{ $key }}"
                                                                    class="form-label">Operation</label>
                                                                <select name="filter-where-join-operation"
                                                                    class="form-select"
                                                                    id="filter-where-join-operation-{{ $key }}"
                                                                    wire:model="listing.values.where.{{ $key }}.operation">
                                                                    <option value=""></option>
                                                                    @foreach ($listing['base_data']['operations'] as $operation)
                                                                        <option value="{{ $operation['id'] }}">
                                                                            {{ $operation['name'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            @if ($wh['joins']['value'] != '')
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Value</label>
                                                                    <input type="number" class="form-control"
                                                                        wire:model="listing.values.where.{{ $key }}.value" />
                                                                </div>

                                                                @if ($wh['operation'] == 'between')
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Second
                                                                            Value</label>
                                                                        <input type="number" class="form-control"
                                                                            wire:model="listing.values.where.{{ $key }}.value_2" />
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif

                                                    <div class="col-md-12 text-end my-2">
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            wire:click="listing_remove_where({{ $key }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-trash2-fill" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225zm9.89-.69C10.966 2.214 9.578 2 8 2c-1.58 0-2.968.215-3.926.534-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466-.18-.14-.498-.307-.975-.466z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($where_length - 1 > $key)
                                            <div class="row ps-5 mb-3">
                                                <div class="col-md-1">
                                                    <select name="filter-where-type-2" class="form-select"
                                                        id="filter-where-type-2-{{ $key }}"
                                                        wire:model="listing.values.where.{{ $key }}.where_type">
                                                        @foreach ($listing['base_data']['where_types'] as $type)
                                                            <option value="{{ $type['id'] }}">
                                                                {{ $type['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="card col-md-12">
                                        <div class="card-body">
                                            <span class="text-danger">No conditions yet!</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-sm btn-primary"
                                    wire:click="listing_append_where">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                        <label class="fs-5 fw-semibold mb-2">Filters</label>
                        <!-- NOTE - Filters -->
                        @if ($length_columns > 0)
                            <label class="form-check form-switch form-check-custom form-check-solid mb-4"
                                for="use-filters">
                                <input class="form-check-input" type="checkbox" id="use-filters"
                                    wire:key="use-filters" wire:model="listing.options.use_filters">
                                <span class="form-check-label fw-semibold">Use
                                    filters</span>
                            </label>

                            @if ($listing['options']['use_filters'])
                                <div class="bg-light-secondary border p-3">
                                    @foreach ($listing['values']['filters'] as $key => $column)
                                        <div class="row px-4" wire:key="filter-{{ $column['id'] }}">
                                            <label
                                                class="form-check form-switch form-check-custom form-check-solid mb-4"
                                                for="filter-{{ $column['id'] }}">
                                                <input class="form-check-input" type="checkbox"
                                                    id="filter-{{ $column['id'] }}"
                                                    wire:key="filter-used-{{ $column['id'] }}"
                                                    wire:model="listing.values.filters.{{ $key }}.used">
                                                <span
                                                    class="form-check-label fw-semibold text-muted">{{ $column['name'] }}</span>
                                            </label>

                                            @if (
                                                !in_array($column['type'], ['date', 'datetime', 'timestamp', 'string', 'text']) and
                                                    str_contains($column['id'], '_id'))
                                                @if ($column['used'])
                                                    <!-- NOTE - Data filters -->
                                                    <div class="col-md-6">
                                                        <label for="filter-table" class="form-label">Tables</label>
                                                        <select name="filter-table" class="form-select"
                                                            id="filter-table"
                                                            wire:key="filter-table-{{ $column['id'] }}"
                                                            wire:model="listing.values.filters.{{ $key }}.data.table"
                                                            wire:change="listing_get_columns_of_table_filter({{ $key }})">
                                                            <option value=""></option>
                                                            @foreach ($listing_tables as $table)
                                                                <option value="{{ $table['id'] }}">
                                                                    {{ $table['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="filter-column-text"
                                                            class="form-label">Text</label>
                                                        <select name="filter-column-text" class="form-select"
                                                            id="filter-column-text"
                                                            wire:key="filter-text-{{ $column['id'] }}"
                                                            wire:model="listing.values.filters.{{ $key }}.data.text">
                                                            <option value=""></option>
                                                            @if (count($listing['base_data']['columns_helper']) > 0 && isset($listing['base_data']['columns_helper'][$column['id']]))
                                                                @foreach ($listing['base_data']['columns_helper'][$column['id']] as $column_2)
                                                                    <option value="{{ $column_2['id'] }}"
                                                                        wire:key="text-{{ $column_2['id'] }}">
                                                                        {{ $column_2['name'] }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                @endif
                                            @elseif (in_array($column['type'], ['date', 'datetime', 'timestamp']))
                                                {{-- NOTE - Date filters --}}
                                                @if ($column['used'])
                                                    <div class="col-md-12 pb-4 px-0 d-flex flex-row">
                                                        @foreach ($listing['base_data']['filter_date_types'] as $type)
                                                            <div class="form-check me-2">
                                                                <input class="form-check-input" type="radio"
                                                                    id="date-standard-{{ $type['id'] }}"
                                                                    value="{{ $type['id'] }}"
                                                                    wire:model="listing.values.filters.{{ $key }}.date.type">
                                                                <label class="form-check-label"
                                                                    for="date-standard-{{ $type['id'] }}">{{ $type['name'] }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    @if ($column['date']['type'] == 2)
                                                        <div class="form-check form-check-click col-md-4 pb-4">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="filter-date-from-{{ $column['id'] }}"
                                                                wire:key="filter-date-from-{{ $column['id'] }}"
                                                                wire:model="listing.values.filters.{{ $key }}.date.from" />
                                                            <label class="form-check-label"
                                                                for="filter-date-from-{{ $column['id'] }}">From</label>
                                                        </div>
                                                        <div class="form-check form-check-click col-md-4 pb-4">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="filter-date-to-{{ $column['id'] }}"
                                                                wire:key="filter-date-to-{{ $column['id'] }}"
                                                                wire:model="listing.values.filters.{{ $key }}.date.to" />
                                                            <label class="form-check-label"
                                                                for="filter-date-to-{{ $column['id'] }}">To</label>
                                                        </div>
                                                        <div class="form-check form-check-click col-md-4 pb-4">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="filter-date-equal-{{ $column['id'] }}"
                                                                wire:key="filter-date-equal-{{ $column['id'] }}"
                                                                wire:model="listing.values.filters.{{ $key }}.date.equal" />
                                                            <label class="form-check-label"
                                                                for="filter-date-equal-{{ $column['id'] }}">Equals</label>
                                                        </div>
                                                        <div class="form-check form-check-click col-md-4 pb-4">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="filter-date-day-{{ $column['id'] }}"
                                                                wire:key="filter-date-day-{{ $column['id'] }}"
                                                                wire:model="listing.values.filters.{{ $key }}.date.day" />
                                                            <label class="form-check-label"
                                                                for="filter-date-day-{{ $column['id'] }}">Day</label>
                                                        </div>
                                                        <div class="form-check form-check-click col-md-4 pb-4">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="filter-date-month-{{ $column['id'] }}"
                                                                wire:key="filter-date-month-{{ $column['id'] }}"
                                                                wire:model="listing.values.filters.{{ $key }}.date.month" />
                                                            <label class="form-check-label"
                                                                for="filter-date-month-{{ $column['id'] }}">Month</label>
                                                        </div>
                                                        <div class="form-check form-check-click col-md-4 pb-4">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="filter-date-year-{{ $column['id'] }}"
                                                                wire:key="filter-date-year-{{ $column['id'] }}"
                                                                wire:model="listing.values.filters.{{ $key }}.date.year" />
                                                            <label class="form-check-label"
                                                                for="filter-date-year-{{ $column['id'] }}">Year</label>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- NOTE - Custom filters -->
                    @if ($options['target'] == 'outside' && $length_columns > 0 && $listing['options']['use_filters'])
                        <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                            <label class="fs-5 fw-semibold mb-2">Custom filters</label>
                            <div class="bg-light-secondary p-4">
                                @if (count($listing['values']['custom_filters']) > 0)
                                    @foreach ($listing['values']['custom_filters'] as $key => $filter)
                                        <div class="card card-flush p-4 {{ $where_length - 1 > $key ? 'mb-4' : '' }}"
                                            id="filter-{{ $key }}" wire:key="filter-{{ $key }}">
                                            <h5 class="card-label fw-bold text-dark">
                                                Custom filter - {{ $key + 1 }}
                                            </h5>
                                            <div class="card-body p-0">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="custom-filter-type-{{ $key }}"
                                                            class="form-label">Type</label>
                                                        <select name="custom-filter-type" class="form-select"
                                                            id="custom-filter-type-{{ $key }}"
                                                            wire:model="listing.values.custom_filters.{{ $key }}.type">
                                                            <option value=""></option>
                                                            @foreach ($listing['base_data']['filter_types'] as $column)
                                                                <option value="{{ $column['id'] }}">
                                                                    {{ $column['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    @if ($filter['type'] == 1)
                                                        <div class="col-md-6">
                                                            <label for="custom-filter-column-{{ $key }}"
                                                                class="form-label">Column</label>
                                                            <select name="custom-filter-type" class="form-select"
                                                                id="custom-filter-column-{{ $key }}"
                                                                wire:model="listing.values.custom_filters.{{ $key }}.column">
                                                                <option value="">
                                                                </option>
                                                                @foreach ($listing['base_data']['columns'] as $column)
                                                                    <option value="{{ $column['id'] }}">
                                                                        {{ $column['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @elseif ($filter['type'] == 2)
                                                        <div class="col-md-6">
                                                            <label for="custom-filter-table-{{ $key }}"
                                                                class="form-label">Table</label>
                                                            <select name="custom-filter-type" class="form-select"
                                                                id="custom-filter-table-{{ $key }}"
                                                                wire:model="listing.values.custom_filters.{{ $key }}.table"
                                                                wire:change="listing_get_columns_of_advanced_table_filter({{ $key }})">
                                                                <option value="">
                                                                </option>
                                                                @foreach ($listing_tables as $table)
                                                                    <option value="{{ $table['id'] }}">
                                                                        {{ $table['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="custom-filter-table-column-{{ $key }}"
                                                                class="form-label">Column</label>
                                                            <select name="custom-filter-type" class="form-select"
                                                                id="custom-filter-table-column-{{ $key }}"
                                                                wire:model="listing.values.custom_filters.{{ $key }}.table_column">
                                                                <option value="">
                                                                </option>
                                                                @foreach ($listing['base_data']['columns_helper_2'] as $column)
                                                                    <option value="{{ $column['id'] }}">
                                                                        {{ $column['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="custom-filter-data-type-{{ $key }}"
                                                                class="form-label">Data
                                                                type</label>
                                                            <select name="custom-filter-type" class="form-select"
                                                                id="custom-filter-data-type-{{ $key }}"
                                                                wire:model="listing.values.custom_filters.{{ $key }}.data_type">
                                                                <option value="">
                                                                </option>
                                                                @foreach ($listing['base_data']['column_data_types'] as $type)
                                                                    <option value="{{ $type['id'] }}">
                                                                        {{ $type['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif

                                                    <div class="col-md-12 text-end my-2">
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            wire:click="listing_remove_filter({{ $key }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-trash2-fill" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225zm9.89-.69C10.966 2.214 9.578 2 8 2c-1.58 0-2.968.215-3.926.534-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466-.18-.14-.498-.307-.975-.466z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="card col-md-12">
                                        <div class="card-body">
                                            <span class="text-danger">No custom filters
                                                yet!</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-sm btn-primary"
                                    wire:click="listing_append_filter">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="{{ $listing['options']['selected_step'] == 5 ? 'current' : 'pending' }}"
                wire:key="step-content-5-{{ $time }}" data-kt-stepper-element="content">
                <div class="w-100 text-center">
                    <h1 class="fw-bold text-dark mb-3">Release!</h1>
                    <div class="text-muted fw-semibold fs-3">Submit your app to kickstart your project.
                    </div>
                    <div class="text-center px-4 py-15">
                        {{-- <img src="/metronic8/demo1/assets/media/illustrations/sketchy-1/9.png"
                            alt="" class="mw-100 mh-300px"> --}}
                    </div>
                </div>
            </div>

            <!-- NOTE - Actions -->
            <div class="d-flex flex-stack pt-10">
                <div class="me-2">
                    @if ($listing['options']['selected_step'] > 1)
                        <button type="button" class="btn btn-lg btn-light-primary me-3"
                            wire:click="listing_action_step('previous')">
                            <span class="svg-icon svg-icon-3 me-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="11" width="13"
                                        height="2" rx="1" fill="currentColor"></rect>
                                    <path
                                        d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>{{ __('Back') }}
                        </button>
                    @endif
                </div>

                <div>
                    @if ($options['target'] == 'outside' && $listing['options']['selected_step'] == 5)
                        <button type="button" class="btn btn-lg btn-primary px-4" wire:click="listing_get_data">
                            {{ __('Preview') }}
                        </button>
                        <button type="button" class="btn btn-lg btn-success px-4" wire:click="save_modal">
                            {{ __('Save') }}
                        </button>
                    @endif

                    <button type="button" class="btn btn-lg btn-danger" wire:click="listing_cancel">
                        {{ __('Cancel') }}
                    </button>

                    @if ($listing['options']['selected_step'] < 5)
                        <button type="button" class="btn btn-lg btn-primary"
                            wire:click="listing_action_step('next')">{{ __('Continue') }}
                            <span class="svg-icon svg-icon-3 ms-1 me-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="18" y="13" width="13"
                                        height="2" rx="1" transform="rotate(-180 18 13)"
                                        fill="currentColor"></rect>
                                    <path
                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
