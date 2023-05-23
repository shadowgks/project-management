<?php

namespace App\Http\Livewire;

use App\Helpers\BarcodeHelper;
use App\Helpers\ModelHelper;
use App\Helpers\NumberingHelper;
use App\Models\ProjectSetting;
use App\Traits\AppTrait;
use App\Traits\Module\NumberingBarcodeTrait;
use DB;
use Livewire\Component;
use DataTables;

class ModuleBarcode extends Component
{
    use AppTrait;
    use NumberingBarcodeTrait;

    public $base_data = [
        'tables' => [],
        'columns' => [],
        'element_types' => [],
        'barcode_types' => [],
        'settings' => [],
        'datatable' => [
            'name' => 'barcode',
            'columns' => ['name', 'date', 'actions'],
            'data' => [],
            'route' => 'barcode.list',
        ],
    ];

    public $values = [
        'barcode' => [
            'choose_column' => true,
            'table' => '',
            'column' => '',
            'type' => '',
            'use_numbering' => '',
            'custom_number' => false,
            'number_initiator' => 1,
            'random' => '',
            'every-day' => false,
            'every-week' => false,
            'every-month' => false,
            'every-year' => false,
            'use_today_date' => false,
            'number_length' => 0,
            'date_field' => '',
            'form' => [
                'barcode_type' => '',
                'name' => '',
                'type' => 'standard',
                'text' => '',
                'value' => '',
            ],
            'elements' => [
                [
                    'name' => 'Barcode',
                    'type' => 'static',
                ],
            ],
        ],
        'id' => '',
        'name' => '',
    ];

    public $options = [
        'element_id' => '',
    ];

    public function render()
    {
        return view('livewire.outside.module-barcode');
    }

    public function mount()
    {
        $this->base_data['tables'] = ModelHelper::getTables();
        $this->base_data['element_types'] = NumberingHelper::getElementTypes();
        $this->base_data['barcode_types'] = BarcodeHelper::getBarcodeTypes();
    }

    public function getColumnOfTable()
    {
        $table = $this->values['barcode']['table'];
        $this->base_data['columns'] = ModelHelper::getColumnsOfTable($table);
    }

    public function addElement($variable, $withData = true)
    {
        if ($withData) {
            $data = $this->values[$variable]['form'];

            array_push($this->values[$variable]['elements'], [
                'name' => ($data['name'] ?? ''),
                'type' => ($data['type'] ?? ''),
                'text' => ($data['text'] ?? ''),
                'value' => ($data['value'] ?? ''),
            ]);

            $this->clearElementForm($variable);
        } else {
            array_push($this->values[$variable]['elements'], [
                'name' => '',
                'type' => '',
                'text' => '',
                'value' => '',
            ]);
        }

        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function editElement($variable, $elementKey)
    {
        $this->options['element_id'] = $elementKey;

        foreach ($this->values[$variable]['elements'][$elementKey] as $key => $value) {
            $this->values[$variable]['form'][$key] = $value;
        }

        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function saveElement($variable)
    {
        $elementKey = $this->options['element_id'];

        foreach ($this->values[$variable]['form'] as $key => $value) {
            $this->values[$variable]['elements'][$elementKey][$key] = $value;
        }

        $this->clearElementForm($variable);
        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function removeElement($variable, $elementKey)
    {
        $arrayHelper = [];

        foreach ($this->values[$variable]['elements'] as $key => $relation) {
            if ($key != $elementKey) {
                array_push($arrayHelper, $relation);
            }
        }

        $this->values[$variable]['elements'] = $arrayHelper;
        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function changeOrderOfElement($request)
    {
        $arrayHelper = [];

        foreach ($request['elements'] as $key) {
            array_push($arrayHelper, $this->values[$request['variable']]['elements'][$key]);
        }

        $this->values[$request['variable']]['elements'] = $arrayHelper;
        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function clearElementForm($variable)
    {
        foreach ($this->values[$variable]['form'] as $key => $value) {
            if (!in_array($key, ['type'])) $this->values[$variable]['form'][$key] = '';
        }

        $this->values[$variable]['form']['type'] = 'standard';
        $this->options['element_id'] = '';
    }

    public function clear()
    {
        $this->base_data['columns'] = [];

        $this->values = [
            'barcode' => [
                'choose_column' => true,
                'table' => '',
                'column' => '',
                'type' => '',
                'use_numbering' => '',
                'custom_number' => false,
                'number_initiator' => 1,
                'random' => '',
                'every-day' => false,
                'every-week' => false,
                'every-month' => false,
                'every-year' => false,
                'use_today_date' => false,
                'number_length' => 0,
                'date_field' => '',
                'form' => [
                    'barcode_type' => '',
                    'name' => '',
                    'type' => 'standard',
                    'text' => '',
                    'value' => '',
                ],
                'elements' => [
                    [
                        'name' => 'Barcode',
                        'type' => 'static',
                    ],
                ],
            ],
            'id' => '',
            'name' => '',
        ];
    }

    // NOTE - ProjectSettings
    public function get_settings()
    {
        $data = ProjectSetting::where('type', ProjectSetting::BARCODE)->orderByDesc('id');
        $data = Datatables::of($data)->addIndexColumn();

        $data = $data->addColumn('date', function ($row) {
            return '<span class="text-gray-800 fw-bold">' . _d($row['created_at']) . '</span>';
        })->addColumn('actions', function ($row) {
            return '
                <div class="text-end">
                    <a class="btn btn-secondary btn-shadow btn-icon btn-sm me-1"
                        onclick="liveCall(\'edit_settings\', ' . $row['id'] . ')" wire:click="edit_settings(' . $row['id'] . ')">
                        <i class="la la-pencil p-0"></i>
                    </a>
                    <a class="btn btn-danger btn-shadow btn-icon btn-sm"
                        data-kt-ecommerce-order-filter="delete_row"
                        onclick="liveCall(\'delete_settings\', ' . $row['id'] . ')" wire:click="delete_settings(' . $row['id'] . ')">
                        <i class="la la-trash p-0"></i>
                    </a>
                </div>
            ';
        });

        $data = $data->rawColumns(["date", "actions"])->make(true);
        return $data;
    }

    public function saveBarcode()
    {
        $this->saveBarcodeData($this->values['name'], $this->values['barcode'], $this->values['id'], function () {
            $this->clear();
            $this->reloadTable($this->base_data['datatable']['name']);
        });
    }

    public function edit_settings($id)
    {
        $setting = ProjectSetting::where('id', $id)->first();
        $setting_configs = (@unserialize($setting->value) ? unserialize($setting->value) : []);

        $this->values['id'] = $setting->id;
        $this->values['name'] = $setting->name;
        $this->values['barcode'] = $setting_configs['barcode'];
        $this->values['barcode']['choose_column'] = true;
        $this->getColumnOfTable();
        $this->dispatchBrowserEvent('elementsChanged');
    }

    public function delete_settings($id)
    {
        try {
            DB::beginTransaction();
            ProjectSetting::where('id', $id)->delete();
            DB::commit();
            $this->reloadTable($this->base_data['datatable']['name']);
        } catch (\Exception $e) {
            echo $e->getMessage();
            DB::rollback();
        }
    }
}
