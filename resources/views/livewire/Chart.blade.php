@section('title', 'Charts')
<div class="row p-4">
    <div class="col-md-3">
            <select name="months" class="form-select" id="months" wire:model="filters.month" wire:change="getData">
                <option value="">All</option>
                @foreach ($base_data['months'] as $month)
                    <option value="{{ $month['id'] }}" wire:key="month-{{ $month['id'] }}">{{ $month['value'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="years" class="form-select" id="years" wire:model="filters.year" wire:change="getData">
                <option value="">All</option>
                @foreach ($base_data['years'] as $year)
                    <option value="{{ $year }}" wire:key="year-{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>
    <div id="chart"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    window.app_locale = "{{ config('app.locale') }}";
    window.base_url = "{{ URL::to('/') }}";

    var options = {
        series: @json($base_data['data']),
        chart: {
            height: 350,
            type: "bar",
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: "straight"
        },
        title: {
            text: "Sales",
            align: "left"
        },
        grid: {
            row: {
                colors: ["#f3f3f3", "transparent"],
                opacity: 0.5
            },
        },
        xaxis: {
                categories: @json($base_data['labels']),
            }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    function update_chart(data) {
        let new_options = {};

        new_options = {
            series: data.data,
        };

        chart.updateOptions(new_options);
    }

    document.addEventListener('contentChanged', function(e) {
        let data = e.detail;
        update_chart(data);
    });
</script>
        