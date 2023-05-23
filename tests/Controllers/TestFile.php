<?php

namespace Modules\AccountsCharts\Http\Livewire;

use Livewire\Component;
use Modules\AccountsCharts\Entities\AccountsChart;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Form;
use App\Models\DropDown;
use App\Models\AppModule;
use Throwable;
use App\Helpers\DateHelper;
use App\Helpers\LogHelper;
use App\Helpers\StringHelper;
use App\Helpers\ModelHelper;
use App\Models\CustomFilter;
use App\Models\User;




// Listing namespaces - start
// use Modules\CollectifAccounts\Entities\AccountsChart;
// Listing namespaces - end




use DataTables;


use App\Traits\AppTrait;
use App\Traits\GeneralTrait;

class AccountsCharts extends Component
{


    use AppTrait;
    use GeneralTrait;

    protected $listeners = [

        // Listing listeners - start
        "checkRow",
        "editData",
        "validateData",
        "printData",
        "deleteData",
        // Listing listeners - end

        "alertResult",
    ];

    public $base_data = [

        // Listing base_data - start
        "title" => "accounts_chart",
        "module_name" => "accountscharts",
        "data" => [],
        "types" => ['title', 'account', 'type_id', 'collectif_accounts.title', 'drop_downs.select_value', 'actions'],
        "columns" => ['title', 'account', 'type_id', 'collectif_accounts.title', 'drop_downs.select_value', 'actions'],
        "operations" => [],
        "totals" => [],
        'title' => [], 'account' => [], 'type_id' => [], 'collectif_account_id' => [], 'classification_id' => [],
        "custom_filters" => [],
        // Listing base_data - end

        "buttons" => [
            "add" => " AccountsChart",
        ],
        "permissions" => [],
        "app_module" => [],
        "permissions" => [],
        "user" => null,
        "type_id_options" => [],
        "collectif_account_id_options" => [],
        "classification_id_options" => [],
        "is_default_options" => [],

        "module_pseudo_name" => "accountscharts",
        "route" => [
            "url" => "",
            "basename" => "",
        ],
    ];

    public $time = null;
    public $filters = [

        // Listing filters - start
        'title' => '', 'account' => '', 'type_id' => '', 'collectif_account_id' => '', 'classification_id' => '',
        // Listing filters - end

    ];
    public $form = [
        "title" => "",
        "account" => "",
        "type_id" => "",
        "collectif_account_id" => "",
        "classification_id" => "",
        "is_default" => "",

    ];
    public $filterLoops = [

        // Listing filterLoops - start
        [
            "id" => "title",
            "label" => "title",
            "model" => "filters.title",
            "data" => "title",
            "value" => "title",
            "text" => "title",
        ], [
            "id" => "account",
            "label" => "account",
            "model" => "filters.account",
            "data" => "account",
            "value" => "account",
            "text" => "account",
        ], [
            "id" => "type_id",
            "label" => "type_id",
            "model" => "filters.type_id",
            "data" => "type_id",
            "value" => "id",
            "text" => "select_value",
        ], [
            "id" => "collectif_account_id",
            "label" => "collectif_account_id",
            "model" => "filters.collectif_account_id",
            "data" => "collectif_account_id",
            "value" => "id",
            "text" => "title",
        ], [
            "id" => "classification_id",
            "label" => "classification_id",
            "model" => "filters.classification_id",
            "data" => "classification_id",
            "value" => "id",
            "text" => "select_value",
        ],
        // Listing filterLoops - end

    ];
    public $formElements = [];
    public $showCards = false;

    public $options = [

        // Listing options - start
        'show_filters' => false, 'selected_filter' => -1,
        'show_modal' => false,
        'show_form' => false,
        'show_content' => false,
        'id' => null,
        'module_id' => 11,
        // Listing options - end

        "helper" => "AccountsChartsHelper",
        "title_content" => "",
        "currentElement" => [],
        "status_content" => "",
        "status_color_content" => "",
        "modal" => [
            "show" => false,
            "current" => "",
            "title" => "",
        ],
        "element-length" => 12,
        "module_name" => "AccountsCharts",

    ];

    public function render()
    {
        return view("accountscharts::livewire.manage");
    }

