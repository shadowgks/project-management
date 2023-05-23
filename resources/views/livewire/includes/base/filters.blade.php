{{-- Filter - start --}}
<div class="card-body {!! $options['show_filters'] ? '' : 'hidden' !!}">
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
                        <div class="col-md-3 mb-2" wire:ignore>
                            <label for="filter-{{ $filter['id'] }}" class="form-label">{{ $filter['label'] }}</label>

                            <select name="filter-{{ $filter['id'] }}" class="form-select select-2-dropdown"
                                id="filter-{{ $filter['id'] }}" onchange="ior_datatable()"
                                wire:model="{{ $filter['model'] }}">
                                <option value="">{{ __('All') }}</option>
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
                            <label for="filter-{{ $filter['id'] }}" class="form-label">{{ $filter['label'] }}</label>
                            <input type="{{ $filter['type'] }}" class="form-control col-md-12"
                                id="filter-{{ $filter['id'] }}" onchange="ior_datatable()"
                                wire:model="{{ $filter['model'] }}" />
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
    @endif
</div>
{{-- Filter - end --}}
