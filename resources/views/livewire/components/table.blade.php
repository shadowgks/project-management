@inject('model_helper', 'App\Helpers\ModelHelper')

@section('styles')
    <link rel="shortcut icon" href="{{ asset('css-files/jquery.dataTables.min.css') }}" />
    <style>
        .dataTables_paginate {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-end;
        }

        .dataTables_paginate .paginate_button {
            cursor: pointer;
            padding: .8rem 1.4rem;
            margin: 0 .2rem;
            color: #ffffff;
            background-color: #2D70F4;
            border-radius: .4rem;
            transition: background-color .3s ease;
        }

        .dataTables_paginate .paginate_button:hover {
            color: #ffffff;
            background-color: #284C9C;
        }

        .dataTables_paginate .disabled,
        .dataTables_paginate .disabled:hover {
            cursor: default;
            background-color: #7487B9;
        }

        .dataTables_paginate .current,
        .dataTables_paginate .current:hover {
            cursor: default;
            color: #2D70F4;
            background-color: #edf2f4;
        }

        .dataTables_filter {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
        }

        .dataTables_filter input {
            margin-left: .2rem;
            padding: .2rem .5rem;
            border: none;
            border-bottom: 1px solid #2D70F4;
        }

        .dataTables_filter input:focus {
            border-bottom: 1px solid #284C9C;
            outline: none;
        }

        .dataTables_length {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .dataTables_processing {
            display: none !important;
        }
    </style>
@endsection

@if ($withCard)
    <div class="card mt-6 {{ $cardClass }}">
        <div class="card-body">
@endif

<div class="table-responsive {{ $class }}" {{ $_id == null ? '' : 'id=' . $_id }}
    {{ $_key == null ? '' : 'wire:key=' . $_key }}>
    <table class="table table-striped dataTable gy-5 gx-2" id="table{{ $_id == null ? '' : '-' . $_id }}">
        <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                @foreach ($columns as $column)
                    <th
                        class="sorting {{ in_array($column, ['action', 'actions', 'option', 'options']) ? 'text-end' : '' }}">
                        @if ($column == 'checkbox')
                            {{-- <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox">
                            </label> --}}
                        @else
                            {{ $column }}
                        @endif
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

@if ($withCard)
    </div>
    </div>
@endif

{{-- Section table script - start --}}
<script>
    window.addEventListener("load", () => {
        @if ($filters == null)
            init_datatable("{{ $_id }}", "{{ $route }}",
                @json($this->initColumns()),
                {{ $module_id == null ? 'null' : $module_id }}
            );
        @else
            init_datatable("{{ $_id }}", "{{ $route }}",
                @json($this->initColumns()),
                {{ $module_id == null ? 'null' : $module_id }},
                @json($filters));
        @endif
    })
</script>
{{-- Section table script - end --}}