    public function mount()
    {
        $this->base_data["route"]["url"] = url()->current();
        $this->base_data["route"]["basename"] = basename($this->base_data["route"]["url"]);
        $this->base_data["permissions"] = $this->getPermissions();
        if (!$this->base_data["permissions"]["view"] and !$this->base_data["permissions"]["view_own"]) {
            abort(403);
        }

        // Listing mount - start
        $this->base_data['title'] = \Modules\AccountsCharts\Entities\AccountsChart::select('title')->distinct('title')->orderBy('title')->get()->toArray();
        $this->base_data['account'] = \Modules\AccountsCharts\Entities\AccountsChart::select('account')->distinct('account')->orderBy('account')->get()->toArray();
        $this->base_data['type_id'] = \App\Models\DropDown::where("select_field", "type_id")->orderBy('select_value')->get()->toArray();
        $this->base_data['collectif_account_id'] = \Modules\CollectifAccounts\Entities\CollectifAccount::orderBy('title')->get()->toArray();
        $this->base_data['classification_id'] = \App\Models\DropDown::where("select_field", "classification_id")->orderBy('select_value')->get()->toArray();
        $this->base_data['custom_filters'] = CustomFilter::where('setting_id', 1)->orderBy('name')->get()->toArray();
        // Listing mount - end

        $this->base_data["type_id_options"] = \App\Models\DropDown::select("id", "select_value as text")->where("select_field", "type_id")->get()->toArray();
        $this->base_data["collectif_account_id_options"] = \Modules\CollectifAccounts\Entities\CollectifAccount::select("id", "title as text")->get()->toArray();
        $this->base_data["classification_id_options"] = \App\Models\DropDown::select("id", "select_value as text")->where("select_field", "classification_id")->get()->toArray();

        $this->base_data["is_default_options"] = DropDown::select("select_id as id", "select_value as text")->where("select_field", "is_default")->where("app_module_id", $this->options["module_id"])->where("select_field", "is_default")->get()->toArray();

        $this->base_data['user'] = Auth::user();
        $this->base_data["app_module"] = AppModule::where("id", $this->options["module_id"])->first()->toArray();
    }








    // Listing methods - start
    public function generateData()
    {
        if (isset($this->options['selected_filter'])) {
            $this->options['selected_filter'] = -1;
        }

        $filters = $_POST["d_filters"] ?? [];
        $permissions = $this->getPermissions();
        $model = new AccountsChart();
        $order_by = '';
        $order_type = 'asc';
        $group_by = '';
        $data = $model->select("*");
        $data = $data->with('collectif_accounts');
        $data->with('drop_downs');



        if (!empty($filters['title'])) {
            $data = $data->where('title', $filters['title']);
        }
        if (!empty($filters['account'])) {
            $data = $data->where('account', $filters['account']);
        }
        if (!empty($filters['type_id'])) {
            $data = $data->where('type_id', $filters['type_id']);
        }
        if (!empty($filters['collectif_account_id'])) {
            $data = $data->where('collectif_account_id', $filters['collectif_account_id']);
        }
        if (!empty($filters['classification_id'])) {
            $data = $data->where('classification_id', $filters['classification_id']);
        }

        $data = $data->with("created_by");

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


        $data = $data->addColumn('actions', function ($row) use ($permissions) {
            $btn = "";

            if ($permissions["update"]) {
                $btn .= '<button type="button" class="btn btn-secondary btn-shadow btn-icon btn-sm me-1" onclick="liveCall(\'editData\', ' . $row["id"] . ')" wire:click="editDataP(' . $row["id"] . ')">
                            <i class="la la-pencil p-0"></i>
                        </button>';
            }

            if ($permissions["delete"]) {
                $btn .= '<button type="button" class="btn btn-danger btn-shadow btn-icon btn-sm" onclick="liveCall(\'deleteData\', ' . $row["id"] . ')" wire:click="deleteDataP(' . $row["id"] . ')">
                            <i class="la la-trash p-0"></i>
                        </button>';
            }
            return $btn;
        });

        $data = $data->rawColumns(["checkbox", "barcode", "reference", "created_by", "flagged", "actions"])->make(true);
        return $data;
    }

    /* public function get_custom_filter_data($key)
                {
                    $this->req(function () use ($key) {
                        if (isset($this->options['selected_filter'])) {
                            $this->options['selected_filter'] = $key;
                        }

                        $permissions = $this->getPermissions();
                        $model = new AccountsChart();
                        $order_by = 'date';
                        $order_type = 'desc';
                        $group_by = '';
                        $value = $this->base_data['custom_filters'][$key]['value'];
                        $where = @unserialize($value) ? unserialize($value)['where'] : [];
                        $data = $model->select("*");
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


                    $data = $data->addColumn('actions', function($row) use ($permissions) {
                        $btn = "";

                    if ($permissions["update"]) {
                        $btn .= '<button type="button" class="btn btn-secondary btn-shadow btn-icon btn-sm me-1" onclick="liveCall(\'editData\', ' . $row["id"] . ')" wire:click="editDataP(' . $row["id"] . ')">
                            <i class="la la-pencil p-0"></i>
                        </button>';
                    }

                    if ($permissions["delete"]) {
                        $btn .= '<button type="button" class="btn btn-danger btn-shadow btn-icon btn-sm" onclick="liveCall(\'deleteData\', ' . $row["id"] . ')" wire:click="deleteDataP(' . $row["id"] . ')">
                            <i class="la la-trash p-0"></i>
                        </button>';
                    }
                    return $btn;
                });

                        $data = $data->rawColumns(["checkbox", "barcode", "reference", "created_by", "flagged", "actions"])->make(true);
                        return $data;
                    });
                } */

