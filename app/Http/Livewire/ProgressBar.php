<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProgressBar extends Component
{
    public string $message = '';

    public $progress = 0;

    public bool $active = false;

    protected $listeners = [
        'updateProgress' => 'updateProgress',
        'setProgressBarState' => 'setProgressBarState',
    ];


    public function updateProgress(string $message, $progress = null): void
    {
        $this->active = true;
        $this->message = $message;

        if(isset($progress)){
            $this->progress = $progress;
        }
    }

    public function setProgressBarState(bool $state): void
    {
        $this->active = $state;

        if(!$state){
            $this->progress = 0;
            $this->message = '';
        }
    }


    public function render()
    {
        return view('livewire.progress-bar');
    }
}
