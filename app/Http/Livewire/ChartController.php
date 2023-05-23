<?php

namespace App\Http\Livewire;

use App\Helpers\DateHelper;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Order;

class ChartController extends Component
{
    // Data
    public $base_data = [
        'data' => [],
        'labels' => [],
        'months' => [],
        'years' => [],
    ];

    public $filters = [
        'month' => '',
        'year' => '',
    ];

    // Methods
    public function render()
    {
        return view('livewire.Chart');
    }

    public function mount()
    {
        $this->generateData();
        $this->base_data['months'] = DateHelper::get_months(false);
        $this->base_data['years'] = DateHelper::get_years(now()->year);
    }

    public function getData()
    {
        // dd('yooo');
        $this->generateData();

        $this->dispatchBrowserEvent('contentChanged', [
            'data' => $this->base_data['data'],
            'labels' => $this->base_data['labels'],
        ]);
    }

    private function generateData()
    {
        $columns = ['sub_total', 'total'];
        $model = new Order();

        $columns_helper = [];
        $data_helper = [];
        $data_set = [];

        foreach ($columns as $column) {
            $data_helper[$column] = [];
        }

        for ($label = 1; $label <= DateHelper::get_days_of_month(now()->month); $label++) {
            $data = $model->select(DB::raw('cast(count(sub_total) as decimal(10, 2)) as sub_total, cast(sum(total) as decimal(10, 2)) as total'))->whereDay('created_at', $label);

            if ($this->filters['month'] != '') {
                $data = $data->whereMonth('created_at', $this->filters['month']);
            }

            if ($this->filters['year'] != '') {
                $data = $data->whereYear('created_at', $this->filters['year']);
            }

            $data = $data->first()->toArray();

            foreach ($columns as $column) {
                array_push($data_helper[$column], $data[$column] ?? 0);
            }
            array_push($columns_helper, $label);
        }

        foreach ($columns as $column) {
            array_push($data_set, [
                'name' => $column,
                'data' => $data_helper[$column],
            ]);
        }

        $labels = $columns_helper;

        if (in_array('bar', ['pie', 'donut'])) {
            $data_set = $data_set[0]['data'];
        }

        $this->base_data['data'] = $data_set;
        $this->base_data['labels'] = $labels;
    }

    public function boot()
    {
        $now = now();
        $this->filters['month'] = $now->month;
        $this->filters['year'] = $now->year;
    }
}
