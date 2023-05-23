@inject('string_helper', 'App\Helpers\StringHelper')
@section('title', 'Sales')
<div class="container-fluid">
    <div class="py-3">
        @foreach ($base_data['custom_filters'] as $key => $filter)
            <span class="custom_filter"
                wire:click="get_custom_filter_data({{ $key }})">{{ $filter['name'] }}</span>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-3">
            <label for="filter-number" class="form-label">number</label>
            <select name="filter-number" class="form-select" id="filter-number" wire:model="filters.number"
                wire:change="filter_data">
                <option value="">All</option>
                @foreach ($base_data['number'] as $dt)
                    <option value="{{ $dt['number'] }}">{{ $dt['number'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="filter-sub_total" class="form-label">sub_total</label>
            <select name="filter-sub_total" class="form-select" id="filter-sub_total" wire:model="filters.sub_total"
                wire:change="filter_data">
                <option value="">All</option>
                @foreach ($base_data['sub_total'] as $dt)
                    <option value="{{ $dt['sub_total'] }}">{{ $dt['sub_total'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="filter-customer_id" class="form-label">customer_id</label>
            <select name="filter-customer_id" class="form-select" id="filter-customer_id"
                wire:model="filters.customer_id" wire:change="filter_data">
                <option value="">All</option>
                @foreach ($base_data['customer_id'] as $dt)
                    <option value="{{ $dt['id'] }}">{{ $dt['last_name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table mt-3" id="report-table">
        <thead>
            <tr>
                @foreach ($base_data['columns'] as $column)
                    <th class="bg-primary text-light">
                        {{ $column }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($base_data['data'] as $key => $dt)
                <tr>
                    @foreach ($base_data['columns'] as $column)
                        <td>
                            {{ $string_helper::printData($column, $dt) ?? '-' }}
                        </td>
                    @endforeach
                    @if (count($base_data['operations']) > 0)
                        @foreach ($base_data['operations'] as $operation)
                            <td>
                                @if ($operation['type'] == 1)
                                    <input type="text"
                                        id="{{ $operation['name'] . '-' . $operation['type'] . '-' . $key }}" />
                                @elseif ($operation['type'] == 2)
                                    <input type="checkbox"
                                        id="{{ $operation['name'] . '-' . $operation['type'] . '-' . $key }}" />
                                @elseif ($operation['type'] == 3)
                                    <select id="{{ $operation['name'] . '-' . $operation['type'] . '-' . $key }}">
                                        <option value=""></option>
                                    </select>
                                @endif
                            </td>
                        @endforeach
                    @endif
                </tr>
            @endforeach
            @if (count($base_data['totals']) > 0)
                <tr>
                    @foreach ($base_data['totals'] as $key => $total)
                        @if ($key == 0)
                            <td>Total</td>
                        @else
                            <td>{{ $total['value'] }}</td>
                        @endif
                    @endforeach
                </tr>
            @endif
        </tbody>
    </table>
</div>
