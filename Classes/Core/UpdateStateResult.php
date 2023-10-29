<?php

namespace Sandstorm\Livewire\Core;

use Neos\Flow\Annotations as Flow;

/**
 * @api
 */
#[Flow\Proxy(false)]
final class UpdateStateResult
{
    public function __construct(
        public readonly bool $withRendering
    ) {}

    public static function create(): self
    {
        return new self(
            withRendering: true
        );
    }

    public function withoutRendering(): self
    {
        return new self(
            withRendering: false
        );
    }
}
