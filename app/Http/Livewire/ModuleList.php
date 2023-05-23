<?php

namespace App\Http\Livewire;

use App\Models\AppModule;
use App\Traits\AppTrait;
use Livewire\Component;
use DataTables;

class ModuleList extends Component
{
    use AppTrait;

    protected $listeners = [
        'alertResult',
    ];

    public $base_data = [
        'datatable' => [
            'name' => 'modules',
            'columns' => ['name', 'date', 'actions'],
            'data' => [],
            'route' => 'modules.list',
        ],
    ];

    public function render()
    {
        return view('livewire.module-list');
    }

    public function get_list()
    {
        $data = AppModule::whereNot('id', 1)->orderByDesc('id');
        $data = DataTables::of($data)->addIndexColumn();

        $data = $data->addColumn('date', function ($row) {
            return '<span class="text-gray-800 fw-bold">' . _d($row['created_at']) . '</span>';
        })->addColumn('actions', function ($row) {
            return '
                <div class="text-end">
                    <!-- <a class="btn btn-secondary btn-shadow btn-icon btn-sm me-1"
                        onclick="liveCall(\'edit_module\', ' . $row['id'] . ')" wire:click="edit_module(' . $row['id'] . ')">
                        <i class="la la-pencil p-0"></i>
                    </a> -->
                    <a class="btn btn-danger btn-shadow btn-icon btn-sm"
                        data-kt-ecommerce-order-filter="delete_row"
                        onclick="liveCall(\'delete_module\', ' . $row['id'] . ')" wire:click="delete_module(' . $row['id'] . ')">
                        <i class="la la-trash p-0"></i>
                    </a>
                </div>
            ';
        });

        $data = $data->rawColumns(["date", "actions"])->make(true);
        return $data;
    }

    public function delete_module($id)
    {
        $this->req(function () use ($id) {
            $this->appOptions['id'] = $id;
            $this->showAlert("question", "Are you sure?", "delete");
        });
    }

    public function alertResult($result)
    {
        $this->req(function () use ($result) {
            if ($result) {
                if ($this->appOptions["alert"]["target"] == "delete") {
                    AppModule::_delete($this->appOptions['id']);
                    $this->showSlideAlert('success', 'Module deleted successfully!');
                    $this->reloadTable($this->base_data['datatable']['name']);
                }
            }

            $this->appOptions['id'] = null;
        }, [
            'db_exception' => false,
            'hide_alert' => true,
        ]);
    }
}
