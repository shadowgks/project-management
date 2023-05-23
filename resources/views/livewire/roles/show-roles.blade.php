
<div class="mt-10">

    <div class="card">
        <div class="card-header border-0">
            <div class="card-title">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('Roles') }}
                </h1>
            </div>
            <div class="card-toolbar">
                <a class="btn btn-sm btn-primary font-weight-bolder font-size-sm cursor-pointer me-1"
                    wire:click="new_role">
                    {{ __('Add') }}
                </a>
            </div>
        </div>

        @if ($options['show_filters'])
            <div class="card-body">
                <div class="py-3">
                    @foreach ($base_data['custom_filters'] as $key => $filter)
                        <span
                            class="badge badge{{ $options['selected_filter'] == $key ? '-light' : '' }}-primary flex-shrink-0 align-self-center py-3 px-4 mb-2 fs-7 cursor-pointer"
                            wire:click="get_custom_filter_data({{ $key }})">{{ $filter['name'] }}</span>
                    @endforeach
                </div>

                @if ($base_data['filterLoopsLength'] > 0)
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

    <div class="card mt-6">
        <div class="card-body">
            
            <div class="table-responsive " >
                <table class="table table-striped dataTable gy-5 gx-2">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="sorting">
                                {{  __('role_name') }}
                            </th>
                            <th class="sorting">
                                {{  __('app_name') }}
                            </th>
                            <th class="sorting">
                                {{  __('gate_name') }}
                            </th>
                            <th class="sorting">
                                {{  __('actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $dt)
                            <tr>
                                <td class="fw-bold fs-6">
                                    <a href="{{ route('role.index', [$dt['id']]) }}" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6" > {{ $dt['name'] }}</a>
                                    
                                </td>
                                <td class="fw-bold fs-6">
                                    {{ $dt['app']['name'] }}
                                </td>
                                <td class="fw-bold fs-6">
                                    {{ $dt['gate']['name'] }}
                                </td>
                                <td class="fw-bold fs-6">
                                    <button wire:click="edit_role({{ $dt['id'] }})" type="button" class="btn btn-secondary p-3 me-2">
                                        <i class="la la-edit p-0"></i>
                                    </button>
                                    <button wire:click="delete_role({{ $dt['id'] }})" type="button" class="btn btn-danger p-3 me-2">
                                        <i class="la la-trash p-0"></i>
                                    </button>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
