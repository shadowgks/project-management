<?php

namespace App\Http\Livewire;

use App\Models\DropDown;
use App\Models\ProjectSetting;
use App\Traits\Module\DropdownTrait;
use Livewire\Component;
use DataTables;

class GenerateDropdown extends Component
{
    use DropdownTrait;

    protected $listeners = [
        'alertResult',
    ];

    public $base_data = [];
    public $values = [];
    public $options = [];

    public function render()
    {
        return view('livewire.generate-dropdown');
    }

    public function mount()
    {
        $this->dropdown_getSupportedData();
    }

    public function get_settings()
    {
        $data = DropDown::whereNot('app_module_id', 1)->with('app_module')->orderByDesc('id')->groupBy('app_module_id', 'select_field');
        $data = DataTables::of($data)->addIndexColumn();

        $data = $data->addColumn('app_module.name', function ($row) {
            return $row['app_module']['name'] . ' - ' . $row['select_field'];
        })->addColumn('date', function ($row) {
            return '<span class="text-gray-800 fw-bold">' . _d($row['created_at']) . '</span>';
        })->addColumn('actions', function ($row) {
            return '
                <div class="text-end">
                    <a class="btn btn-secondary btn-shadow btn-icon btn-sm me-1"
                        onclick="liveCall(\'dropdown_edit_settings\', {
                            select_field: \'' . $row['select_field'] . '\',
                            app_module_id: ' . $row['app_module_id'] . '
                        })">
                        <i class="la la-pencil p-0"></i>
                    </a>
                    <a class="btn btn-danger btn-shadow btn-icon btn-sm"
                        data-kt-ecommerce-order-filter="delete_row"
                        onclick="liveCall(\'dropdown_delete_settings\', {
                            select_field: \'' . $row['select_field'] . '\',
                            app_module_id: ' . $row['app_module_id'] . '
                        })">
                        <i class="la la-trash p-0"></i>
                    </a>
                </div>
            ';
        });

        $data = $data->rawColumns(["date", "actions"])->make(true);
        return $data;
    }
}
