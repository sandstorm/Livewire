<?php

namespace App\Livewire;

use Livewire\Component;

class SimpleActionAndModel extends Component
{
    public $counter = 0;
    public $title = '';

    public function increase()
    {
        $this->counter++;
    }

    public function decrease()
    {
        $this->counter--;
    }

    public function render()
    {
        return <<<'HTML'
        <div>
                <h1 data-testid="counter">Counter: {{ $counter }}</h1>
                <span data-testid="title-output">{{ $title }}</span>
                <input type="text" wire:model.live="title" />

                <button
                    type="button"
                    wire:click="increase"
                >
                    Increase
                </button>

                <button
                    type="button"
                    wire:click="decrease"
                >
                    Decrease
                </button>
        </div>
        HTML;
    }
}
