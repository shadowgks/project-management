<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AppAlert extends Component
{
    /**
     * NOTE - Types
     * - success
     * - error
     * - question
     * - confirm
     */

    public function render()
    {
        return view('livewire.components.app-alert');
    }

    public function actionButton($action)
    {
        if ($action == 'no') {
            $result['result'] = false;
        } else if (in_array($action, ['yes', 'ok'])) {
            $result['result'] = true;
        }

        $this->emit('alertResult', $result);
    }
}
