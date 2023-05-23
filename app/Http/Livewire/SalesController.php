<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Helpers\DateHelper;
use App\Helpers\StringHelper;
use App\Helpers\ModelHelper;
use App\Models\CustomFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Auth;
use PdfReport;
use ExcelReport;
use DataTables;

class SalesController extends Component
{
    // Data
    public $base_data = [
        'title' => 'sales',
        'data' => [],
        'types' => ['number', 'date', 'total', 'branch.name'],
        'columns' => ['number', 'date', 'total', 'branch.name'],
        'operations' => [],
        'totals' => [],
        'number' => [], 'periods' => [['id' => '1', 'name' => 'From the beginning'], ['id' => '2', 'name' => 'This month'], ['id' => '3', 'name' => 'Last month'], ['id' => '4', 'name' => 'This year'], ['id' => '5', 'name' => 'Last year'], ['id' => '6', 'name' => 'Last 3 months'], ['id' => '7', 'name' => 'Last 6 months'], ['id' => '8', 'name' => 'Last 12 months'], ['id' => '9', 'name' => 'Period'],], 'branch_id' => [],
        'custom_filters' => [],
        'user' => null,
        'testData' => [
            [
                'id' => 1,
                'cc' => 'value 1',
            ],
            [
                'id' => 2,
                'cc' => 'value 2',
            ],
        ],
    ];

    public $filters = [
        'number' => '', 'date' => '', 'date_period' => 1, 'date_from' => '', 'date_to' => '', 'branch_id' => '',
    ];

    public $options = [
        'show_filters' => false, 'selected_filter' => -1,
        'show_modal' => false,
        'show_form' => false,
        'show_content' => false,
        'id' => null,
    ];

    public $filterLoops = [
        [
            "id" => "number",
            "label" => "number",
            "model" => "filters.number",
            "data" => "number",
            "value" => "number",
            "text" => "number",
        ], [
            "id" => "date-period",
            "label" => "Period",
            "model" => "filters.date_period",
            "data" => "periods",
            "value" => "id",
            "text" => "name",
        ], [
            "id" => "date-from",
            "type" => "date",
            "label" => "date From",
            "model" => "filters.date_from",
            "condition" => [
                "where" => "date_period",
                "value" => 9,
            ],
        ], [
            "id" => "date-to",
            "type" => "date",
            "label" => "date To",
            "model" => "filters.date_to",
            "condition" => [
                "where" => "date_period",
                "value" => 9,
            ],
        ], [
            "id" => "branch_id",
            "label" => "branch_id",
            "model" => "filters.branch_id",
            "data" => "branch_id",
            "value" => "id",
            "text" => "name",
        ],
    ];

    public $testData = [
        [
            "table" => 2,
            "column" => "name",
            "label" => "Branch",
            "type" => "text",
            "value" => [
                "type" => "data",
                "table" => "",
                "column" => "",
                "custom" => []
            ],
            "default" => "",
            "placeholder" => "Something",
            "length" => 10,
            "min" => 0,
            "max" => 0,
        ],
        [
            "table" => 2,
            "column" => "cc",
            "label" => "Company",
            "type" => "select",
            "value" => [
                "type" => "data",
                "table" => "table",
                "column" => "cc",
                "custom" => []
            ],
            "default" => "",
            "placeholder" => "",
            "length" => 0,
            "min" => 0,
            "max" => 0,
        ],
        [
            "table" => 2,
            "column" => "cc",
            "label" => "Company",
            "type" => "checkbox",
            "value" => [
                "type" => "data",
                "table" => "table",
                "column" => "cc",
                "custom" => []
            ],
            "default" => "",
            "placeholder" => "",
            "length" => 0,
            "min" => 0,
            "max" => 0,
        ],
        [
            "table" => 2,
            "column" => "cc",
            "label" => "Company",
            "type" => "radio",
            "value" => [
                "type" => "data",
                "table" => "table",
                "column" => "cc",
                "custom" => []
            ],
            "default" => "",
            "placeholder" => "",
            "length" => 0,
            "min" => 0,
            "max" => 0,
        ],
    ];

    protected $listeners = [];

    // Methods
    public function render()
    {
        return view('livewire.sales');
    }

    public function mount()
    {
        $model = new Order();
        $this->base_data['number'] = \App\Models\Order::select('number')->distinct('number')->orderBy('number')->get()->toArray();
        $this->base_data['branch_id'] = \App\Models\Branch::orderBy('name')->get()->toArray();
        $this->base_data['user'] = Auth::user();
        $this->base_data['custom_filters'] = CustomFilter::where('setting_id', 13)->orderBy('name')->get()->toArray();
        $this->initEmit();
        $this->generateData();
    }

    public function filter_data()
    {
        $this->generateData();
    }

