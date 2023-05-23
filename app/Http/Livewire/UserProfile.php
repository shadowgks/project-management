<?php

namespace App\Http\Livewire;

use App\Helpers\TemplateHelper;
use App\Models\SessionModel;
use App\Traits\Includes\ProfileTrait;
use Livewire\Component;
use DataTables;

class UserProfile extends Component
{
    use ProfileTrait;

    protected $listeners = [
        "alertResult",
    ];

    public $base_data = [
        'sessions' => [],
        'logs' => [],
        'datatable' => [
            'logs' => [
                'name' => 'logs',
                'columns' => ['action', 'device', 'browser', 'ip_address', 'date'],
                'data' => [],
                'route' => 'profile.logs.list',
            ]
        ],
    ];

    public $tab;

    public function render()
    {
        return view('livewire.user-profile');
    }

    public function mount($tab)
    {
        $this->tab = $tab;
        $this->profile_mount($tab);
    }

    public function get_sessions()
    {
        $data = SessionModel::orderByDesc('id');
        $data = DataTables::of($data)->addIndexColumn();

        $data = $data->addColumn('date', function ($row) {
            return '<span class="text-gray-800 fw-bold">' . _dt($row['created_at']) . '</span>';
        })->addColumn('action', function ($row) {
            return '<span class="badge badge-light-' . TemplateHelper::getEventColor($row['payload']) . ' fs-7 fw-bold">' . $row['payload'] . '</span>';
        })->addColumn('browser', function ($row) {
            return $row['user_agent'];
        });

        $data = $data->rawColumns(["date", "action"])->make(true);
        return $data;
    }
}
