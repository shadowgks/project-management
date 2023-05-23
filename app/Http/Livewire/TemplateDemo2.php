<?php

namespace App\Http\Livewire;

use App\Traits\AppTrait;
use Livewire\Component;

class TemplateDemo2 extends Component
{
    use AppTrait;

    protected $listeners = [
        'show_row',
        'alertResult',
    ];

    public $base_data = [
        'title' => 'Template Demo 1',
        'module_name' => 'example_2',
        'data' => [],
        'columns' => [],
        'totals' => [],
        'custom_filters' => [],
        'permissions' => [
            'view' => true,
            'view_own' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'view_comments' => true,
            'create_comments' => true,
            'view_reminders' => true,
            'create_reminders' => true,
            'view_file_upload' => true,
            'create_file_upload' => true,
        ],
        'app_module' => [
            'activate_reminders' => true,
            'activate_duplicate' => true,
            'activate_file_upload' => true,
            'emailing' => true,
            'pdf' => true,
            'activate_comments' => true,
        ],
        'content' => [
            'reminder' => [
                'columns' => ['From', 'To', 'Description', 'Date Added', 'Date of reminder', 'By email', 'options'],
                'columns_keys' => ['from', 'to', 'description', 'date_added', 'date_of_reminder', 'by_email', 'options'],
                'data' => [],
            ],
            'files' => [
                'columns' => ['Name', 'Size', 'Visibility', 'Uploaded At', 'options'],
                'columns_keys' => ['name', 'size', 'visibility', 'uploaded_at', 'options'],
                'data' => [],
            ],
        ],
        'users' => [],
    ];

    public $form = [
        'reminders' => [
            'date' => '',
            'by_email' => false,
            'user' => '',
            'value' => '',
        ],
        'upload_file' => [
            'file' => null,
        ],
        'comments' => [
            'value' => '',
        ],
    ];

    public $filters = [];
    public $filterLoops = [];
    public $formElements = [];
    public $showCards = true;

    public $options = [
        'id' => null,
        'module_name' => 'Template demo : form',
        'currentElement' => [],
        'show_form' => false,
        'show_content' => false,
        'show_filters' => false,
        'show_dropdown' => false,
        'helper' => '',
        'title_content' => 'Preview',
        'status_content' => 'Success',
        'status_color_content' => 'light-success',
        'element-length' => 12,
    ];

    public function render()
    {
        return view('livewire.template-demo2');
    }

    public function mount()
    {
        $currentURL = url()->current();
        $basename = basename($currentURL);

        if ($basename == 'demo2' || $basename == 'module') {
            $this->setExample();
        }
    }

    // NOTE - Principal methods
    public function save()
    {
        $this->req(function () {
            $this->showSlideAlert('success', 'Data saved successfully!');
        });
    }

    public function _validate()
    {
        $this->req(function () {
            //
        });
    }

    public function _show()
    {
        $this->req(function () {
            //
        });
    }

    public function _edit()
    {
        $this->req(function () {
            foreach ($this->options['currentElement'] as $key => $value) {
                if (isset($this->form[$key])) {
                    $this->form[$key] = $value;
                }
            }

            $this->action_options('show_form');
        });
    }

    public function cancel($name)
    {
        $this->req(function () use ($name) {
            if ($name == 'show_form') {
                foreach ($this->form as $key => $value) {
                    $type = gettype($value);

                    if ($type == 'string') {
                        $this->form[$key] = '';
                    } else if (in_array($type, ['integer', 'float', 'double'])) {
                        $this->form[$key] = 0;
                    } else if ($type == 'array') {
                        $this->form[$key] = [];
                    } else {
                        $this->form[$key] = null;
                    }
                }
            } else if ($name == 'show_content') {
                $this->options['id'] = null;
                $this->options['currentElement'] = [];
            }

            $this->form['reminders']['date'] = '';
            $this->form['reminders']['by_email'] = false;
            $this->form['reminders']['user'] = '';
            $this->form['reminders']['value'] = '';
            $this->form['upload_file']['file'] = null;
            $this->form['comments']['value'] = '';

            $this->action_options($name);
        });
    }

    public function alertResult($result)
    {
        $this->req(function () use ($result) {
            // dd($result);
            $this->hideAlert();
        });
    }

    // NOTE - Option methods
    public function action_options($name)
    {
        $this->req(function () use ($name) {
            $this->options[$name] = !$this->options[$name];
        });
    }

    public function action_modal()
    {
        $this->req(function () {
            $this->options['modal']['show'] = !$this->options['modal']['show'];
        });
    }

    // NOTE - Emits
    public function show_row($id)
    {
        $this->req(function () use ($id) {
            $this->options['id'] = $id;

            array_walk($this->base_data['data'], function ($row) use ($id) {
                if ($row['id'] == $id) {
                    $this->options['currentElement'] = $row;
                }
            });

            $this->action_options('show_content');
        });
    }

