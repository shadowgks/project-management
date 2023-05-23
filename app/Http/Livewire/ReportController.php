<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Helpers\DateHelper;
use App\Helpers\ModelHelper;
use App\Models\CustomFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Auth;
use PdfReport;
use ExcelReport;

class ReportController extends Component
{
    // Data
    public $base_data = [
        'data' => [],
        'columns' => ['number', 'date', 'sub_total', 'customer.last_name', 'branch.name'],
        'operations' => [],
        'totals' => [],
        'number' => [], 'sub_total' => [], 'customer_id' => [],
        'custom_filters' => [],
        'user' => null,
    ];

    public $filters = [
        'number' => '', 'sub_total' => '', 'customer_id' => '',
    ];

    // Methods
    public function render()
    {
        return view('livewire.Reports');
    }

    public function mount()
    {
        $model = new Order();
        $this->base_data['number'] = $model::select('number')->distinct('number')->orderBy('number')->get()->toArray();
        $this->base_data['sub_total'] = $model::select('sub_total')->distinct('sub_total')->orderBy('sub_total')->get()->toArray();
        $this->base_data['customer_id'] = \App\Models\User::orderBy('last_name')->get()->toArray();
        $this->base_data['user'] = Auth::user();
        $this->base_data['custom_filters'] = CustomFilter::where('setting_id', 3)->orderBy('name')->get()->toArray();
        $this->generateData();
    }

    public function filter_data()
    {
        $this->generateData();
    }

    private function generateData()
    {
        $model = new Order();
        $order_by = 'date';
        $order_type = 'desc';
        $group_by = '';
        $data = $model->select(DB::raw('number, date, sub_total, customer_id, branch_id'));
        $data = $data->with('customer');
        $data->with('branch');

        if (!empty($this->filters['number'])) {
            $data = $data->where('number', $this->filters['number']);
        }
        if (!empty($this->filters['sub_total'])) {
            $data = $data->where('sub_total', $this->filters['sub_total']);
        }
        if (!empty($this->filters['customer_id'])) {
            $data = $data->where('customer_id', $this->filters['customer_id']);
        }

        if (isset($order_by) and !empty($order_by))
            $data = $data->orderBy($order_by, $order_type);

        if (isset($group_by) and !empty($group_by))
            $data = $data->groupBy($group_by);

        $data = $data->get()->toArray();

        $this->base_data['data'] = $data;
    }

    public function get_custom_filter_data($key)
    {
        $model = new Order();
        $order_by = 'date';
        $order_type = 'desc';
        $group_by = '';
        $value = $this->base_data['custom_filters'][$key]['value'];
        $where = @unserialize($value) ? unserialize($value)['where'] : [];
        $data = $model->select(DB::raw('number, date, sub_total, customer_id, branch_id'));
        $data = $data->with('customer');
        $data->with('branch');

        foreach ($where as $key => $wh) {
            if ($wh['type'] == 1) {
                if (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp', 'integer', 'float', 'double'])) {
                    if ($wh['operation'] == 'between') {
                        if (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp'])) {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $data = $data->orWhereDateBetween($wh['column']['value'], [$wh['value'], $wh['value_2']]);
                            } else {
                                $data = $data->whereDateBetween($wh['column']['value'], [$wh['value'], $wh['value_2']]);
                            }
                        } else {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $data = $data->orWhereBetween($wh['column']['value'], [$wh['value'], $wh['value_2']]);
                            } else {
                                $data = $data->whereBetween($wh['column']['value'], [$wh['value'], $wh['value_2']]);
                            }
                        }
                    } else {
                        if (in_array($wh['column']['type'], ['date', 'datetime', 'timestamp'])) {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $data = $data->orWhereDate($wh['column']['value'], $wh['operation'], $wh['value']);
                            } else {
                                $data = $data->whereDate($wh['column']['value'], $wh['operation'], $wh['value']);
                            }
                        } else {
                            if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                                $data = $data->orWhere($wh['column']['value'], $wh['operation'], $wh['value']);
                            } else {
                                $data = $data->where($wh['column']['value'], $wh['operation'], $wh['value']);
                            }
                        }
                    }
                } else {
                    if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                        $data = $data->orWhere($wh['column']['value'], $wh['operation'], $wh['value']);
                    } else {
                        $data = $data->where($wh['column']['value'], $wh['operation'], $wh['value']);
                    }
                }
            } else {
                $joins = ModelHelper::getRelationName($wh['joins']['join_table'], 'many');

                if ($wh['operation'] == 'between') {
                    if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                        $data->orWhereHas($joins, function ($query) use ($wh) {
                            $query->havingRaw($wh['data_type'] . '(' . $wh['joins']['value'] . ') >= ' . $wh['value'] . ' and ' . $wh['data_type'] . '(' . $wh['joins']['value'] . ') <= ' . $wh['value_2']);
                        });
                    } else {
                        $data->whereHas($joins, function ($query) use ($wh) {
                            $query->havingRaw($wh['data_type'] . '(' . $wh['joins']['value'] . ') >= ' . $wh['value'] . ' and ' . $wh['data_type'] . '(' . $wh['joins']['value'] . ') <= ' . $wh['value_2']);
                        });
                    }
                } else {
                    if ($key - 1 > -1 and $where[$key - 1]['where_type'] == 'or') {
                        $data->orWhereHas($joins, function ($query) use ($wh) {
                            $query->havingRaw($wh['data_type'] . '(' . $wh['joins']['value'] . ') ' . $wh['operation'] . ' ' . $wh['value']);
                        });
                    } else {
                        $data->whereHas($joins, function ($query) use ($wh) {
                            $query->havingRaw($wh['data_type'] . '(' . $wh['joins']['value'] . ') ' . $wh['operation'] . ' ' . $wh['value']);
                        });
                    }
                }
            }
        }

        if (isset($order_by) and !empty($order_by))
            $data = $data->orderBy($order_by, $order_type);

        if (isset($group_by) and !empty($group_by))
            $data = $data->groupBy($group_by);

        $data = $data->get()->toArray();

        $this->base_data['data'] = $data;
    }

    public function pdf()
    {
        $order_by = 'date';
        $order_type = 'desc';
        $group_by = '';
        $columns_array = ['number', 'date', 'sub_total', 'customer.last_name', 'branch.name'];
        $totals = [];
        $meta = [ // For displaying filters description on header
            'Registered on' => '11/08/2022',
        ];

        $model = new Order();
        $queryBuilder = $model::select($columns_array);

        $queryBuilder = $queryBuilder->with('customer');
        $queryBuilder->with('branch');

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
        $order_by = 'date';
        $order_type = 'desc';
        $group_by = '';
        $columns_array = ['number', 'date', 'sub_total', 'customer.last_name', 'branch.name'];
        $meta = [
            'Registered on' => '11/08/2022',
        ];

        $model = new Order();
        $queryBuilder = $model::select($columns_array);

        $queryBuilder = $queryBuilder->with('customer');
        $queryBuilder->with('branch');

        if (isset($order_by) and !empty($order_by))
            $queryBuilder = $queryBuilder->orderBy($order_by, $order_type);

        if (isset($group_by) and !empty($group_by))
            $queryBuilder = $queryBuilder->groupBy($group_by);

        return ExcelReport::of('Orders Report', $meta, $queryBuilder, $columns_array)
            ->simple()
            ->download('Orders Report');
    }
}
