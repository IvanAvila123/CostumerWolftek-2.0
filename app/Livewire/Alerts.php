<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alerts extends Component
{
    public $type;

    public function __construct($type = 'info')
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('components.alerts');
    }
}