    public function generateData()
    {
        $dt = [
            [
                'id' => 1,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832140<a>',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832139<a>',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832138<a>',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832137<a>',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832140<a>',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832139<a>',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832138<a>',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832137<a>',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832140<a>',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832139<a>',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832122<a>',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832137<a>',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832140<a>',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832139<a>',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832138<a>',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832137<a>',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832140<a>',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832139<a>',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832138<a>',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832137<a>',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832140<a>',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832139<a>',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832138<a>',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832137<a>',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832140<a>',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832139<a>',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832138<a>',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832137<a>',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832140<a>',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832139<a>',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832138<a>',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832137<a>',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832140<a>',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832139<a>',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832138<a>',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832137<a>',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832140<a>',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832139<a>',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832138<a>',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'reference' => '<a class="text-gray-800 fw-bold text-hover-primary fs-6 cursor-pointer" onclick="liveCall(\'show_row\', 1)" wire:click="show_row(1)">NB832137<a>',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
        ];

        $count_dt = count($dt);
        return json_encode([
            'draw' => 4,
            'recordsTotal' => $count_dt,
            'recordsFiltered' => $count_dt,
            'data' => $dt,
        ]);
    }

    public function get_join_files()
    {
        $dt = [
            [
                'id' => 1,
                'full_name' => 'api-values.xml',
                'file_size' => 836,
                'visibility' => '
                    <label
                        class="form-check form-switch form-check-custom form-check-solid mb-3">
                        <input class="form-check-input" type="checkbox">
                        <span class="form-check-label fw-semibold text-muted"></span>
                    </label>
                ',
                'created_at' => "13/03/2023",
                'actions' => '
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-secondary btn-sm btn-shadow btn-icon me-1">
                            <i class="fa fa-download p-0"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-shadow btn-icon">
                            <i class="fa fa-trash p-0"></i>
                        </button>
                    </div>
                '
            ],
            [
                'id' => 2,
                'full_name' => 'view-values.html',
                'file_size' => 1323,
                'visibility' => '
                    <label
                        class="form-check form-switch form-check-custom form-check-solid mb-3">
                        <input class="form-check-input" type="checkbox" checked>
                        <span class="form-check-label fw-semibold text-muted"></span>
                    </label>
                ',
                'created_at' => "13/03/2023",
                'actions' => '
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-secondary btn-sm btn-shadow btn-icon me-1">
                            <i class="fa fa-download p-0"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-shadow btn-icon">
                            <i class="fa fa-trash p-0"></i>
                        </button>
                    </div>
                '
            ],
        ];

        $count_dt = count($dt);
        return json_encode([
            'draw' => 2,
            'recordsTotal' => $count_dt,
            'recordsFiltered' => $count_dt,
            'data' => $dt,
        ]);
    }

    public function get_reminders()
    {
        $dt = [
            [
                'id' => 1,
                'from' => '
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                            <a
                                href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html">
                                <div class="symbol-label">
                                    <img src="https://preview.keenthemes.com/metronic8/demo6/assets/media/avatars/300-1.jpg"
                                        alt="Emma Smith" class="w-100">
                                </div>
                            </a>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html"
                                class="text-gray-800 text-hover-primary mb-1">John Doe</a>
                        </div>
                    </div>
                ',
                'to' => '
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                            <a
                                href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html">
                                <div class="symbol-label">
                                    <img src="https://preview.keenthemes.com/metronic8/demo6/assets/media/avatars/300-6.jpg"
                                        alt="Emma Smith" class="w-100">
                                </div>
                            </a>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="https://preview.keenthemes.com/metronic8/demo6/../demo6/apps/user-management/users/view.html"
                                class="text-gray-800 text-hover-primary mb-1">Emma Smith</a>
                        </div>
                    </div>
                ',
                'description' => 'Something spécial',
                'date_reminde' => "13/03/2023",
                'by_mail' => '
                    <label
                        class="form-check form-switch form-check-custom form-check-solid mb-3">
                        <input class="form-check-input" type="checkbox" checked>
                        <span class="form-check-label fw-semibold text-muted"></span>
                    </label>
                ',
                'actions' => '
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-secondary btn-sm btn-shadow btn-icon me-1">
                            <i class="fa fa-pencil p-0"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-shadow btn-icon">
                            <i class="fa fa-trash p-0"></i>
                        </button>
                    </div>
                '
            ],
        ];

        $count_dt = count($dt);
        return json_encode([
            'draw' => 2,
            'recordsTotal' => $count_dt,
            'recordsFiltered' => $count_dt,
            'data' => $dt,
        ]);
    }

    // NOTE - Example methods
    private function setExample()
    {
        $this->formElements = [
            [
                "menu" => 0,
                "table" => 2,
                "column" => "name",
                "label" => "Name",
                "type" => "text",
                "value" => [
                    "type" => "data",
                    "table" => "",
                    "column" => "",
                    "custom" => [],
                ],
                "default" => "",
                "placeholder" => "Something",
                "length" => 10,
                "min" => 0,
                "max" => 0,
            ],
            [
                "menu" => 0,
                "table" => 2,
                "column" => "total",
                "label" => "Total",
                "type" => "number",
                "value" => [
                    "type" => "data",
                    "table" => "",
                    "column" => "",
                    "custom" => [],
                ],
                "default" => "",
                "placeholder" => "",
                "length" => 0,
                "min" => 0,
                "max" => 0,
            ],
            [
                "menu" => 1,
                "table" => 2,
                "column" => "date",
                "label" => "Date",
                "type" => "date",
                "value" => [
                    "type" => "data",
                    "table" => "",
                    "column" => "",
                    "custom" => [],
                ],
                "default" => "",
                "placeholder" => "",
                "length" => 0,
                "min" => 0,
                "max" => 0,
            ],
        ];
        $this->base_data['columns'] = ['reference', 'name', 'total', 'date'];
        $this->base_data['data'] = [
            [
                'id' => 1,
                'reference' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'reference' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'reference' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'reference' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
        ];
        $this->form = [
            'name' => '',
            'total' => 0,
            'date' => '',
        ];
    }
}
