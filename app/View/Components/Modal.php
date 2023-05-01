<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public $title;
    public $isOpen;

    public function __construct($title = '')
    {
        $this->title = $title;
    }
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
