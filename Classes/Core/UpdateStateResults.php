<?php

namespace Sandstorm\Livewire\Core;

use Neos\Flow\Annotations as Flow;

/**
 * @internal
 */
#[Flow\Proxy(false)]
final class UpdateStateResults
{
    public function __construct(
        public readonly bool $withRendering
    ) {
    }

    public static function create(): self
    {
        return new self(
            withRendering: false
        );
    }

    public function merge(UpdateStateResult $updateStateResult)
    {
        return new self(
            // if one of the two has rendering enabled, we want to enable rendering. (only if ALL actions disable rendering, it stays disabled)
            withRendering: $this->withRendering || $updateStateResult->withRendering
        );
    }
}
