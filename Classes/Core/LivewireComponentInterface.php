<?php

namespace Sandstorm\Livewire\Core;

interface LivewireComponentInterface extends \JsonSerializable
{

    public static function create(): self;

    public static function deserialize(array $state): self;

    public function dispatchAction(string $action, array $params);

    public function updateState(string $state, mixed $value): void;

    public function render(): string;
}