    private function generateData()
    {
        if (isset($this->options['selected_filter'])) {
            $this->options['selected_filter'] = -1;
        }

        $model = new Order();
        $order_by = 'number';
        $order_type = 'asc';
        $group_by = '';
        $data = $model->select(DB::raw('number, date, total, branch_id'));
        $data = $data->with('branch');



        if (!empty($this->filters['number'])) {
            $data = $data->where('number', $this->filters['number']);
        }
        $period_value = $this->filters['date_period'];
        if ($period_value != 1) {
            $now = now();

            if ($period_value == 2) {
                $data = $data->whereMonth('date', $now->month);
            } else if ($period_value == 3) {
                $data = $data->whereMonth('date', $now->subMonth()->month);
            } else if ($period_value == 4) {
                $data = $data->whereYear('date', $now->year);
            } else if ($period_value == 5) {
                $data = $data->whereYear('date', $now->subYear()->year);
            } else if ($period_value == 6) {
                $data = $data->whereDate('date', '>=', $now->subMonth(2));
            } else if ($period_value == 7) {
                $data = $data->whereDate('date', '>=', $now->subMonth(5));
            } else if ($period_value == 8) {
                $data = $data->whereDate('date', '>=', $now->subMonth(11));
            } else if ($period_value == 9) {
                if (!empty($this->filters['date_from'])) {
                    $data = $data->whereDate('date', '>=', $this->filters['date_from']);
                }

                if (!empty($this->filters['date_to'])) {
                    $data = $data->whereDate('date', '<=', $this->filters['date_to']);
                }
            }
        }
        if (!empty($this->filters['branch_id'])) {
            $data = $data->where('branch_id', $this->filters['branch_id']);
        }

        if (isset($order_by) and !empty($order_by))
            $data = $data->orderBy($order_by, $order_type);

        if (isset($group_by) and !empty($group_by))
            $data = $data->groupBy($group_by);

        $data = Datatables::of($data)->addIndexColumn();

        foreach ($this->base_data['columns'] as $column) {
            if (str_contains($column, '.')) {
                $data = $data->addColumn($column, function ($row) use ($column) {
                    return StringHelper::printData($column, $row);
                });
            }
        }

        $data = $data->rawColumns([])->make(true)->original['data'];

        $this->base_data['data'] = $data;
    }

    public function get_custom_filter_data($key)
    {
        if (isset($this->options['selected_filter'])) {
            $this->options['selected_filter'] = $key;
        }

        $model = new Order();
        $order_by = 'date';
        $order_type = 'desc';
        $group_by = '';
        $value = $this->base_data['custom_filters'][$key]['value'];
        $where = @unserialize($value) ? unserialize($value)['where'] : [];
        $data = $model->select(DB::raw('number, date, total, branch_id'));
        $data = $data->with('customer');
        $data->with('branch');

        $data = ModelHelper::whereData($data, $where);

        if (isset($order_by) and !empty($order_by))
            $data = $data->orderBy($order_by, $order_type);

        if (isset($group_by) and !empty($group_by))
            $data = $data->groupBy($group_by);

        $data = Datatables::of($data)->addIndexColumn();

        foreach ($this->base_data['columns'] as $column) {
            if (str_contains($column, '.')) {
                $data = $data->addColumn($column, function ($row) use ($column) {
                    return StringHelper::printData($column, $row);
                });
            }
        }

        $data = $data->rawColumns([])->make(true)->original['data'];

        $this->base_data['data'] = $data;
    }

    public function pdf()
    {
        $order_by = 'number';
        $order_type = 'asc';
        $group_by = '';
        $columns_array = ['number', 'date', 'total', 'branch.name'];
        $totals = [];
        $meta = [ // For displaying filters description on header
            'Registered on' => '11/08/2022',
        ];

        $model = new Order();
        $queryBuilder = $model::select($columns_array);

        $queryBuilder = $queryBuilder->with('branch');

        if (isset($order_by) and !empty($order_by))
            $queryBuilder = $queryBuilder->orderBy($order_by, $order_type);

        if (isset($group_by) and !empty($group_by))
            $queryBuilder = $queryBuilder->groupBy($group_by);

        $result = PdfReport::of('Orders Report', $meta, $queryBuilder, $columns_array);
        // ->editColumn('date', [ // Change column class or manipulate its data for displaying to report
        //     'displayAs' => function ($result) {
        //         return $result->created_at->format('d M Y');
        //     },
        //     'class' => 'left'
        // ])

        if (count($totals) > 0) {
            $result = $result->showTotal($totals);
        }

        return $result->limit(20) // Limit record to be showed
            // ->stream();
            ->make()
            ->download('Orders Report');
    }

    public function excel(Request $request)
    {
        $order_by = 'number';
        $order_type = 'asc';
        $group_by = '';
        $columns_array = ['number', 'date', 'total', 'branch.name'];
        $meta = [
            'Registered on' => '11/08/2022',
        ];

        $model = new Order();
        $queryBuilder = $model::select($columns_array);

        $queryBuilder = $queryBuilder->with('branch');

        if (isset($order_by) and !empty($order_by))
            $queryBuilder = $queryBuilder->orderBy($order_by, $order_type);

        if (isset($group_by) and !empty($group_by))
            $queryBuilder = $queryBuilder->groupBy($group_by);

        return ExcelReport::of('Orders Report', $meta, $queryBuilder, $columns_array)
            ->simple()
            ->download('Orders Report');
    }


    public function action_options($name)
    {
        $this->options[$name] = !$this->options[$name];
    }

    public function initEmit()
    {
        foreach ($this->filterLoops as $filter) {
            $split = explode(".", $filter["model"]);
            array_push($this->listeners, "change_select_filters_" . $split[1]);
        }
    }


    // NOTE - Emits

    public function change_select_filters_number($value)
    {
        $this->filters["number"] = $value;
    }
    public function change_select_filters_date($value)
    {
        $this->filters["date"] = $value;
    }
    public function change_select_filters_date_from($value)
    {
        $this->filters["date_from"] = $value;
    }
    public function change_select_filters_date_to($value)
    {
        $this->filters["date_to"] = $value;
    }
    public function change_select_filters_branch_id($value)
    {
        $this->filters["branch_id"] = $value;
    }
}
