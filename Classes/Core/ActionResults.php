<?php

namespace Sandstorm\Livewire\Core;

use Neos\Flow\Annotations as Flow;

/**
 * @internal
 */
#[Flow\Proxy(false)]
final class ActionResults
{
    public function __construct(
        public readonly array $returnValues,
        public readonly bool $withRendering,
        public readonly array $js,
    ) {
    }

    public static function create(): static
    {
        return new static(
            returnValues: [],
            withRendering: false,
            js: []
        );
    }

    public function merge(ActionResult $actionResult): static
    {
        return new static(
            returnValues: [
                ...$this->returnValues,
                $actionResult->returnValue
            ],
            // if one of the two has rendering enabled, we want to enable rendering. (only if ALL actions disable rendering, it stays disabled)
            withRendering: $this->withRendering || $actionResult->withRendering,
            js: isset($actionResult->js) ? [
                ...$this->js,
                $actionResult->js,
            ] : $this->js
        );
    }

    public function withUpdateStateResults(UpdateStateResults $results): static
    {
        return new static(
            returnValues: $this->returnValues,
            // if one of the two has rendering enabled, we want to enable rendering. (only if ALL actions disable rendering, it stays disabled)
            withRendering: $this->withRendering || $results->withRendering,
            js: $this->js,
        );
    }

    public function empty(): bool
    {
        // TODO: improve
        return count($this->returnValues) === 0;
    }
}
