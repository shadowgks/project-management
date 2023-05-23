<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{

    public $hastitle ;
    public $hasfooter ;
    public $bodyclass ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($hastitle, $hasfooter,$bodyclass)
    {
        $this->hastitle = $hastitle;
        $this->hasfooter = $hasfooter; 
        $this->bodyclass = $bodyclass; 
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        
        return view('components.card');
    }
}