    /* public function pdf()
                {
                    $order_by = '';
                    $order_type = 'asc';
                    $group_by = '';
                    $columns_array = ['actions'];
                    $totals = [];
                    $meta = [ // For displaying filters description on header
                        'Registered on' => '11/08/2022',
                    ];

                    $model = new AccountsChart();
                    $queryBuilder = $model::select($columns_array);

                    $queryBuilder = $queryBuilder->with('collectif_accounts');$queryBuilder->with('drop_downs');

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
                } */

    /* public function excel(Request $request)
                {
                    $order_by = '';
                    $order_type = 'asc';
                    $group_by = '';
                    $columns_array = ['actions'];
                    $meta = [
                        'Registered on' => '11/08/2022',
                    ];

                    $model = new AccountsChart();
                    $queryBuilder = $model::select($columns_array);

                    $queryBuilder = $queryBuilder->with('collectif_accounts');$queryBuilder->with('drop_downs');

                    if (isset($order_by) and !empty($order_by))
                        $queryBuilder = $queryBuilder->orderBy($order_by, $order_type);

                    if (isset($group_by) and !empty($group_by))
                        $queryBuilder = $queryBuilder->groupBy($group_by);

                    return ExcelReport::of('Orders Report', $meta, $queryBuilder, $columns_array)
                        ->simple()
                        ->download('Orders Report');
                } */


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


    public function change_select_filters_title($value)
    {
        $filters["title"] = $value;
    }
    public function change_select_filters_account($value)
    {
        $filters["account"] = $value;
    }
    public function change_select_filters_type_id($value)
    {
        $filters["type_id"] = $value;
    }
    public function change_select_filters_collectif_account_id($value)
    {
        $filters["collectif_account_id"] = $value;
    }
    public function change_select_filters_classification_id($value)
    {
        $filters["classification_id"] = $value;
    }
    // Listing methods - end








    public function save()
    {
        $this->req(function () {
            // Try & catch
            DB::beginTransaction();
            // $validated = $form->validated();
            $data["title"] = $this->form["title"];
            $data["account"] = $this->form["account"];
            $data["type_id"] = $this->form["type_id"];
            $data["collectif_account_id"] = $this->form["collectif_account_id"];
            $data["classification_id"] = $this->form["classification_id"];
            $data["is_default"] = $this->form["is_default"];

            if ($this->options["id"] == "") {
                if (!$this->base_data["permissions"]["create"]) {
                    $this->showAlert("error", "Permission Denied");
                    abort(403);
                }
                try {
                    // Validate the value...



                    $data["user_id"] = Auth::id();
                    $data["created_at"] = Carbon::now()->toDateTimeString();

                    AccountsChart::insert($data);
                    $insert_id = DB::getPdo()->lastInsertId();
                    if (isset($insert_id)) {


                        DB::commit();
                        $this->cancel();
                        LogHelper::setLog("created", AccountsChart::find($insert_id));
                        $this->showSlideAlert("success", "AccountsChart added successfully");
                        $this->reloadTable($this->base_data['module_name']);
                    } else {
                        $this->showAlert("error", "Problem encountred");
                        DB::rollback();
                        return false;
                    }
                } catch (Throwable $e) {
                    $this->showAlert("error", $e->getMessage());
                    report($e);
                    DB::rollback();
                    return false;
                }
            } elseif (is_int($this->options["id"])) {
                // update
                if (!$this->base_data["permissions"]["update"]) {
                    $this->showAlert("error", "Permission Denied");
                    abort(403);
                }
                try {
                    // Validate the value...
                    AccountsChart::where("id", $this->options["id"])->update($data);
                    LogHelper::setLog("updated", AccountsChart::find($this->options["id"]));
                    DB::commit();
                    $this->cancel();
                    $this->showSlideAlert("success", "AccountsChart updated successfully");
                    $this->reloadTable($this->base_data['module_name']);
                } catch (Throwable $e) {
                    $this->showAlert("error", $e->getMessage());
                    report($e);
                    DB::rollback();
                    return false;
                }
            } else {
                abort(404);
            }
        });
    }

