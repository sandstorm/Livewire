<?php

namespace App\Livewire;

use Livewire\Component;

class ActionAttributes extends Component
{
    public $title;


    public function triggerJs()
    {
        $this->title = "triggerJs";
        $this->js("window.__called = true;");
    }

    public function triggerParameters($parameter)
    {
        $this->title = "triggerParameters" . $parameter;
        return "RETURN VALUE";
    }


    #[\Livewire\Attributes\Renderless]
    public function renderless()
    {
        $this->title = "renderless";
        return "RENDERLESS RETURN";
    }

    // NOTE: we do not need to support this
    // as this can be done clientside directly.
    //
    //#[\Livewire\Attributes\Js]
    //public function triggerJs2()
    //{
    //    return <<<'JS'
    //        $wire.query = '';
    //    JS;
    //}

    public function render()
    {
        return sprintf(<<<'HTML'
        <div x-data="{result: 'x'}">
            <div data-testid="returnValue" x-text="result"></div>
            <div data-testid="title">%s</div>
            <button wire:click="triggerJs" data-testid="triggerJs">Trigger js</button>
            <button wire:click="triggerParameters(1).then((res) => { result = res; })" data-testid="triggerParameters">triggerParameters</button>
            <button wire:click="renderless().then((res) => { result = res; })" data-testid="renderless">renderless</button>
            <button wire:click="$refresh()" data-testid="refresh">refresh</button>
        </div>
        HTML, $this->title);
    }
}
