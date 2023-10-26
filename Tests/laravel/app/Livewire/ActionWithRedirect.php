<?php

namespace App\Livewire;

use Livewire\Component;

class ActionWithRedirect extends Component
{
    public $title;

    public function save() {
        return redirect()->to("/livewire-conformance-tests/controller#" . $this->title);
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <form wire:submit="save">
                <input wire:model="title" />
                <button type="submit">Save</button>
            </form>
        </div>
        HTML;
    }
}