    public function editData($id)
    {
        $this->req(function () use ($id) {
            if (!$this->base_data["permissions"]["update"]) {
                abort(403);
            }

            $is_on_update = ModelHelper::setModuleUpdate($this->base_data["module_pseudo_name"], $id, true, function ($user) {
                $this->showAlert("warning", $user->first_name . " " . $user->last_name . " " . __("is updating this!"));
            });

            if (!$is_on_update) return;

            $accountschart = AccountsChart::findOrFail($id);
            $this->form["title"] = $accountschart->title;
            $this->form["account"] = $accountschart->account;
            $this->form["type_id"] = $accountschart->type_id;
            $this->form["collectif_account_id"] = $accountschart->collectif_account_id;
            $this->form["classification_id"] = $accountschart->classification_id;
            $this->form["is_default"] = $accountschart->is_default;

            $this->options["id"] = $id;
            $this->action_options("show_modal");
        });
    }

    public function deleteData($id)
    {
        $this->req(function () use ($id) {
            if (!$this->base_data["permissions"]["delete"]) {
                $this->showAlert("error", "Permission Denied");
                abort(403);
            }

            $this->options["id"] = $id;
            $this->showAlert("question", "Are you sure?", "delete");
        });
    }

    public function validateData($id)
    {
        $this->req(function () use ($id) {
            dd("validate");
        });
    }

    public function printData($id)
    {
        $this->req(function () use ($id) {
            dd("validate");
        });
    }


    public function cancel()
    {
        $this->req(function () {
            if ($this->options["id"] != null) {
                ModelHelper::setModuleUpdate($this->base_data["module_pseudo_name"], $this->options["id"], false);
            }

            foreach ($this->form as $key => $value) {
                $type = gettype($value);
                if ($type == "string") {
                    $this->form[$key] = "";
                } else if (in_array($type, ["integer", "float", "double"])) {
                    $this->form[$key] = 0;
                } else if ($type == "array") {
                    $this->form[$key] = [];
                } else {
                    $this->form[$key] = null;
                }
            }

            $this->action_options("show_modal");
        });
    }
    // NOTE - Option methods
    // public function action_options($name)
    // {
    //     $this->req(function () use ($name) {
    //         $this->options[$name] = !$this->options[$name];
    //     });
    // }

    private function setData()
    {
        $form = Form::where("module_id", 11)->first();
        $this->formElements = unserialize($form->value);
        $this->base_data["columns"] = [];
        $this->base_data["data"] = [];
    }

    private function getPermissions()
    {
        $user_id = Auth::id();

        return [
            "view" => has_permission(module_permission_name($this->options["module_name"], "view"), $user_id),
            "view_own" => has_permission(module_permission_name($this->options["module_name"], "view_own"), $user_id),
            "create" => has_permission(module_permission_name($this->options["module_name"], "create"), $user_id),
            "update" => has_permission(module_permission_name($this->options["module_name"], "update"), $user_id),
            "delete" => has_permission(module_permission_name($this->options["module_name"], "delete"), $user_id),
            "view_comments" => has_permission(module_permission_name($this->options["module_name"], "view_comments"), $user_id),
            "create_comments" => has_permission(module_permission_name($this->options["module_name"], "create_comments"), $user_id),
            "view_reminders" => has_permission(module_permission_name($this->options["module_name"], "view_reminders"), $user_id),
            "create_reminders" => has_permission(module_permission_name($this->options["module_name"], "create_reminders"), $user_id),
            "view_file_upload" => has_permission(module_permission_name($this->options["module_name"], "view_file_upload"), $user_id),
            "create_file_upload" => has_permission(module_permission_name($this->options["module_name"], "create_file_upload"), $user_id),
        ];
    }

    // NOTE - Alert functions
    public function alertResult($result)
    {
        $this->req(function () use ($result) {
            if ($result) {
                if ($this->appOptions["alert"]["target"] == "delete") {
                    LogHelper::setLog("deleted", AccountsChart::find($this->options["id"]));
                    AccountsChart::where("id", $this->options["id"])->delete();
                    $this->showSlideAlert("success", "AccountsChart deleted successfully");
                    $this->reloadTable($this->base_data['module_name']);
                }
            }

            $this->options["id"] = null;
            $this->hideAlert();
        });
    }
    // NOTE - End alert functions
}
