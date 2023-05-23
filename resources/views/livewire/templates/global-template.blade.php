@php
    $time = time();
    $filterLoopsLength = isset($filterLoops) ? count($filterLoops) : 0;
    $baseDataLength = isset($base_data) ? count($base_data) : 0;
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

                <a class="btn btn-sm btn-primary ms-2 font-weight-bolder font-size-sm cursor-pointer"
                    wire:click="action_options('show_filters')">Filter</a>
            </div>
        </div>

        @if ($options['show_filters'])
            <div class="card-body">
                <div class="py-3">
                    @if (isset($base_data['custom_filters']))
                        @foreach ($base_data['custom_filters'] as $key => $filter)
                            <span
                                class="badge badge{{ $options['selected_filter'] == $key ? '-light' : '' }}-primary flex-shrink-0 align-self-center py-3 px-4 mb-2 fs-7 cursor-pointer"
                                wire:click="get_custom_filter_data({{ $key }})">{{ $filter['name'] }}</span>
                        @endforeach
                    @endif
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
    </div>

    @if ($options['show_content'])
        <div class="row flex-nowrap">
            <div class="col-md-6">
                <livewire:table _key="table-{{ $time }}" :data="isset($base_data['data']) ? $base_data['data'] : []" :columns="isset($base_data['columns']) ? $base_data['columns'] : []"
                    :totals="isset($base_data['totals']) ? $base_data['totals'] : []" />
            </div>
            <div class="col-md-6">
                <div class="card mt-6" id="content">
                    <div class="card-body">
                        <div class="col-md-6 mb-2">
                            <label for="content-input" class="form-label">Name</label>
                            <input type="text" class="form-control col-md-12" id="content-input" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <livewire:table _key="table-{{ $time }}" :data="isset($base_data['data']) ? $base_data['data'] : []" :columns="isset($base_data['columns']) ? $base_data['columns'] : []" :totals="isset($base_data['totals']) ? $base_data['totals'] : []" />
    @endif

    @if ($options['show_form'])
        <div class="card mt-6">
            <div class="card-body">
                <div class="row m-0">
                    @foreach ($elementsForm as $element)
                        {!! TemplateHelper::getFormElement($element) !!}
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
