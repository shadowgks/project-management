<?php

namespace Modules\GeneralInformations\Http\Livewire;

use Livewire\Component;
use Modules\GeneralInformations\Entities\GeneralInformation;
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
use App\Models\Comment;
use App\Models\CustomFilter;
use App\Models\Upload;
use App\Models\User;

// Listing namespaces - start
// use Modules\GeneralInformations\Entities\GeneralInformation;
// Listing namespaces - end

use DataTables;


use App\Traits\AppTrait;
use App\Traits\GeneralTrait;
use Livewire\WithFileUploads;

class GeneralInformations extends Component
{


    use AppTrait;
    use GeneralTrait;
    use WithFileUploads;

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
        "title" => "general_informations",
        "module_name" => "generalinformations",
        "data" => [],
        "types" => ['name', 'start_date', 'finish_date', 'actions'],
        "columns" => ['name', 'start_date', 'finish_date', 'actions'],
        "operations" => [],
        "totals" => [],

        "custom_filters" => [],
        // Listing base_data - end

        "buttons" => [
            "add" => " GeneralInformation",
        ],
        "permissions" => [],
        "app_module" => [],
        "permissions" => [],
        "user" => null,

        "content" => [
            "reminder" => [
                "columns" => ["From", "To", "Description", "Date Added", "Date of reminder", "By email", "options"],
                "columns_keys" => ["from", "to", "description", "date_added", "date_of_reminder", "by_email", "options"],
                "data" => [],
            ],
            "files" => [
                "columns" => ["Name", "Size", "Visibility", "Uploaded At", "options"],
                "columns_keys" => ["name", "size", "visibility", "uploaded_at", "options"],
                "data" => [],
            ],
        ],
        "users" => [],
        "module_pseudo_name" => "generalinformations",
        "route" => [
            "url" => "",
            "basename" => "",
        ],
    ];

    public $time = null;
    public $filters = [

        // Listing filters - start

        // Listing filters - end

    ];
    public $form = [
        // Form values - start
        "name" => "",
        "type" => "",
        "start_date" => "",
        "finish_date" => "",
        "description" => "",
        // Form values - end

        "reminders" => [
            "date" => "",
            "by_email" => false,
            "user" => "",
            "value" => "",
        ],
        "upload_file" => [
            "files" => [],
        ],
        "comments" => [
            "value" => "",
            "rows" => [],
        ],
    ];
    public $filterLoops = [

        // Listing filterLoops - start

        // Listing filterLoops - end

    ];
    public $menuElements = [
        // [
        //     'name' => 'form',
        // ]
    ];
    public $formElements = [];
    public $showCards = true;

    public $options = [

        // Listing options - start
        'show_filters' => false, 'selected_filter' => -1,
        'show_modal' => false,
        'show_form' => false,
        'show_content' => false,
        'id' => null,
        'module_id' => 11,
        // Listing options - end

        "helper" => "GeneralInformationsHelper",
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
        "module_name" => "GeneralInformations",

        "modal" => [
            "show" => false,
            "current" => "",
            "title" => "",
        ],
        "currentElement" => [],
        "show_form" => false,
        "show_content" => false,
        "show_dropdown" => false,
        "title_content" => "",
        "status_content" => "",
        "status_color_content" => "",

    ];

    public function render()
    {
        return view("generalinformations::livewire.manage");
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

        $this->base_data['custom_filters'] = CustomFilter::where('setting_id', 1)->orderBy('name')->get()->toArray();
        // Listing mount - end

        // Form mount - start

        $this->base_data["type_options"] = DropDown::select("select_id as id", "select_value as text")->where("select_field", "type")->where("app_module_id", $this->options["module_id"])->where("select_field", "type")->get()->toArray();
        // Form mount - end


        $module_class = new GeneralInformation;
        $this->appOptions["subject"] = [
            "id" => null,
            "type" => get_class($module_class),
            "name" => class_basename($module_class),
        ];
        $this->base_data['user'] = Auth::user();
        $this->base_data["app_module"] = AppModule::where("id", $this->options["module_id"])->first()->toArray();
        $this->appOptions["app_module_id"] = $this->options["module_id"];
        $this->appValues["upload_file"]["files"] = Upload::_get_by_module($this->options["module_id"])->toArray();
    }


    // Listing methods - start
    public function generateData()
    {
        if (isset($this->options['selected_filter'])) {
            $this->options['selected_filter'] = -1;
        }

        $filters = $_POST["d_filters"] ?? [];
        $permissions = $this->getPermissions();
        $model = new GeneralInformation();
        $order_by = 'name';
        $order_type = 'asc';
        $group_by = '';
        $data = $model->select("*");






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
            $btn = "<p class=\"text-end mb-0\">";

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
            $btn .= "</p>";
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
                        $model = new GeneralInformation();
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
                        $btn = "<p class=\"text-end mb-0\">";

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
                    $btn .= "</p>";
                return $btn;
                });

                        $data = $data->rawColumns(["checkbox", "barcode", "reference", "created_by", "flagged", "actions"])->make(true);
                        return $data;
                    });
                } */

    /* public function pdf()
                {
                    $order_by = 'name';
                    $order_type = 'asc';
                    $group_by = '';
                    $columns_array = ['name', 'start_date', 'finish_date', 'actions'];
                    $totals = [];
                    $meta = [ // For displaying filters description on header
                        'Registered on' => '11/08/2022',
                    ];

                    $model = new GeneralInformation();
                    $queryBuilder = $model::select($columns_array);



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
                    $order_by = 'name';
                    $order_type = 'asc';
                    $group_by = '';
                    $columns_array = ['name', 'start_date', 'finish_date', 'actions'];
                    $meta = [
                        'Registered on' => '11/08/2022',
                    ];

                    $model = new GeneralInformation();
                    $queryBuilder = $model::select($columns_array);



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
        $this->req(function () use ($name) {
            $this->options[$name] = !$this->options[$name];
        });
    }



    // Listing methods - end


    public function save()
    {
        $this->req(function () {
            // Try & catch
            DB::beginTransaction();
            // $validated = $form->validated();
            // Form save values - start
            $data["name"] = $this->form["name"];
            $data["type"] = $this->form["type"];
            $data["start_date"] = $this->form["start_date"];
            $data["finish_date"] = $this->form["finish_date"];
            $data["description"] = $this->form["description"];
            // Form save values - end

            if ($this->options["id"] == "") {
                if (!$this->base_data["permissions"]["create"]) {
                    $this->showAlert("error", "Permission Denied");
                    abort(403);
                }
                try {
                    // Validate the value...



                    $data["user_id"] = Auth::id();
                    $data["created_at"] = Carbon::now()->toDateTimeString();

                    GeneralInformation::insert($data);
                    $insert_id = DB::getPdo()->lastInsertId();
                    if (isset($insert_id)) {


                        DB::commit();
                        $this->cancel();
                        LogHelper::setLog("created", GeneralInformation::find($insert_id));
                        $this->showSlideAlert("success", "GeneralInformation added successfully");
                        $this->reloadTable($this->base_data["module_name"]);
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
                    GeneralInformation::where("id", $this->options["id"])->update($data);
                    LogHelper::setLog("updated", GeneralInformation::find($this->options["id"]));
                    DB::commit();
                    $this->cancel();
                    $this->showSlideAlert("success", "GeneralInformation updated successfully");
                    $this->reloadTable($this->base_data["module_name"]);
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

            $generalinformation = GeneralInformation::findOrFail($id);
            // Form edit values - start
            $this->form["name"] = $generalinformation->name;
            $this->form["type"] = $generalinformation->type;
            $this->form["start_date"] = $generalinformation->start_date;
            $this->form["finish_date"] = $generalinformation->finish_date;
            $this->form["description"] = $generalinformation->description;
            // Form edit values - end

            $this->options["id"] = $id;
            $this->action_options("show_form");
        });
    }
    public function show_row($id)
    {
        $this->req(function () use ($id) {
            $this->options["id"] = $id;
            $this->appOptions["id"] = $id;
            $this->appOptions["subject"]["id"] = $id;
            $this->options["currentElement"] = GeneralInformation::where("id", $id)->with("comments", "reminders")->first()->toArray();
            $this->appValues["comments"]["rows"] = Comment::_get_by_module($this->options["module_id"], $id);

            $this->options["title_content"] = $this->options["currentElement"]["reference"] ?? "GeneralInformation";

            if (isset($this->options["currentElement"]["status_id"])) {
                $this->options["status"] =  true;
                $this->options["status_content"] = $this->options["currentElement"]["status"]["name"] ?? "";
                $this->options["status_color_content"] = $this->options["currentElement"]["status"]["color"] ?? "";
            } else $this->options["status"] =  false;

            $this->action_options("show_content");
        });
    }
    public function _edit()
    {
        $this->req(function () {
            foreach ($this->options["currentElement"] as $key => $value) {
                if (isset($this->form[$key]))
                    $this->form[$key] = $value;
            }
            $this->action_options("show_form");
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

    public function save_option()
    {
        $this->req(function () {
            if ($this->options["modal"]["current"] == "comments") {
                $this->saveComment();
            } else if ($this->options["modal"]["current"] == "reminders") {
                $this->saveReminder();
            }
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
                    if (str_contains($key, "_id"))
                        $this->form[$key] = "";
                    else
                        $this->form[$key] = 0;
                } else if ($type == "array") {
                    $this->form[$key] = [];
                } else {
                    $this->form[$key] = null;
                }
            }

            $this->appOptions["id"] = null;
            $this->appOptions["subject"]["id"] = null;
            $this->dispatchBrowserEvent("reloadSelect");
            $this->action_options("show_form");
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
                    LogHelper::setLog("deleted", GeneralInformation::find($this->options["id"]));
                    GeneralInformation::where("id", $this->options["id"])->delete();
                    $this->showSlideAlert("success", "GeneralInformation deleted successfully");
                    $this->reloadTable($this->base_data["module_name"]);
                }
            }

            $this->options["id"] = null;
        }, [
            "hide_alert" => true,
        ]);
    }
    // NOTE - End alert functions
}
