<?php

namespace App\Traits\Includes;

use App\Helpers\StringHelper;
use App\Models\SessionModel;
use App\Models\User;
use App\Traits\AppTrait;
use Auth;
use Spatie\Activitylog\Models\Activity;
use Validator;

trait ProfileTrait
{
    use AppTrait;

    public $profile_trait = [
        'base_data' => [
            'user' => [],
            'user_name' => '',
        ],
        'values' => [
            'password' => [
                'current_password' => '',
                'new_password' => '',
                'second_password' => '',
            ],
        ],
        'options' => [
            'changing_password' => false,
        ],
    ];

    public function profile_mount($tab = null)
    {
        $this->profile_trait['base_data']['user'] = Auth::user()->toArray();
        $this->profile_trait['base_data']['user_name'] = $this->profile_trait['base_data']['user'] == null ? '-' : $this->profile_trait['base_data']['user']['first_name'] . ' ' . $this->profile_trait['base_data']['user']['last_name'];

        if ($tab != null) {
            switch ($tab) {
                case 'logs':
                    $this->base_data['sessions'] = SessionModel::where('user_id', $this->profile_trait['base_data']['user']['id'])->orderByDesc('id')->get();
                    $this->base_data['logs'] = Activity::where('causer_id', $this->profile_trait['base_data']['user']['id'])->orderByDesc('id')->get();
                    break;

                default:
                    //
                    break;
            }
        }
    }

    public function profile_change_password($bool)
    {
        $this->profile_trait['options']['changing_password'] = $bool;

        if (!$bool) {
            $this->profile_trait['values']['password']['current_password'] = '';
            $this->profile_trait['values']['password']['new_password'] = '';
            $this->profile_trait['values']['password']['second_password'] = '';
        }
    }

    public function profile_show_confirm_modal()
    {
        $validator = Validator::make($this->profile_trait['values']['password'], [
            'new_password' => 'required|between:8,16|same:second_password',
            'second_password' => 'required|between:8,16',
        ]);

        if ($validator->fails()) {
            $this->showAlert('error', StringHelper::getValidatorMessages($validator));
            return;
        }

        $this->showAlert("question", __('Are you sure!'), 'change_password');
    }

    public function alertResult($result)
    {
        if ($result) {
            if ($this->appOptions["alert"]["target"] == "change_password") {
                User::updatePassword($this->profile_trait['values']['password']['new_password']);
                $this->profile_change_password(false);
                $this->showSlideAlert("success", __('Password changed with success'));
            }
        }

        $this->hideAlert();
    }
}
