<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;
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
use App\Models\Area;
use App\Models\City;
use App\Models\CompanyDepartement;
use App\Models\CompanySite;
use App\Models\Country;
use App\Models\CustomFilter;
use App\Models\Upload;
use App\Models\User;

// Listing namespaces - start
// use Modules\Companys\Entities\Company;
// Listing namespaces - end

use DataTables;
use App\Traits\AppTrait;
use App\Traits\GeneralTrait;
use Livewire\WithFileUploads;

class CompanyLivewire extends Component
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
        "title" => "companies",
        "module_name" => "companies",
        "data" => [],
        "types" => ['created_by_name', 'name', 'drop_downs.select_value', 'capital', 'vat', 'common_identifier', 'commercial_register', 'social_security'],
        "columns" => ['created_by_name', 'name', 'drop_downs.select_value', 'capital', 'vat', 'common_identifier', 'commercial_register', 'social_security', 'actions'],
        "operations" => [],
        "totals" => [],
        'name' => [], 'capital' => [],
        "custom_filters" => [],
        // Listing base_data - end

        "buttons" => [
            "add" => " Company",
        ],
        "permissions" => [],
        "app_module" => [],
        "permissions" => [],
        "user" => null,
        'countries' => [],
        'cities' => [],
        'areas' => [],
        'activity' => [],
        'site_types' => [],
        'companies' => [],
        'sites' => [],
        'departements' => [],

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
        "module_pseudo_name" => "companies",
        "route" => [
            "url" => "",
            "basename" => "",
        ],
        'datatables' => [
            'company_sites' => [
                'name' => 'company_sites',
                'columns' => ['name', 'number_of_floors', 'email', 'post_code', 'type', 'actions'],
            ],
            'company_departements' => [
                'name' => 'company_departements',
                'columns' => ['name', 'floors', 'site_name', 'actions'],
            ],
        ]
    ];

    public $time = null;
    public $filters = [

        // Listing filters - start
        'name' => '', 'capital' => '',
        // Listing filters - end

    ];
    public $form = [
        'name' => '',
        'capital' => 0,
        'vat' => '',
        'common_identifier' => '',
        'commercial_register' => '',
        'social_security' => '',
        'company_parent' => '',
        'activity' => '',
        'active' => true,

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
        'sites' => [
            'name' => '',
            'number_of_floors' => '',
            'address' => '',
            'post_code' => '',
            'phone_number' => '',
            'email' => '',
            'country_id' => '',
            'city_id' => '',
            'area_id' => '',
            'type' => '',
            'basic_address' => false,
            'shipping_address' => false,
            'pos_address' => false,
            'active' => true,
            'company_id' => '',
        ],
        'departements' => [
            'name' => '',
            'description' => '',
            'floors' => '',
            'company_site_id' => '',
            'active' => true,
            'reception_user_id' => '',
            'responsible_user_id' => '',
            'departement_parent' => '',
        ]
    ];
    public $filterLoops = [

        // Listing filterLoops - start
        [
            "id" => "name",
            "label" => "name",
            "model" => "filters.name",
            "data" => "name",
            "value" => "name",
            "text" => "name",
        ], [
            "id" => "capital",
            "label" => "capital",
            "model" => "filters.capital",
            "data" => "capital",
            "value" => "capital",
            "text" => "capital",
        ],
        // Listing filterLoops - end

    ];
    public $menuElements = [
        [
            'name' => 'General',
        ],
        [
            'name' => 'Sites',
        ],
        [
            'name' => 'Departements',
        ],
    ];
    public $formElements = [];
    public $showCards = true;

    public $options = [

        // Listing options - start
        'show_filters' => false, 'selected_filter' => -1,
        'show_modal' => false,
        'show_form' => false,
        'show_content' => false,
        'site_id' => null,
        'departement_id' => null,
        'module_id' => 14,
        // Listing options - end

        "helper" => "CompanysHelper",
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
        "module_name" => "Companys",

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
        "currentMenuElement" => 0,
        'show_forms' => [
            'company_sites' => false,
            'company_departements' => false,
        ],
    ];

    public function render()
    {
        return view("livewire.companies.company-livewire");
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
        // $this->base_data['name'] = \Modules\Companys\Entities\Company::select('name')->distinct('name')->orderBy('name')->get()->toArray();
        // $this->base_data['capital'] = \Modules\Companys\Entities\Company::select('capital')->distinct('capital')->orderBy('capital')->get()->toArray();
        $this->base_data['custom_filters'] = CustomFilter::where('setting_id', 1)->orderBy('name')->get()->toArray();
        // Listing mount - end

        $this->base_data["active_options"] = DropDown::select("select_id as id", "select_value as text")->where("select_field", "active")->where("app_module_id", $this->options["module_id"])->where("select_field", "active")->get()->toArray();
        $this->base_data["activity_id_options"] = DropDown::select("select_id as id", "select_value as text")->where("select_field", "activity_id")->where("app_module_id", $this->options["module_id"])->where("select_field", "activity_id")->get()->toArray();
        $module_class = new Company;
        $this->appOptions["subject"] = [
            "id" => null,
            "type" => get_class($module_class),
            "name" => class_basename($module_class),
        ];
        $this->base_data['user'] = Auth::user();
        $this->base_data['users'] = User::_get();
        $this->base_data['countries'] = Country::_get();
        $this->base_data['site_types'] = CompanySite::getTypes();
        $this->base_data['activities'] = Company::getActivities();
        // $this->base_data["app_module"] = AppModule::where("id", $this->options["module_id"])->first()->toArray();
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
        $model = new Company();
        $order_by = '';
        $order_type = 'asc';
        $group_by = '';
        $data = $model->select("*");
        $data = $data->with('drop_downs');



        if (!empty($filters['name'])) {
            $data = $data->where('name', $filters['name']);
        }
        if (!empty($filters['capital'])) {
            $data = $data->where('capital', $filters['capital']);
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

        $data = $data->addColumn('actions', function ($row) {
            $btn = '<p class="text-end mb-0">';

            $btn .= '<button type="button" class="btn btn-secondary btn-shadow btn-icon btn-sm me-1" onclick="liveCall(\'editData\', ' . $row["id"] . ')" wire:click="editDataP(' . $row["id"] . ')">
                <i class="la la-pencil p-0"></i>
            </button>';

            $btn .= '<button type="button" class="btn btn-danger btn-shadow btn-icon btn-sm" onclick="liveCall(\'deleteData\', ' . $row["id"] . ')" wire:click="deleteDataP(' . $row["id"] . ')">
                <i class="la la-trash p-0"></i>
            </button>';

            return $btn;
        });

        $data = $data->addColumn('created_by_name', function ($row) {
            return $row["created_by"] == null ? "-" : $row["created_by"]["first_name"] . " " . $row["created_by"]["last_name"];
        });


        $data = $data->rawColumns(["checkbox", "barcode", "reference", "created_by", "flagged", "actions"])->make(true);
        return $data;
    }

    public function generateSitesData()
    {
        $model = new CompanySite();
        $order_by = '';
        $order_type = 'asc';
        $group_by = '';

        if (!isset($_POST['params']['company_id']) || empty($_POST['params']['company_id'])) {
            $data = $model->where('id', 0);
        } else {
            $data = $model->where('company_id', $_POST['params']['company_id']);
        }
        // return [
        //     'draw' => 1,
        //     'recordsTotal' => 0,
        //     'recordsFiltered' => 0,
        //     'data' => [],
        //     'queries' => [],
        //     'input' => [],
        // ];

        // if (isset($this->options['selected_filter'])) {
        //     $this->options['selected_filter'] = -1;
        // }

        // $filters = $_POST["d_filters"] ?? [];
        // $permissions = $this->getPermissions();

        // $data = $data->with('drop_downs', 'created_by');

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

        $data = $data->addColumn('actions', function ($row) {
            $btn = '<p class="text-end mb-0">';

            $btn .= '<button type="button" class="btn btn-secondary btn-shadow btn-icon btn-sm me-1" onclick="liveCall(\'editSiteData\', ' . $row["id"] . ')" wire:click="editSiteDataP(' . $row["id"] . ')">
                <i class="la la-pencil p-0"></i>
            </button>';

            $btn .= '<button type="button" class="btn btn-danger btn-shadow btn-icon btn-sm" onclick="liveCall(\'deleteSiteData\', ' . $row["id"] . ')" wire:click="deleteSiteDataP(' . $row["id"] . ')">
                <i class="la la-trash p-0"></i>
            </button>';

            return $btn;
        });

        $data = $data->rawColumns(["checkbox", "barcode", "reference", "created_by", "flagged", "actions"])->make(true);
        return $data;
    }

    public function generateDepartementsData()
    {
        $model = new CompanyDepartement();
        $order_by = '';
        $order_type = 'asc';
        $group_by = '';

        if (!isset($_POST['params']['company_id']) || empty($_POST['params']['company_id'])) {
            $data = $model->where('id', 0);
        } else {
            $data = $model->whereHas('site', function ($query) {
                return $query->where('company_id', $_POST['params']['company_id']);
            });
        }
        // return [
        //     'draw' => 1,
        //     'recordsTotal' => 0,
        //     'recordsFiltered' => 0,
        //     'data' => [],
        //     'queries' => [],
        //     'input' => [],
        // ];

        // if (isset($this->options['selected_filter'])) {
        //     $this->options['selected_filter'] = -1;
        // }

        // $filters = $_POST["d_filters"] ?? [];
        // $permissions = $this->getPermissions();

        $data = $data->with('site', 'created_by');

        // if (!empty($filters['name'])) {
        //     $data = $data->where('name', $filters['name']);
        // }
        // if (!empty($filters['capital'])) {
        //     $data = $data->where('capital', $filters['capital']);
        // }

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

        $data = $data->addColumn('actions', function ($row) {
            $btn = '<p class="text-end mb-0">';

            $btn .= '<button type="button" class="btn btn-secondary btn-shadow btn-icon btn-sm me-1" onclick="liveCall(\'editDepartementData\', ' . $row["id"] . ')" wire:click="editDepartementDataP(' . $row["id"] . ')">
                <i class="la la-pencil p-0"></i>
            </button>';

            $btn .= '<button type="button" class="btn btn-danger btn-shadow btn-icon btn-sm" onclick="liveCall(\'deleteDepartementData\', ' . $row["id"] . ')" wire:click="deleteDepartementDataP(' . $row["id"] . ')">
                <i class="la la-trash p-0"></i>
            </button>';

            return $btn;
        });

        $data = $data->addColumn('site_name', function ($row) {
            return $row['site']['name'] ?? '';
        });

        $data = $data->rawColumns(["checkbox", "barcode", "reference", "created_by", "flagged", "actions"])->make(true);
        return $data;
    }

    public function action_options($name, $force = false)
    {
        $this->req(function () use ($name, $force) {
            $this->options[$name] = !$this->options[$name];

            if ($name == 'show_form' && $this->options[$name] == true && $force) {
                $this->getCompanies();
            }
        });
    }

    public function change_select_filters_name($value)
    {
        $filters["name"] = $value;
    }
    public function change_select_filters_capital($value)
    {
        $filters["capital"] = $value;
    }
    // Listing methods - end

    public function save()
    {
        $this->req(function () {
            // Try & catch
            DB::beginTransaction();
            // $validated = $form->validated();
            $data["name"] = $this->form["name"];
            $data["capital"] = $this->form["capital"];
            $data["vat"] = $this->form["vat"];
            $data["common_identifier"] = $this->form["common_identifier"];
            $data["commercial_register"] = $this->form["commercial_register"];
            $data["social_security"] = $this->form["social_security"];
            $data["active"] = $this->form["active"];
            $data["activity"] = $this->form["activity"] ?? null;

            if ($this->appOptions["id"] == "") {
                if (!$this->base_data["permissions"]["create"]) {
                    $this->showAlert("error", "Permission Denied");
                    abort(403);
                }
                try {
                    // Validate the value...



                    $data["user_id"] = Auth::id();
                    $data["created_at"] = Carbon::now()->toDateTimeString();

                    Company::insert($data);
                    $insert_id = DB::getPdo()->lastInsertId();
                    if (isset($insert_id)) {


                        DB::commit();
                        $this->cancel();
                        LogHelper::setLog("created", Company::find($insert_id));
                        $this->showSlideAlert("success", "Company added successfully");
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
            } elseif (is_int($this->appOptions["id"])) {
                // update
                if (!$this->base_data["permissions"]["update"]) {
                    $this->showAlert("error", "Permission Denied");
                    abort(403);
                }
                try {
                    // Validate the value...
                    Company::where("id", $this->appOptions["id"])->update($data);
                    LogHelper::setLog("updated", Company::find($this->appOptions["id"]));
                    DB::commit();
                    $this->cancel();
                    $this->showSlideAlert("success", "Company updated successfully");
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

    public function saveSite()
    {
        $this->req(function () {
            $data = $this->form['sites'];

            if ($this->options['site_id'] == null) {
                $data['company_id'] = $this->appOptions["id"];
                $site = CompanySite::_save($data);
            } else {
                $site = CompanySite::_save($data, $this->options['site_id']);
            }

            $this->form['sites'] = $this->_clear($this->form['sites'], ['active' => true]);
            $this->base_data['sites'] = CompanySite::get_site_of_company($this->appOptions["id"])->toArray();
            $this->action_show_form('company_sites', false);
            $this->reloadTable($this->base_data['datatables']['company_sites']['name'], ['company_id' => $this->appOptions["id"]]);
        });
    }

    public function saveDepartement()
    {
        $this->req(function () {
            $data = $this->form['departements'];

            if ($this->options['departement_id'] == null) {
                $departement = CompanyDepartement::_save($data);
            } else {
                $departement = CompanyDepartement::_save($data, $this->options['departement_id']);
            }

            $this->form['departements'] = $this->_clear($this->form['departements'], ['active' => true]);
            $this->action_show_form('company_departements', false);
            $this->reloadTable($this->base_data['datatables']['company_departements']['name'], ['company_id' => $this->appOptions["id"]]);
        });
    }

    public function editData($id)
    {
        $this->req(function () use ($id) {
            if (!$this->base_data["permissions"]["update"]) {
                abort(403);
            }

            // $is_on_update = ModelHelper::setModuleUpdate($this->base_data["module_pseudo_name"], $id, true, function ($user) {
            //     $this->showAlert("warning", $user->first_name . " " . $user->last_name . " " . __("is updating this!"));
            // });

            // if (!$is_on_update) return;

            $companie = Company::findOrFail($id);
            $this->form["name"] = $companie->name;
            $this->form["capital"] = $companie->capital;
            $this->form["vat"] = $companie->vat;
            $this->form["common_identifier"] = $companie->common_identifier;
            $this->form["commercial_register"] = $companie->commercial_register;
            $this->form["social_security"] = $companie->social_security;
            $this->form["active"] = $companie->active;
            $this->form["activity"] = $companie->activity;

            $this->appOptions["id"] = $id;
            $this->getCompanies();
            $this->base_data['sites'] = CompanySite::get_site_of_company($id)->toArray();
            $this->reloadTable($this->base_data['datatables']['company_sites']['name'], ['company_id' => $this->appOptions["id"]]);
            $this->reloadTable($this->base_data['datatables']['company_departements']['name'], ['company_id' => $this->appOptions["id"]]);
            $this->action_options("show_form");
        });
    }

    public function editSiteData($id)
    {
        $this->req(function () use ($id) {
            $site = CompanySite::_get($id)->toArray();
            foreach ($site as $key => $value) {
                if (isset($this->form['sites'][$key])) {
                    $this->form['sites'][$key] = $value;
                }
            }

            $this->options["site_id"] = $id;
            $this->getCities();
            $this->getAreas();
            $this->action_show_form("company_sites");
        });
    }

    public function editDepartementData($id)
    {
        $this->req(function () use ($id) {
            $site = CompanyDepartement::_get($id)->toArray();
            foreach ($site as $key => $value) {
                if (isset($this->form['departements'][$key])) {
                    $this->form['departements'][$key] = $value;
                }
            }

            $this->options["departement_id"] = $id;
            $this->base_data['departements'] = CompanyDepartement::getByCompany($this->appOptions["id"], $id)->toArray();
            $this->action_show_form("company_departements");
        });
    }

    public function show_row($id)
    {
        $this->req(function () use ($id) {
            $this->appOptions["id"] = $id;
            $this->appOptions["subject"]["id"] = $id;
            $this->options["currentElement"] = Company::where("id", $id)->with("comments", "reminders")->first()->toArray();

            $this->options["title_content"] = $this->options["currentElement"]["reference"] ?? "Company";

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

            $this->appOptions["id"] = $id;
            $this->showAlert("question", "Are you sure?", "delete");
        });
    }

    public function deleteSiteData($id)
    {
        $this->req(function () use ($id) {
            if (!$this->base_data["permissions"]["delete"]) {
                $this->showAlert("error", "Permission Denied");
                abort(403);
            }

            $this->options["site_id"] = $id;
            $this->showAlert("question", "Are you sure?", "delete_site");
        });
    }

    public function deleteDepartementData($id)
    {
        $this->req(function () use ($id) {
            if (!$this->base_data["permissions"]["delete"]) {
                $this->showAlert("error", "Permission Denied");
                abort(403);
            }

            $this->options["departement_id"] = $id;
            $this->showAlert("question", "Are you sure?", "delete_departement");
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

    public function getCities()
    {
        $this->base_data['cities'] = City::getByCountry($this->form['sites']['country_id'])->toArray();
    }

    public function getAreas()
    {
        $this->base_data['areas'] = Area::getByCity($this->form['sites']['city_id'])->toArray();
    }

    public function getCompanies($empty = false)
    {
        if ($empty)
            $this->base_data['companies'] = [];
        else
            $this->base_data['companies'] = ($this->appOptions['id'] == null ? Company::getCompanies()->toArray() : Company::getCompanies($this->appOptions['id'])->toArray());
    }

    public function cancel()
    {
        $this->req(function () {
            // if ($this->appOptions["id"] != null) {
            // ModelHelper::setModuleUpdate($this->base_data["module_pseudo_name"], $this->appOptions["id"], false);
            // }

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
            $this->form['sites'] = $this->_clear($this->form['sites'], ['active' => true]);
            $this->form['departements'] = $this->_clear($this->form['departements'], ['active' => true]);
            $this->base_data['cities'] = [];
            $this->base_data['areas'] = [];
            $this->getCompanies(true);
            $this->action_show_form('company_sites', false);
            $this->action_show_form('company_departements', false);
            $this->reloadTable($this->base_data['datatables']['company_sites']['name']);
            $this->reloadTable($this->base_data['datatables']['company_departements']['name']);
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

    public function action_menu($key)
    {
        $this->req(function () use ($key) {
            $this->options['currentMenuElement'] = $key;
        });
    }

    public function action_show_form($key, $bool = true, $force = false)
    {
        $this->req(function () use ($key, $bool, $force) {
            $this->options['show_forms'][$key] = $bool;

            if ($bool == true && $key == 'company_departements' && $force == true) {
                $this->base_data['departements'] = CompanyDepartement::getByCompany($this->appOptions["id"])->toArray();
            }
        });
    }

    private function setData()
    {
        $form = Form::where("module_id", 14)->first();
        $this->formElements = unserialize($form->value);
        $this->base_data["columns"] = [];
        $this->base_data["data"] = [];
    }

    private function getPermissions()
    {
        $user_id = Auth::id();

        return [
            "view" => true,
            "view_own" => true,
            "create" => true,
            "update" => true,
            "delete" => true,
            "view_comments" => true,
            "create_comments" => true,
            "view_reminders" => true,
            "create_reminders" => true,
            "view_file_upload" => true,
            "create_file_upload" => true,
        ];
    }

    // NOTE - Alert functions
    public function alertResult($result)
    {
        $this->req(function () use ($result) {
            if ($result) {
                if ($this->appOptions["alert"]["target"] == "delete") {
                    LogHelper::setLog("deleted", Company::find($this->appOptions["id"]));
                    Company::where("id", $this->appOptions["id"])->delete();
                    $this->showSlideAlert("success", "Company deleted successfully");
                    $this->reloadTable($this->base_data["module_name"]);
                } else if ($this->appOptions['alert']['target'] == 'delete_site') {
                    LogHelper::setLog("deleted", CompanySite::find($this->options["site_id"]));
                    CompanySite::_delete($this->options["site_id"]);
                    $this->showSlideAlert("success", "Site deleted successfully");
                    $this->reloadTable($this->base_data['datatables']['company_sites']['name'], ['company_id' => $this->appOptions["id"]]);
                } else if ($this->appOptions['alert']['target'] == 'delete_departement') {
                    LogHelper::setLog("deleted", CompanyDepartement::find($this->options["departement_id"]));
                    CompanyDepartement::_delete($this->options["departement_id"]);
                    $this->showSlideAlert("success", "Departement deleted successfully");
                    $this->reloadTable($this->base_data['datatables']['company_departements']['name'], ['company_id' => $this->appOptions["id"]]);
                }
            } else {
                if ($this->appOptions["alert"]["target"] == "delete") {
                    $this->appOptions["id"] = null;
                } else if ($this->appOptions['alert']['target'] == 'delete_site') {
                    $this->options["site_id"] = null;
                } else if ($this->appOptions['alert']['target'] == 'delete_departement') {
                    $this->options["departement_id"] = null;
                }
            }
        }, [
            "hide_alert" => true,
        ]);
    }
    // NOTE - End alert functions
}
