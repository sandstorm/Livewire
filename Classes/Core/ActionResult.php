<?php

namespace Sandstorm\Livewire\Core;

use Neos\Flow\Annotations as Flow;
/**
 * @api
 */
#[Flow\Proxy(false)]
final class ActionResult
{
    public function __construct(
        public readonly mixed $returnValue,
        public readonly bool $withRendering,
        public readonly ?string $js = null
    ) {}

    public static function create(mixed $returnValue): self
    {
        return new self(
            returnValue: $returnValue,
            withRendering: true,
            js: null
        );
    }

    public function withoutRendering(): self
    {
        return new self(
            returnValue: $this->returnValue,
            withRendering: false,
            js: $this->js
        );
    }

    public function withJs(string $js): self
    {
        return new self(
            returnValue: $this->returnValue,
            withRendering: $this->withRendering,
            js: $js
        );
    }
}
