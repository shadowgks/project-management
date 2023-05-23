<?php

namespace App\Http\Livewire;

use App\Traits\AppTrait;
use Livewire\Component;

class Table extends Component
{
    use AppTrait;

    public $_id;
    public $_key;
    public $class;
    public $cardClass;
    public $content;
    public $module_id;
    public $data = [];
    public $types = [];
    public $totals = [];
    public $columns = [];
    public $filters = [];
    public $withCard = true;
    public $helper = '';
    public $values = [
        'rows' => [],
    ];
    public $route;

    public function render()
    {
        return view('livewire.components.table');
    }

    public function mount()
    {
        //
    }

    public function checkRowP($id)
    {
        $this->emit('checkRow', [
            'id' => $id,
            'rows' => $this->values['rows'],
        ]);
    }

    public function _show($id)
    {
        $this->emit('show_row', $id);
    }

    public function editDataP($id)
    {
        $this->emit('editData', $id);
    }

    public function validateDataP($id)
    {
        $this->emit('validateData', $id);
    }

    public function printDataP($id)
    {
        $this->emit('printData', $id);
    }

    public function deleteDataP($id)
    {
        $this->emit('deleteData', $id);
    }

    public function initColumns()
    {
        $arrayHelper = [];

        foreach ($this->columns as $key => $column) {
            array_push($arrayHelper, [
                'name' => $column,
                'data' => $column,
            ]);
        }

        return $arrayHelper;
    }
}
