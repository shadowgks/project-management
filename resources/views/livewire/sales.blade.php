@php
    use App\Helpers\TemplateHelper;
    $time = time();
    $filterLoopsLength = count($filterLoops);
    $baseDataLength = count($base_data);
@endphp

@section('title', $base_data['title'])

<div wire:key="module-template-{{ $time }}">
    <div class="row m-0">
        <livewire:card-show spaceClass="col-md-3 mb-4 p-4" class="bg-primary" title="Active Projects" value="45"
            percentage="50" />
        <livewire:card-show spaceClass="col-md-3 mb-4 p-4" class="bg-info" title="Second Projects" value="8"
            percentage="8" />
        <livewire:card-show spaceClass="col-md-3 mb-4 p-4" class="bg-success" title="Projects Done" value="34"
            percentage="20" />
        <livewire:card-show spaceClass="col-md-3 mb-4 p-4" class="bg-danger" title="Projects Unused" value="13"
            percentage="10" />
    </div>

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

        @if (!$options['show_form'])
            @if ($options['show_filters'])
                <div class="card-body">
                    <div class="py-3">
                        @foreach ($base_data['custom_filters'] as $key => $filter)
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
                                                <option value="">All</option>
                                                @if ($baseDataLength > 0)
                                                    @foreach ($base_data[$filter['data']] as $dt)
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
        @endif
    </div>

    @if (!$options['show_form'])
        @if ($options['show_content'])
            <div class="row flex-nowrap">
                <div class="col-md-6">
                    <livewire:table _key="table-{{ $time }}" :data="isset($base_data['data']) ? $base_data['data'] : []" :columns="isset($base_data['columns']) ? $base_data['columns'] : []"
                        :totals="isset($base_data['totals']) ? $base_data['totals'] : []" />
                </div>
                <div class="col-md-6">
                    <div class="card mt-6" id="content">
                        <div class="card-header">
                            <h3 class="card-title">Form</h3>
                        </div>
                        <div class="card-body">
                            <div class="row m-0">
                                <div class="fv-row mb-10 col-md-6 fv-plugins-icon-container">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span class="required">Name</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg form-control-solid"
                                        name="name" placeholder="" value="">
                                </div>

                                <div class="fv-row mb-10 col-md-6 fv-plugins-icon-container">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span class="required">Date</span>
                                    </label>
                                    <input type="date" class="form-control form-control-lg form-control-solid"
                                        name="name" placeholder="" value="">
                                </div>

                                <div class="fv-row mb-10 col-md-6 fv-plugins-icon-container">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span class="required">Total</span>
                                    </label>
                                    <input type="number" class="form-control form-control-lg form-control-solid"
                                        name="name" placeholder="" value="">
                                </div>

                                <div class="fv-row mb-10 col-md-6 fv-plugins-icon-container">
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span class="required">Branch</span>
                                    </label>
                                    <select class="form-select">
                                        <option value="1">Casablanca</option>
                                        <option value="2">Rabat</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <livewire:table _key="table-{{ $time }}" :data="isset($base_data['data']) ? $base_data['data'] : []" :columns="isset($base_data['columns']) ? $base_data['columns'] : []" :totals="isset($base_data['totals']) ? $base_data['totals'] : []" />
        @endif
    @endif

    @if ($options['show_form'])
        <div class="card mt-6">
            <div class="card-header">
                <h3 class="card-title">Form</h3>
            </div>
            <div class="card-body">
                <div class="row m-0">
                    <div class="fv-row mb-10 col-md-6 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">Name</span>
                        </label>
                        <input type="text" class="form-control form-control-lg form-control-solid" name="name"
                            placeholder="" value="">
                    </div>

                    <div class="fv-row mb-10 col-md-6 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">Date</span>
                        </label>
                        <input type="date" class="form-control form-control-lg form-control-solid" name="name"
                            placeholder="" value="">
                    </div>

                    <div class="fv-row mb-10 col-md-6 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">Total</span>
                        </label>
                        <input type="number" class="form-control form-control-lg form-control-solid" name="name"
                            placeholder="" value="">
                    </div>

                    <div class="fv-row mb-10 col-md-6 fv-plugins-icon-container">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">Branch</span>
                        </label>
                        <select class="form-select">
                            <option value="1">Casablanca</option>
                            <option value="2">Rabat</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="modal black-background-transparent fade {{ $options['show_modal'] ? 'show' : '' }}" id="modal-view"
        tabindex="-1" role="dialog" style="display: {{ $options['show_modal'] ? 'block' : 'none' }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ $options['id'] == null ? 'New' : 'Edit' }} Form</h2>
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
                    <div class="row m-0">
                        @foreach ($testData as $element)
                            {!! TemplateHelper::getFormElement($element) !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
