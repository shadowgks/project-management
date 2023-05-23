<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowPosts extends Component
{
    public $base_data = [
        // 
    ];

    public $values = [
        // 
    ];

    public $options = [
        // 
    ];

    public function render()
    {
        return view('livewire.show-posts');
    }

    public function mount()
    {
        // 
    }
}
