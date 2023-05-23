<div class="modal black-background-transparent fade {{ $options['show_steps_modal'] ? 'show' : '' }}" tabindex="-1"
    style="display: {{ $options['show_steps_modal'] ? 'block' : 'none' }};" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Create Chart</h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary"
                    wire:click="action_modal('hide', 'show_steps_modal')">
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="modal-body py-lg-10 px-lg-10">
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
                    data-kt-stepper="true">
                    <!-- NOTE - Steps header -->
                    <div class="d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px">
                        <div class="stepper-nav ps-lg-10">
                            <div class="stepper-item {{ $options['selected_step'] == 1 ? 'current' : '' }} {{ $options['selected_step'] > 1 ? 'completed' : '' }}"
                                data-kt-stepper-element="nav">
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

                            <div class="stepper-item {{ $options['selected_step'] == 2 ? 'current' : '' }} {{ $options['selected_step'] > 2 ? 'completed' : '' }}"
                                data-kt-stepper-element="nav">
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

                            <div class="stepper-item {{ $options['selected_step'] == 3 ? 'current' : '' }} {{ $options['selected_step'] > 3 ? 'completed' : '' }}"
                                data-kt-stepper-element="nav">
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

                            <div class="stepper-item {{ $options['selected_step'] == 4 ? 'current' : '' }} {{ $options['selected_step'] > 4 ? 'completed' : '' }}"
                                data-kt-stepper-element="nav">
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

                            <div class="stepper-item {{ $options['selected_step'] == 5 ? 'current' : '' }} mark-completed"
                                data-kt-stepper-element="nav">
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

                            <div class="{{ $options['selected_step'] == 1 ? 'current' : 'pending' }}"
                                data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!-- NOTE - Name -->
                                    <div class="fv-row mb-10 fv-plugins-icon-container">
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                            <span class="required">Name of chart</span>
                                        </label>
                                        <input type="text" class="form-control form-control-lg form-control-solid"
                                            placeholder="example: Sales, purchases..."
                                            wire:model.lazy="values.name_chart">
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>

                                    <!-- NOTE - Types -->
                                    <div class="fv-row mb-10">
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                            <span class="required">Type of chart</span>
                                        </label>
                                        <select name="type" class="form-select" id="type"
                                            wire:model="values.type">
                                            @foreach ($base_data['types'] as $type)
                                                <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- NOTE - Data Types -->
                                    <div class="fv-row mb-10">
                                        <div class="col-md-12">
                                            <label for="data-type"
                                                class="d-flex align-items-center fs-5 fw-semibold mb-4"">
                                                <span class="required">Data Types</span>
                                            </label>
                                            <select name="data-type" class="form-select" id="data-type"
                                                wire:model="values.data_type">
                                                @foreach ($base_data['data_types'] as $type)
                                                    <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @if ($values['data_type'] == 1)
                                        <div class="fv-row mb-10">
                                            <div class="col-md-12">
                                                <label for="data-label"
                                                    class="d-flex align-items-center fs-5 fw-semibold mb-4"">
                                                    <span class="required">Name of data</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control form-control-lg form-control-solid"
                                                    placeholder="example: Sales, purchases..."
                                                    wire:model="values.data_label" />
                                            </div>
                                        </div>
                                    @endif

                                    <!-- NOTE - Tables -->
                                    <div class="fv-row mb-10">
                                        <div class="col-md-12">
                                            <label for="tables"
                                                class="d-flex align-items-center fs-5 fw-semibold mb-4"">
                                                <span class="required">Tables</span>
                                            </label>
                                            <select name="tables" class="form-select" id="tables"
                                                wire:model="values.table" wire:change="get_columns">
                                                <option value="">Choose table</option>
                                                @foreach ($base_data['tables'] as $table)
                                                    <option value="{{ $table['id'] }}">{{ $table['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- NOTE - Date -->
                                    @if (in_array($values['data_type'], [2, 3, 4]))
                                        <div class="fv-row">
                                            <div class="col-md-12">
                                                <label for="date_columns"
                                                    class="d-flex align-items-center fs-5 fw-semibold mb-4"">
                                                    <span class="required">Date column</span>
                                                </label>
                                                <select name="date_columns" class="form-select" id="date_columns"
                                                    wire:model="values.date_column" wire:change="get_columns">
                                                    <option value="">Choose column of date</option>
                                                    @foreach ($base_data['date_columns'] as $column)
                                                        <option value="{{ $column['id'] }}">{{ $column['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="{{ $options['selected_step'] == 2 ? 'current' : 'pending' }}"
                                data-kt-stepper-element="content">
                                <div class="w-100">
                                    <!-- NOTE - Columns -->
                                    <div class="fv-row mb-10 fv-plugins-icon-container">
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                            <span class="required">Select columns</span>
                                        </label>
                                        @if ($length_columns > 0)
                                            <div class="row">
                                                @foreach ($base_data['columns'] as $column)
                                                    <div class="form-check form-check-click col-md-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $column['id'] }}"
                                                            id="column-{{ $column['id'] }}"
                                                            wire:model="values.selected_columns"
                                                            wire:change="check_column" />
                                                        <label class="form-check-label"
                                                            for="column-{{ $column['id'] }}">
                                                            <span
                                                                class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $column['name'] }}</span>
                                                            <span
                                                                class="text-gray-400 fw-semibold d-block fs-7">{{ $column['type'] }}</span></label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div>
                                                <span class="text-danger">Select Table</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- NOTE - Selected columns -->
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                            <span>Selected columns</span>
                                        </label>

                                        <div class="d-flex flex-row align-items-center flex-wrap my-3">
                                            @foreach ($values['selected_columns'] as $column)
                                                <div class="btn {{ $column == $options['current_column'] ? 'btn-light-primary' : 'btn-primary' }} me-3"
                                                    wire:click="action_column('{{ $column }}')">
                                                    {{ $column }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="{{ $options['selected_step'] == 3 ? 'current' : 'pending' }}"
                                data-kt-stepper-element="content">
                                <div class="w-100">
                                    <div class="fv-row fv-plugins-icon-container">
                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-4">
                                            <span>Select order</span>
                                        </label>

                                        @if ($length_columns > 0)
                                            <div class="row my-2">
                                                <div class="d-flex flex-row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            id="data-standard" value="1"
                                                            wire:model="options.radio_column_type">
                                                        <label class="form-check-label"
                                                            for="data-standard">Standard</label>
                                                    </div>
                                                    <div class="form-check ms-2">
                                                        <input class="form-check-input" type="radio"
                                                            id="data-advanced" value="2"
                                                            wire:model="options.radio_column_type">
                                                        <label class="form-check-label"
                                                            for="data-advanced">Advanced</label>
                                                    </div>
                                                </div>

                                                <!-- NOTE - Column data Types -->
                                                @if ($options['radio_column_type'] == 1)
                                                    <div class="col-md-6 mt-2">
                                                        <label for="data-type" class="form-label">Column Data
                                                            Types</label>
                                                        <select name="data-type" class="form-select" id="data-type"
                                                            wire:model="values.column_data_type">
                                                            @foreach ($base_data['columns_data_types'] as $type)
                                                                <option value="{{ $type['id'] }}">
                                                                    {{ $type['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    @foreach ($values['data_columns'] as $key => $column)
                                                        <div class="row mt-2"
                                                            wire:key="data-column-{{ $key }}">
                                                            <div class="col-md-1 mt-3">
                                                                <span>{{ $column['column'] }}</span>
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <select name="data-type" class="form-select"
                                                                    id="data-type"
                                                                    wire:model="values.data_columns.{{ $key }}.value"
                                                                    wire:key="type-column-{{ $key }}">
                                                                    @foreach ($base_data['columns_data_types'] as $type)
                                                                        <option value="{{ $type['id'] }}">
                                                                            {{ $type['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="{{ $options['selected_step'] == 4 ? 'current' : 'pending' }}"
                                data-kt-stepper-element="content">
                                <div class="w-100">
                                    <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                                        <label class="fs-5 fw-semibold mb-2">Conditions</label>
                                    </div>

                                    @php
                                        $where_length = count($values['where']);
                                    @endphp

                                    <div class="bg-light-secondary p-4">
                                        @if ($where_length > 0)
                                            @foreach ($values['where'] as $key => $wh)
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
                                                                    wire:model="values.where.{{ $key }}.type"
                                                                    wire:change="init_filter_type({{ $key }})">
                                                                    <option value=""></option>
                                                                    @foreach ($base_data['filter_types'] as $type)
                                                                        <option value="{{ $type['id'] }}">
                                                                            {{ $type['name'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            @if ($wh['type'] == 1)
                                                                <div class="col-md-6">
                                                                    <label
                                                                        for="filter-where-column-{{ $key }}"
                                                                        class="form-label">Column</label>
                                                                    <select name="filter-where-column"
                                                                        class="form-select"
                                                                        id="filter-where-column-{{ $key }}"
                                                                        wire:model="values.where.{{ $key }}.column.value"
                                                                        wire:change="choose_column({{ $key }})">
                                                                        <option value=""></option>
                                                                        @foreach ($base_data['columns'] as $column)
                                                                            <option value="{{ $column['id'] }}">
                                                                                {{ $column['name'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                @if (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp', 'integer', 'float', 'double']) and
                                                                    !str_contains($wh['column']['value'], '_id'))
                                                                    <div class="col-md-6">
                                                                        <label
                                                                            for="filter-where-operation-{{ $key }}"
                                                                            class="form-label">Operation</label>
                                                                        <select name="filter-where-operation"
                                                                            class="form-select"
                                                                            id="filter-where-operation-{{ $key }}"
                                                                            wire:model="values.where.{{ $key }}.operation">
                                                                            @foreach ($base_data['operations'] as $operation)
                                                                                <option
                                                                                    value="{{ $operation['id'] }}">
                                                                                    {{ $operation['name'] }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                @endif

                                                                @if ($wh['column']['value'] != '')
                                                                    @if (in_array($wh['column']['type'], ['integer', 'float', 'double']) and
                                                                        !str_contains($wh['column']['value'], '_id'))
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">Value</label>
                                                                            <input type="text" class="form-control"
                                                                                wire:model="values.where.{{ $key }}.value" />
                                                                        </div>

                                                                        @if ($wh['operation'] == 'between')
                                                                            <div class="col-md-6">
                                                                                <label class="form-label">Second
                                                                                    Value</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    wire:model="values.where.{{ $key }}.value_2" />
                                                                            </div>
                                                                        @endif
                                                                    @elseif (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp']))
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">Value</label>
                                                                            <input type="date" class="form-control"
                                                                                wire:model="values.where.{{ $key }}.value" />
                                                                        </div>

                                                                        @if ($wh['operation'] == 'between')
                                                                            <div class="col-md-6">
                                                                                <label class="form-label">Second
                                                                                    Value</label>
                                                                                <input type="date"
                                                                                    class="form-control"
                                                                                    wire:model="values.where.{{ $key }}.value_2" />
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
                                                                                wire:model="values.where.{{ $key }}.value">
                                                                                <option value=""></option>
                                                                                @foreach ($values['values_helper'][$key] as $value)
                                                                                    <option
                                                                                        value="{{ $value['val'] }}">
                                                                                        {{ $value['val'] }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @elseif ($wh['type'] == 2)
                                                                <div class="col-md-6 row">
                                                                    <div class="col-md-9 pe-0">
                                                                        <label
                                                                            for="filter-where-join-table-{{ $key }}"
                                                                            class="form-label">Table</label>
                                                                        <select name="filter-where-join-table"
                                                                            class="form-select"
                                                                            id="filter-where-join-table-{{ $key }}"
                                                                            wire:model="values.where.{{ $key }}.joins.join_table"
                                                                            wire:change="get_columns_of_table_join({{ $key }})">
                                                                            <option value=""></option>
                                                                            @foreach ($base_data['tables'] as $table)
                                                                                <option value="{{ $table['id'] }}">
                                                                                    {{ $table['name'] }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        {{-- <div style="margin-top: 31px;"> --}}
                                                                        <div>
                                                                            <button class="btn btn-secondary"
                                                                                wire:click="append_join_table({{ $key }})">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    fill="currentColor"
                                                                                    class="bi bi-plus-lg"
                                                                                    viewBox="0 0 16 16">
                                                                                    <path fill-rule="evenodd"
                                                                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                                                                </svg>
                                                                            </button>
                                                                        </div>

                                                                        <div class="mt-1">
                                                                            <button class="btn btn-danger"
                                                                                wire:click="remove_all_join_table({{ $key }})">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    fill="currentColor"
                                                                                    class="bi bi-trash3"
                                                                                    viewBox="0 0 16 16">
                                                                                    <path
                                                                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @foreach ($wh['joins']['tables'] as $jkey => $jtable)
                                                                    <div class="col-md-6 row"
                                                                        wire:key="filter-where-join-{{ $key }}-jtable-{{ $jkey }}">
                                                                        <div class="col-md-9 pe-0">
                                                                            <label
                                                                                for="filter-where-join-{{ $key }}-jtable-{{ $jkey }}"
                                                                                class="form-label">Table</label>
                                                                            <select
                                                                                name="filter-where-join-{{ $key }}-jtable"
                                                                                class="form-select"
                                                                                id="filter-where-join-{{ $key }}-jtable-{{ $jkey }}"
                                                                                wire:key="filter-where-join-{{ $key }}-jtable-{{ $jkey }}"
                                                                                wire:model="values.where.{{ $key }}.joins.tables.{{ $jkey }}.value"
                                                                                wire:change="get_columns_of_table_join({{ $key }}, {{ $jkey }})">
                                                                                <option value=""></option>
                                                                                @foreach ($base_data['tables'] as $table)
                                                                                    <option
                                                                                        value="{{ $table['id'] }}">
                                                                                        {{ $table['name'] }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <button class="btn btn-sm btn-danger"
                                                                                wire:click="remove_join_table({{ $key }}, {{ $jkey }})">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="16" height="16"
                                                                                    fill="currentColor"
                                                                                    class="bi bi-x-lg"
                                                                                    viewBox="0 0 16 16">
                                                                                    <path
                                                                                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                                <div class="col-md-6">
                                                                    <label
                                                                        for="filter-where-join-column-{{ $key }}"
                                                                        class="form-label">Column</label>
                                                                    <select name="filter-where-join-column"
                                                                        class="form-select"
                                                                        id="filter-where-join-column-{{ $key }}"
                                                                        wire:model="values.where.{{ $key }}.joins.value"
                                                                        wire:change="choose_column({{ $key }})">
                                                                        <option value=""></option>
                                                                        @foreach ($values['columns_helper'][$key] as $column)
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
                                                                            class="form-label">Data type</label>
                                                                        <select name="filter-where-join-data-type"
                                                                            class="form-select"
                                                                            id="filter-where-join-data-type-{{ $key }}"
                                                                            wire:model="values.where.{{ $key }}.data_type">
                                                                            <option value="normal">Normal</option>
                                                                            @foreach ($base_data['column_data_types'] as $data_type)
                                                                                <option
                                                                                    value="{{ $data_type['id'] }}">
                                                                                    {{ $data_type['name'] }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    @if ($wh['data_type'] != 'normal')
                                                                        <div class="col-md-6">
                                                                            <label
                                                                                for="filter-where-join-operation-{{ $key }}"
                                                                                class="form-label">Operation</label>
                                                                            <select name="filter-where-join-operation"
                                                                                class="form-select"
                                                                                id="filter-where-join-operation-{{ $key }}"
                                                                                wire:model="values.where.{{ $key }}.operation">
                                                                                <option value=""></option>
                                                                                @foreach ($base_data['operations'] as $operation)
                                                                                    <option
                                                                                        value="{{ $operation['id'] }}">
                                                                                        {{ $operation['name'] }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    @endif

                                                                    @if ($wh['joins']['value'] != '')
                                                                        @if (in_array($wh['joins']['type'], ['integer', 'float', 'double']))
                                                                            <div class="col-md-6">
                                                                                <label class="form-label">Value</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    wire:model="values.where.{{ $key }}.value" />
                                                                            </div>

                                                                            @if ($wh['operation'] == 'between')
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">Second
                                                                                        Value</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        wire:model="values.where.{{ $key }}.value_2" />
                                                                                </div>
                                                                            @endif
                                                                        @elseif (in_array($wh['joins']['type'], ['date', 'datetime', 'timestamp']))
                                                                            <div class="col-md-6">
                                                                                <label class="form-label">Value</label>
                                                                                <input type="date"
                                                                                    class="form-control"
                                                                                    wire:model="values.where.{{ $key }}.value" />
                                                                            </div>

                                                                            @if ($wh['operation'] == 'between')
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">Second
                                                                                        Value</label>
                                                                                    <input type="date"
                                                                                        class="form-control"
                                                                                        wire:model="values.where.{{ $key }}.value_2" />
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
                                                                                    wire:model="values.where.{{ $key }}.value">
                                                                                    <option value=""></option>
                                                                                    @foreach ($values['values_helper'][$key] as $value)
                                                                                        <option
                                                                                            value="{{ $value['id'] }}">
                                                                                            {{ $value['val'] }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif

                                                            <div class="col-md-12 text-end my-2">
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    wire:click="remove_where({{ $key }})"
                                                                    style="margin-top: 31px;">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16"
                                                                        fill="currentColor" class="bi bi-trash2-fill"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225zm9.89-.69C10.966 2.214 9.578 2 8 2c-1.58 0-2.968.215-3.926.534-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466-.18-.14-.498-.307-.975-.466z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        @if ($where_length - 1 > $key)
                                                            <div class="row ps-5 mb-3">
                                                                <div class="col-md-1">
                                                                    <select name="filter-where-type-2"
                                                                        class="form-select"
                                                                        id="filter-where-type-2-{{ $key }}"
                                                                        wire:model="values.where.{{ $key }}.where_type">
                                                                        @foreach ($base_data['where_types'] as $type)
                                                                            <option value="{{ $type['id'] }}">
                                                                                {{ $type['name'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card col-md-12">
                                                <div class="card-body">
                                                    <span class="text-danger">No filters yet!</span>
                                                </div>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="text-end mt-4">
                                        <button type="button" class="btn btn-sm btn-primary"
                                            wire:click="append_where">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-plus-circle-fill"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="{{ $options['selected_step'] == 5 ? 'current' : 'pending' }}"
                                data-kt-stepper-element="content">
                                <div class="w-100 text-center">
                                    <h1 class="fw-bold text-dark mb-3">Release!</h1>
                                    <div class="text-muted fw-semibold fs-3">Submit your app to kickstart your project.
                                    </div>
                                    <div class="text-center px-4 py-15">
                                        <img src="/metronic8/demo1/assets/media/illustrations/sketchy-1/9.png"
                                            alt="" class="mw-100 mh-300px">
                                    </div>
                                </div>
                            </div>

                            <!-- NOTE - Actions -->
                            <div class="d-flex flex-stack pt-10">
                                <div class="me-2">
                                    @if ($options['selected_step'] > 1)
                                        <button type="button" class="btn btn-lg btn-light-primary me-3"
                                            wire:click="action_step('previous')">
                                            <span class="svg-icon svg-icon-3 me-1">
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="6" y="11"
                                                        width="13" height="2" rx="1"
                                                        fill="currentColor"></rect>
                                                    <path
                                                        d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                            </span>Back
                                        </button>
                                    @endif
                                </div>

                                <div>
                                    @if ($options['selected_step'] == 5)
                                        <button type="button" class="btn btn-lg btn-primary px-4"
                                            wire:click="get_data">
                                            Preview
                                        </button>
                                        <button type="button" class="btn btn-lg btn-success px-4"
                                            wire:click="save_modal">
                                            Save
                                        </button>
                                    @endif

                                    <button type="button" class="btn btn-lg btn-danger" wire:click="cancel">
                                        Cancel
                                    </button>

                                    @if ($options['selected_step'] < 5)
                                        <button type="button" class="btn btn-lg btn-primary"
                                            wire:click="action_step('next')">Continue
                                            <span class="svg-icon svg-icon-3 ms-1 me-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="18" y="13"
                                                        width="13" height="2" rx="1"
                                                        transform="rotate(-180 18 13)" fill="currentColor"></rect>
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
            </div>
        </div>
    </div>
</div>
