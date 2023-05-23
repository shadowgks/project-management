<div class="app-content flex-column-fluid">
    <div class="app-container container-fluid">
        <div class="card mt-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">{{ __('Module') }}</span>
                        </label>
                        <select class="form-select form-control-lg form-control-solid"
                            wire:model="dropdown_trait.values.module">
                            <option disabled value="">
                                {{ __('Choose Module') }}
                            </option>
                            @foreach ($dropdown_trait['base_data']['modules'] as $module)
                                <option value="{{ $module['id'] }}">
                                    {{ $module['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">{{ __('Table') }}</span>
                        </label>
                        <select class="form-select form-control-lg form-control-solid"
                            wire:model="dropdown_trait.values.table" wire:change="dropdown_get_columns">
                            <option disabled value="">
                                {{ __('Choose Table') }}
                            </option>
                            @foreach ($dropdown_trait['base_data']['tables'] as $table)
                                <option value="{{ $table['id'] }}">
                                    {{ $table['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if (!empty($dropdown_trait['values']['table']))
                        <div class="col-md-4 fv-row mb-10 fv-plugins-icon-container">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">{{ __('Column') }}</span>
                            </label>
                            <select class="form-select form-control-lg form-control-solid"
                                wire:model="dropdown_trait.values.column" wire:change="dropdown_get_columns">
                                <option disabled value="">
                                    {{ __('Choose Column') }}
                                </option>
                                @foreach ($dropdown_trait['base_data']['columns'] as $column)
                                    <option value="{{ $column['id'] }}">
                                        {{ $column['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="col-md-12">
                        @if (count($dropdown_trait['values']['fields']) > 0)
                            <div class="px-4 py-1 bg-secondary rounded">
                                @foreach ($dropdown_trait['values']['fields'] as $optionKey => $option)
                                    <div class="card card-flush my-4">
                                        <div class="card-body">
                                            <div class="row m-0">
                                                <div class="col-md-5 fv-plugins-icon-container">
                                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                        <span>{{ __('Value') }}</span>
                                                    </label>
                                                    <input type="text"
                                                        class="form-control form-control-lg form-control-solid"
                                                        placeholder="{{ __('Value') }}"
                                                        wire:model.lazy="dropdown_trait.values.fields.{{ $optionKey }}.id">
                                                </div>

                                                <div class="col-md-5 fv-plugins-icon-container">
                                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                                        <span>{{ __('Text') }}</span>
                                                    </label>
                                                    <input type="text"
                                                        class="form-control form-control-lg form-control-solid"
                                                        placeholder="{{ __('Text') }}"
                                                        wire:model.lazy="dropdown_trait.values.fields.{{ $optionKey }}.value">
                                                </div>

                                                <div class="col-md-2 d-flex align-items-end justify-content-center">
                                                    <button type="button" class="btn btn-danger mb-2"
                                                        wire:click="dropdown_removeOption({{ $optionKey }})">
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
                                <button type="button" class="btn btn-primary btn-sm mt-2"
                                    wire:click="dropdown_addOption()">
                                    <i class="fa fa-plus p-0"></i>
                                    {{ __('Option') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-success"
                            wire:click="dropdown_save">{{ __('Save') }}</button>
                        <button type="button" class="btn btn-danger ms-2"
                            wire:click="dropdown_cancel">{{ __('Cancel') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
