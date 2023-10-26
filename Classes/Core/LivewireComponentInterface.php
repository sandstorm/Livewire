<?php

namespace Sandstorm\Livewire\Core;

/**
 * Main API for a livewire component in Neos / Flow.
 *
 * ## Creating / Initial Rendering
 *
 * The initial creation should be done through the static {@see self::create()} function.
 *
 * Then, you can render via {@see LivewireComponentRenderer::render()}.
 *
 * This internally will:
 * - call {@see self::render()} for rendering the component. Every component MUST return a single wrapping HTML
 *   element, and VALID HTML.
 * - call {@see self::jsonSerialize()} to serialize the internal state of the component.
 *
 *
 * ## Interactivity via Livewire
 *
 * The process is as follows:
 *
 * - the URL /livewire/update is called
 * - this triggers {@see LivewireComponentRenderer::update()}
 *   - this instantiates the component via {@see self::deserialize()},
 *   - then calls methods/actions if needed via {@see self::dispatchAction()}
 *   - then updates the state if needed via {@see self::updateState()}
 *   - then again renders the component by calling {@see self::render()}
 *
 */
interface LivewireComponentInterface extends \JsonSerializable
{

    public static function create(array $args = null): self;

    public static function deserialize(array $state): self;

    public function dispatchAction(string $action, array $params);

    public function updateState(string $state, mixed $value): void;

    public function render(): string;
}
