@php
    use App\Helpers\ModelHelper;
    use App\Helpers\TemplateHelper;
@endphp

<div class="w-100">
    @if ($countTables > 0)
        <div class="px-4 py-1 bg-secondary">
            @foreach ($tables as $key => $table)
                <div class="card card-flush my-4">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Table
                                {{ $key + 1 }}</span>
                            {{-- <span class="text-gray-400 mt-1 fw-semibold fs-6">Users from all channels</span> --}}
                        </h3>

                        <div class="card-toolbar">
                            <button type="button" class="btn btn-danger" wire:click="removeTable({{ $key }})">
                                <i class="fa fa-trash p-0"></i>
                                {{-- {{ __('Remove') }} --}}
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div wire:key="table-{{ $key }}">
                            <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                                <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                    <span class="required">{{ __('Table Name') }}</span>
                                </label>
                                <input type="text" class="form-control form-control-lg form-control-solid"
                                    name="name" placeholder="{{ __('Table Name') }}"
                                    wire:model.lazy="tables.{{ $key }}.table_name">
                                {!! TemplateHelper::getFormMessage($table['errors']) !!}
                            </div>

                            <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox"
                                    wire:model="tables.{{ $key }}.table_contain_numbering">
                                <span
                                    class="form-check-label fw-semibold text-muted">{{ __('Contain numbering') }}</span>
                            </label>

                            <label class="form-check form-switch form-check-custom form-check-solid mb-3">
                                <input class="form-check-input" type="checkbox"
                                    wire:model="tables.{{ $key }}.table_contain_barcode">
                                <span class="form-check-label fw-semibold text-muted">{{ __('Contain barcode') }}</span>
                            </label>

                            @php
                                $field_count = count($table['fields']);
                            @endphp

                            @if ($field_count > 0)
                                <h3 class="fw-bold mb-3">{{ __('Fields') }}</h3>
                                <div class="p-4 bg-light-secondary">
                                    @foreach ($table['fields'] as $key_2 => $field)
                                        <div class="card card-flush {{ $field_count - 1 == $key_2 ? '' : 'mb-4' }}">
                                            <div class="card-body"
                                                wire:key="table-{{ $key }}-fields-{{ $key_2 }}">
                                                <div class="row">
                                                    <div class="col-md-6 mb-10 fv-plugins-icon-container">
                                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                            <span class="required">{{ __('Field Name') }}</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control form-control-lg form-control-solid"
                                                            name="name" placeholder="{{ __('Field Name') }}"
                                                            wire:model.lazy="tables.{{ $key }}.fields.{{ $key_2 }}.field_name">
                                                        {!! TemplateHelper::getFormMessage($field['errors']['field_name']) !!}
                                                    </div>

                                                    @if (!$field['field_seconday_key'])
                                                        <div class="col-md-6 mb-10 fv-plugins-icon-container">
                                                            <label
                                                                class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                                <span class="required">{{ __('Field Type') }}</span>
                                                            </label>
                                                            <select
                                                                class="form-select form-control-lg form-control-solid"
                                                                wire:model.lazy="tables.{{ $key }}.fields.{{ $key_2 }}.field_type">
                                                                <option disabled value="">
                                                                    {{ __('Choose type') }}
                                                                </option>
                                                                @foreach ($base_data['types'] as $type)
                                                                    <option value="{{ $type }}">
                                                                        {{ __($type) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            {!! TemplateHelper::getFormMessage($field['errors']['field_type']) !!}
                                                        </div>
                                                    @endif

                                                    @if ($field['field_type'] == 'string')
                                                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                                            <label
                                                                class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                                <span class="required">{{ __('Field Length') }}</span>
                                                            </label>
                                                            <input type="number"
                                                                class="form-control form-control-lg form-control-solid"
                                                                name="name" placeholder="{{ __('Field Length') }}"
                                                                wire:model.lazy="tables.{{ $key }}.fields.{{ $key_2 }}.field_length">
                                                        </div>
                                                    @endif

                                                    @if (ModelHelper::inFloatType($field['field_type']))
                                                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                                            <label
                                                                class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                                <span
                                                                    class="required">{{ __('Field Precision') }}</span>
                                                            </label>
                                                            <input type="number"
                                                                class="form-control form-control-lg form-control-solid"
                                                                name="name"
                                                                placeholder="{{ __('Field Precision') }}"
                                                                wire:model.lazy="tables.{{ $key }}.fields.{{ $key_2 }}.field_precision">
                                                        </div>

                                                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                                            <label
                                                                class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                                <span class="required">{{ __('Field Scale') }}</span>
                                                            </label>
                                                            <input type="number"
                                                                class="form-control form-control-lg form-control-solid"
                                                                name="name" placeholder="{{ __('Field Scale') }}"
                                                                wire:model.lazy="tables.{{ $key }}.fields.{{ $key_2 }}.field_scale">
                                                        </div>
                                                    @endif

                                                    @if (ModelHelper::isEnumType($field['field_type']))
                                                        <div class="col-md-4 mb-10 fv-plugins-icon-container">
                                                            <label
                                                                class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                                <span
                                                                    class="required">{{ __('Field Enum values') }}</span>
                                                            </label>
                                                            <input type="text"
                                                                class="form-control form-control-lg form-control-solid"
                                                                name="name"
                                                                placeholder="{{ __('Field Enum values') }}"
                                                                wire:model.lazy="tables.{{ $key }}.fields.{{ $key_2 }}.field_enum_values">
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="row m-0">
                                                    <label
                                                        class="col-md-4 form-check form-switch form-check-custom form-check-solid mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            wire:model="tables.{{ $key }}.fields.{{ $key_2 }}.field_seconday_key"
                                                            wire:change="secondaryKeyAction({{ $key }}, {{ $key_2 }})">
                                                        <span
                                                            class="form-check-label fw-semibold text-muted">{{ __('Secondary key') }}</span>
                                                    </label>

                                                    @if ($field['field_seconday_key'])
                                                        <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                                                            <select
                                                                class="form-select form-control-lg form-control-solid"
                                                                wire:model="tables.{{ $key }}.fields.{{ $key_2 }}.field_seconday_value">
                                                                <option disabled value="">
                                                                    {{ __('Choose Table') }}
                                                                </option>
                                                                @foreach ($base_data['tables'] as $table)
                                                                    <option value="{{ $table['id'] }}">
                                                                        {{ __($table['name']) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                </div>

                                                <label
                                                    class="form-check form-switch form-check-custom form-check-solid mb-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        wire:model="tables.{{ $key }}.fields.{{ $key_2 }}.field_nullable">
                                                    <span
                                                        class="form-check-label fw-semibold text-muted">{{ __('Nullable') }}</span>
                                                </label>

                                                <label
                                                    class="form-check form-switch form-check-custom form-check-solid mb-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        wire:model="tables.{{ $key }}.fields.{{ $key_2 }}.field_unique">
                                                    <span
                                                        class="form-check-label fw-semibold text-muted">{{ __('Unique') }}</span>
                                                </label>

                                                <label
                                                    class="form-check form-switch form-check-custom form-check-solid mb-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        wire:model="tables.{{ $key }}.fields.{{ $key_2 }}.field_default">
                                                    <span
                                                        class="form-check-label fw-semibold text-muted">{{ __('Default') }}</span>
                                                </label>

                                                @if ($field['field_default'])
                                                    <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                                                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                            <span class="required">{{ __('Default value') }}</span>
                                                        </label>
                                                        @if ($tables[$key]['fields'][$key_2]['field_type'] == 'boolean')
                                                            {!! renderSwitch(
                                                                'field-' . $key_2 . '-default-switch',
                                                                'tables.' . $key . '.fields.' . $key_2 . '.field_default_value',
                                                                __('Default'),
                                                            ) !!}
                                                        @else
                                                            <input type="text"
                                                                class="form-control form-control-lg form-control-solid"
                                                                name="name"
                                                                placeholder="{{ __('Default value') }}"
                                                                wire:model.lazy="tables.{{ $key }}.fields.{{ $key_2 }}.field_default_value">
                                                        @endif
                                                    </div>
                                                @endif

                                                <div class="d-flex justify-content-end">
                                                    <div>
                                                        <button type="button" class="btn btn-danger"
                                                            wire:click="removeField({{ $key }}, {{ $key_2 }})">
                                                            <i class="fa fa-trash p-0"></i>
                                                            {{-- {{ __('Remove') }} --}}
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
                                        wire:click="addField({{ $key }})">
                                        <i class="fa fa-plus p-0"></i>
                                        {{ __('Field') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="d-flex justify-content-end">
        <div>
            <button type="button" class="btn btn-primary my-4" wire:click="addTable">
                <i class="fa fa-plus p-0"></i>
                {{ __('Table') }}
            </button>
        </div>
    </div>
</div>
