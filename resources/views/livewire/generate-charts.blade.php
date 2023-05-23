@php
    use Carbon\Carbon;
    $length_columns = count($base_data['columns']);
@endphp

@section('title', 'Charts')
<div class="container-fluid p-4" id="live-component" style="overflow:{{ $this->options['modal_opened'] ? ' hidden' : '' }};">
    <div class="app-main flex-column flex-row-fluid">
        <div class="d-flex flex-column flex-column-fluid">
            <!-- NOTE - App toolbar -->
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Generate charts
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="/" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Generate charts</li>
                        </ul>
                    </div>

                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a class="btn btn-sm fw-bold btn-primary" wire:click="action_modal('show', 'show_steps_modal')">
                            <span>{{ $options['list_en_going'] ? 'Continue editing' : 'Add List' }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- NOTE - App body -->
            <div class="app-content flex-column-fluid">
                <div class="app-container container-fluid">
                    <!-- NOTE - Settings -->
                    <livewire:table _id="{{ $base_data['datatable']['name'] }}" :columns="$base_data['datatable']['columns']"
                        route="{{ route($base_data['datatable']['route']) }}" />

                    <!-- NOTE - Preview -->
                    <div class="row p-4">
                        @if ($length_columns > 0)
                            <!-- NOTE - Months -->
                            @if (in_array($values['data_type'], [1, 2]))
                                <div class="col-md-3">
                                    <select name="months" class="form-select" id="months" wire:model="filters.month"
                                        wire:change="filter_data">
                                        <option value="">All</option>
                                        @foreach ($base_data['months'] as $month)
                                            <option value="{{ $month['id'] }}">{{ $month['value'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- NOTE - Years -->
                            @if (in_array($values['data_type'], [1, 2, 3]))
                                <div class="col-md-3">
                                    <select name="years" class="form-select" id="years" wire:model="filters.year"
                                        wire:change="filter_data">
                                        <option value="">All</option>
                                        @foreach ($base_data['years'] as $year)
                                            <option value="{{ $year }}">
                                                {{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        @endif

                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.modals.save-generate-chart')
    @include('livewire.modals.steps-generate-chart')
</div>

@section('scripts')
    <script>
        var options = {
            series: [{
                name: "Desktops",
                // data: [],
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: '',
                align: 'left'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: [],
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        function update_chart(data) {
            let type = data.type,
                new_options = {};

            if (['pie', 'donut'].includes(type)) {
                new_options = {
                    chart: {
                        type: data.type,
                    },
                    title: {
                        text: data.name,
                    },
                    labels: data.labels,
                    xaxis: {},
                    series: data.data,
                };
            } else {
                new_options = {
                    chart: {
                        type: data.type,
                    },
                    title: {
                        text: data.name,
                    },
                    xaxis: {
                        categories: data.labels
                    },
                    labels: null,
                    series: data.data,
                };
            }

            chart.updateOptions(new_options);
        }

        // NOTE - Events
        document.addEventListener('contentChanged', function(e) {
            let data = e.detail;
            update_chart(data);
        });

        document.addEventListener('contentReseted', function(e) {
            chart.updateOptions({
                series: [],
                xaxis: {},
                labels: null,
            });
        });
    </script>
@endsection
