<?php

namespace Sandstorm\Livewire\Example;

use Sandstorm\Livewire\Core\LivewireComponentInterface;

class CounterComponent implements LivewireComponentInterface
{

    private function __construct(
        private int $counter = 0,
        private string $title = '',
    ) {
    }

    public static function deserialize(array $state): LivewireComponentInterface
    {
        return new static(
            counter: $state['counter'],
            title: $state['title']
        );
    }

    public function render(): string
    {
        return sprintf(
            <<<EOF
<div>%s, %s <button wire:click="increase">Increase</button> <button wire:click="decrease">Decrease</button></div>
        <input type="text" wire:model.live="title">
EOF, $this->counter, $this->title
        );
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    public function dispatchAction(string $action, array $params): void
    {
        match($action) {
            'increase' => $this->increase(),
            'decrease' => $this->decrease(),
        };
    }

    public static function create(): LivewireComponentInterface
    {
        return new static();
    }

    private function increase(): void
    {
        $this->counter++;
    }

    private function decrease(): void
    {
        $this->counter--;
    }

    public function updateState(string $state, mixed $value): void
    {
        match($state) {
            'title' => $this->title = $value
        };
    }
}
