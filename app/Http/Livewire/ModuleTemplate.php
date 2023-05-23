<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ModuleTemplate extends Component
{
    public $title = "Moduel View";
    public $baseData = [];
    public $filters = [];
    public $filterLoops = [];
    public $custom_filters = [];
    public $table = [
        'data' => [],
        'columns' => [],
        'totals' => [],
    ];
    public $options = [
        'selected_filter' => -1,
        'show_filters' => false,
        'show_modal' => false,
        'id' => null,
    ];

    public function render()
    {
        // dd($this->filterLoops, $this->baseData);
        return view('livewire.templates.module-template');
    }

    public function action_options($name)
    {
        $this->options[$name] = !$this->options[$name];
    }

    public function filter_data()
    {
        $sales = new SalesController;
        $result = $sales->custom_filter_data($this->filters);
        $this->emit('refreshData', $result);
    }
}
