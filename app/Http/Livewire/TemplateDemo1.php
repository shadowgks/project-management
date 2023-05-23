<?php

namespace App\Http\Livewire;

use App\Traits\AppTrait;
use Livewire\Component;

class TemplateDemo1 extends Component
{
    use AppTrait;

    protected $listeners = [
        'alertResult',
    ];

    public $base_data = [
        'title' => 'Template Demo 1',
        'module_name' => 'example',
        'data' => [],
        'columns' => [],
        'totals' => [],
        'custom_filters' => [],
        'permissions' => [
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
    ];

    public $filters = [];
    public $form = [];
    public $filterLoops = [];
    public $formElements = [];
    public $showCards = true;

    public $options = [
        'id' => null,
        'show_modal' => false,
        'show_filters' => false,
        'helper' => '',
        'module_name' => 'Template demo : modal',
        'element-length' => 12,
    ];

    public function render()
    {
        return view('livewire.template-demo1');
    }

    public function mount()
    {
        $currentURL = url()->current();
        $basename = basename($currentURL);

        if ($basename == 'demo1' || $basename == 'module') {
            $this->setExample();
        }
    }

    // NOTE - Principal methods
    public function save()
    {
        $this->req(function () {
            $this->action_options('show_modal');
            $this->showSlideAlert('success', 'Data saved successfully!');
        });
    }

    public function cancel()
    {
        $this->req(function () {
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

            $this->action_options('show_modal');
        });
    }

    public function alertResult($result)
    {
        $this->req(function () use ($result) {
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

    public function generateData()
    {
        $dt = [
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832122',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
        ];

        return json_encode([
            'draw' => 4,
            'recordsTotal' => count($dt),
            'recordsFiltered' => 0,
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
        $this->base_data['columns'] = ['code', 'name', 'total', 'date'];
        $this->base_data['data'] = [
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832122',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
                'name' => 'Name 4',
                'total' => 300,
                'date' => '2022-11-10',
            ],
            [
                'id' => 1,
                'code' => 'NB832140',
                'name' => 'Name 1',
                'total' => 100,
                'date' => '2022-12-12',
            ],
            [
                'id' => 2,
                'code' => 'NB832139',
                'name' => 'Name 2',
                'total' => 120,
                'date' => '2022-12-17',
            ],
            [
                'id' => 3,
                'code' => 'NB832138',
                'name' => 'Name 3',
                'total' => 80,
                'date' => '2022-11-15',
            ],
            [
                'id' => 4,
                'code' => 'NB832137',
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
