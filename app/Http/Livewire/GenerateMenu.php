<?php

namespace App\Http\Livewire;

use App\Models\Menu;
use App\Models\Permission;
use App\Traits\AppTrait;
use DataTables;
use Livewire\Component;

class GenerateMenu extends Component
{
    use AppTrait;

    protected $listeners = [
        "checkRow",
        "editData",
        "validateData",
        "printData",
        "deleteData",
        "alertResult",
    ];

    public $rules = [
        'values.category' => 'required',
        'values.name' => 'required',
    ];

    public $base_data = [
        'categories' => [
            [
                'id' => 'simple',
                'name' => 'Simple',
            ],
            [
                'id' => 'separator',
                'name' => 'Separator',
            ],
            [
                'id' => 'dropdown',
                'name' => 'Dropdown',
            ],
            [
                'id' => 'sub_element',
                'name' => 'Sub element',
            ],
        ],
        'orders' => [],
        'sources' => [],
        'permissions' => [],
        'columns' => ['name', 'category', 'created_at', 'actions'],
        'data' => [],
    ];

    public $values = [
        'category' => '',
        'name' => '',
        'icon' => '',
        'path' => '',
        'source' => '',
        'item_order' => '',
        'permission_id' => '',
        'sub_elements' => [],
    ];

    public $options = [];

    public $save_data = [
        "category" => "dropdown",
        "name" => "Modules",
        "icon" => "home",
        "path" => "",
        "source" => "",
        "item_order" => "2",
        "permission_id" => "3",
        "sub_elements" => [
            [
                "id" => "",
                "name" => "Orders",
                "icon" => "list",
                "path" => "/orders",
                "item_order" => "1",
                "permission_id" => "1",
            ],
        ],
    ];

    public function render()
    {
        return view('livewire.generate-menu');
    }

    public function mount()
    {
        $this->base_data['permissions'] = Permission::all();
        $this->getSupportData();
        // $this->values = $this->save_data;
    }

    public function save()
    {
        $this->req(function () {
            // $this->validate();

            if ($this->appOptions['id'] == null)
                Menu::_save($this->values);
            else
                Menu::_save($this->values, $this->appOptions['id']);

            $this->getSupportData();
            $this->cancel();
            $this->showSlideAlert('success', 'Menu added with success');
        });
    }

    public function editData($id)
    {
        $this->req(function () use ($id) {
            $menu = Menu::_get($id)->toArray();

            foreach ($menu as $key => $value) {
                if (isset($this->values[$key]))
                    $this->values[$key] = $value;
            }

            if ($menu['category'] == 'dropdown')
                $this->getMenuSubs($menu['subs']);
            else if ($menu['category'] == 'sub_element')
                $this->base_data['orders'] = Menu::getOrders($menu['source']);


            $this->appOptions['id'] = $id;
            $this->changeVisibility(true);
        });
    }

    public function deleteData($id)
    {
        $this->req(function () use ($id) {
            $this->appOptions['id'] = $id;
            $this->showAlert('question', 'Are you sure?', 'delete');
        });
    }

    public function alertResult($result)
    {
        $this->req(function () use ($result) {
            if ($this->appOptions['alert']['target'] == 'delete') {
                if ($result['result']) {
                    $this->req(function () {
                        $result = Menu::_delete($this->appOptions['id']);
                        $this->showSlideAlert('success', 'Menu deleted with success');
                        $this->getSupportData();
                    });
                }
            }

            $this->hideAlert();
        });
    }

    public function newMenu()
    {
        $this->req(function () {
            $this->changeVisibility(true);
        });
    }

    public function cancel()
    {
        $this->req(function () {
            foreach ($this->values as $key => $value) {
                if (!in_array($key, ['sub_elements']))
                    $this->values[$key] = '';
            }

            $this->values['sub_elements'] = [];
            $this->appOptions['id'] = null;
            $this->getSupportData();
            $this->changeVisibility(false);
        });
    }

    public function addSubMenu()
    {
        $this->req(function () {
            array_push($this->values['sub_elements'], [
                'id' => '',
                'name' => '',
                'icon' => '',
                'path' => '',
                'item_order' => '',
                'permission_id' => '',
            ]);

            $this->newRules();
            // $this->rules();
        });
    }

    public function removeSubMenu($elementKey)
    {
        $this->req(function () use ($elementKey) {
            $arrayHelper = [];

            foreach ($this->values['sub_elements'] as $key => $element) {
                if ($key != $elementKey) {
                    array_push($arrayHelper, $element);
                }
            }

            $this->values['sub_elements'] = $arrayHelper;
            $this->newRules();
            // $this->rules();
        });
    }

    public function checkElementOrder($elementKey)
    {
        $order = $this->values['sub_elements'][$elementKey]['item_order'];

        foreach ($this->values['sub_elements'] as $key => $element) {
            if ($key != $elementKey && $element['item_order'] == $order) {
                $this->values['sub_elements'][$key]['item_order'] = '';
                break;
            }
        }
    }

    public function changeOrder($data)
    {
        $this->req(function () use ($data) {
            dd($data);
        });
    }

    // public function rules()
    // {
    //     $arrayHelper = [
    //         'values.category' => 'required',
    //         'values.name' => 'required',
    //     ];

    //     foreach ($this->values['sub_elements'] as $key => $element) {
    //         $arrayHelper['values.sub_elements.' . $key . '.name'] = 'required';
    //     }

    //     return $arrayHelper;
    // }

    private function newRules()
    {
        $arrayHelper = [
            'values.category' => 'required',
            'values.name' => 'required',
        ];

        foreach ($this->values['sub_elements'] as $key => $element) {
            $arrayHelper['values.sub_elements.' . $key . '.name'] = 'required';
        }

        $this->rules = $arrayHelper;
    }

    private function getSupportData()
    {
        $this->base_data['orders'] = Menu::getOrders();
        $this->base_data['sources'] = Menu::getSources();
        $this->getData();
    }

    private function getData()
    {
        $data = Menu::_get()->toArray();
        $this->base_data['data'] = $data;
    }

    private function getMenuSubs($subs)
    {
        $this->values['sub_elements'] = ($subs == null ? [] : $subs);
    }
}
