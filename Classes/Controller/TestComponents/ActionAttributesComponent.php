<?php

namespace Sandstorm\Livewire\Controller\TestComponents;

use Sandstorm\Livewire\Core\ActionResult;
use Sandstorm\Livewire\Core\LivewireComponentInterface;
use Sandstorm\Livewire\Core\UpdateStateResult;

/**
 * SEE: Tests/laravel/app/Livewire/ActionAttributes.php
 */
class ActionAttributesComponent implements LivewireComponentInterface
{

    private function __construct(
        private string $title = '',
    ) {
    }

    public static function deserialize(array $state): LivewireComponentInterface
    {
        return new static(
            title: $state['title']
        );
    }

    public function render(): string
    {
        return sprintf(
            <<<'EOF'
    <div x-data="{result: 'x'}">
        <div data-testid="returnValue" x-text="result"></div>
        <div data-testid="title">%s</div>
        <button wire:click="triggerJs" data-testid="triggerJs">Trigger js</button>
        <button wire:click="triggerParameters(1).then((res) => { result = res; })" data-testid="triggerParameters">triggerParameters</button>
        <button wire:click="renderless().then((res) => { result = res; })" data-testid="renderless">renderless</button>
        <button wire:click="$refresh()" data-testid="refresh">refresh</button>
    </div>
EOF, $this->title
        );
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    public function dispatchAction(string $action, array $params): ActionResult
    {
        return match($action) {
            'triggerJs' => $this->triggerJs(),
            'triggerParameters' => $this->triggerParameters(...$params),
            'renderless' => $this->renderless(...$params),
        };
    }

    public static function create(array $args = null): LivewireComponentInterface
    {
        return new static();
    }


    public function updateState(string $state, mixed $value): UpdateStateResult
    {
        match($state) {
            'title' => $this->title = $value
        };

        return UpdateStateResult::create();
    }

    private function triggerJs(): ActionResult
    {
        $this->title = "triggerJs";

        return ActionResult::create(null)
            ->withJs("window.__called = true;");
    }

    private function triggerParameters($parameter): ActionResult
    {
        $this->title = "triggerParameters" . $parameter;

        return ActionResult::create("RETURN VALUE");
    }

    private function renderless(): ActionResult
    {
        $this->title = "renderless";
        return ActionResult::create("RENDERLESS RETURN")
            ->withoutRendering();
    }
}
