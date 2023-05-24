<?php

namespace App\Http\Livewire;

use Error;
use Livewire\Component;

class Modal extends Component
{
    public string $content;

    public string $title;
    public array $params;

    protected $listeners = [
        'updateModal',
    ];

    public function updateModal($data)
    {
        if(!is_array($data)){
            $data = json_decode($data, true);
        }

        if(!array_key_exists('content', $data)){
            throw new Error('Missing Content key');
        }

        $this->content = $data['content'];

        if(array_key_exists('params', $data)){
            $this->params = $data['params'];
        }

        if(array_key_exists('title', $data)){
            $this->title = $data['title'];
        }

        $this->dispatchBrowserEvent('modal-toggle');
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
