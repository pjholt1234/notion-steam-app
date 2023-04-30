<?php

namespace App\Abstracts;

use Livewire\Component;

abstract class FormAbstract extends Component
{
    public array $fields;
    public array $rules;
    public string $view;

    abstract public function submit();

    public function render()
    {
        return view($this->view);
    }

}
