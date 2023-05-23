@php
    $time = time();
    $filterLoopsLength = count($filterLoops);
    $baseDataLength = count($baseData);
@endphp

@section('title', $title)

<div wire:key="module-template-{{ $time }}">
    <div class="card">
        <div class="card-header border-0">
            <h3 class="card-title"></h3>
            <div class="card-toolbar">
                <a class="btn btn-sm btn-primary font-weight-bolder font-size-sm cursor-pointer"
                    wire:click="action_options('show_modal')">Add</a>
            </div>
        </div>
    </div>

    <div class="card mt-6">
        <div class="card-header border-0">
            <h3 class="card-title"></h3>
            <div class="card-toolbar">
                <a class="btn btn-sm btn-primary font-weight-bolder font-size-sm cursor-pointer"
                    wire:click="action_options('show_filters')">Filter</a>
            </div>
        </div>

        @if ($options['show_filters'])
            <div class="card-body">
                <div class="py-3">
                    @foreach ($custom_filters as $key => $filter)
                        <span
                            class="badge badge{{ $options['selected_filter'] == $key ? '-light' : '' }}-primary flex-shrink-0 align-self-center py-3 px-4 mb-2 fs-7 cursor-pointer"
                            wire:click="get_custom_filter_data({{ $key }})">{{ $filter['name'] }}</span>
                    @endforeach
                </div>

                @if ($filterLoopsLength > 0)
                    <div class="row">
                        @foreach ($filterLoops as $filter)
                            @if (!isset($filter['condition']) || $filters[$filter['condition']['where']] == $filter['condition']['value'])
                                @if (!isset($filter['type']) || $filter['type'] == 'select')
                                    <div class="col-md-3 mb-2">
                                        <label for="filter-{{ $filter['id'] }}"
                                            class="form-label">{{ $filter['label'] }}</label>

                                        <select name="filter-{{ $filter['id'] }}" class="form-select"
                                            id="filter-{{ $filter['id'] }}" wire:model="{{ $filter['model'] }}"
                                            wire:change="filter_data">
                                            {{-- wire:change="$emitSelf('filter_data')"> --}}
                                            <option value="">All</option>
                                            @if ($baseDataLength > 0)
                                                @foreach ($baseData[$filter['data']] as $dt)
                                                    @if (isset($filter['value']) && isset($filter['text']))
                                                        <option value="{{ $dt[$filter['value']] }}">
                                                            {{ $dt[$filter['text']] }}</option>
                                                    @else
                                                        <option value="{{ $dt }}">{{ $dt }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                @else
                                    <div class="col-md-3 mb-2">
                                        <label for="filter-{{ $filter['id'] }}"
                                            class="form-label">{{ $filter['label'] }}</label>
                                        <input type="{{ $filter['type'] }}" class="form-control col-md-12"
                                            id="filter-{{ $filter['id'] }}" wire:model="{{ $filter['model'] }}"
                                            wire:change="filter_data" />
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>

    <livewire:table _key="table-{{ $time }}" :data="isset($table['data']) ? $table['data'] : []" :columns="isset($table['columns']) ? $table['columns'] : []" :totals="isset($table['totals']) ? $table['totals'] : []" />

    <div class="modal black-background-transparent fade {{ $options['show_modal'] ? 'show' : '' }}" id="modal-view"
        tabindex="-1" role="dialog" style="display: {{ $options['show_modal'] ? 'block' : 'none' }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ $options['id'] == null ? 'New' : 'Edit' }} Sales</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1" wire:click="action_options('show_modal')">
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

                <div class="modal-body">
                    <div class="fv-row mb-10 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">App Name</span>
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                aria-label="Specify your unique app name"
                                data-bs-original-title="Specify your unique app name" data-kt-initialized="1"></i>
                        </label>
                        <input type="text" class="form-control form-control-lg form-control-solid" name="name"
                            placeholder="" value="">
                        <div class="fv-plugins-message-container invalid-feedback"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
