<?php

namespace Sandstorm\Livewire\Core;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\ObjectManagement\ObjectManagerInterface;
use Neos\Flow\Utility\Algorithms;
use Neos\Fusion\Service\HtmlAugmenter;

#[Flow\Scope("singleton")]
class LivewireComponentRenderer
{

    #[Flow\Inject]
    protected HtmlAugmenter $htmlAugmenter;


    #[Flow\Inject]
    protected ObjectManagerInterface $objectManager;

    public function render(LivewireComponentInterface $livewireComponent): string
    {
        $output = $livewireComponent->render();

        $id = Algorithms::generateRandomString(20);

        $snapshot = [
            'data' => $livewireComponent->jsonSerialize(),
            'memo' => [
                // https://livewire.laravel.com/docs/javascript#the-snapshot-object

                // The component's unique ID...
                // $component->setId($id ?: str()->random(20));, see \Livewire\Mechanisms\ComponentRegistry::new
                'id' => $id,

                // The component's name. Ex. <livewire:[name] />
                // TODO: in Neos, we use the full class name of the component factory
                'name' => get_class($livewireComponent),

                // The URI, method, and locale of the web page that the
                // component was originally loaded on. This is used
                // to re-apply any middleware from the original request
                // to subsequent component update requests (commits)...
                'path' => 'testfoo',
                'method' => 'GET',
                'locale' => 'de',


                // A list of any nested "child" components. Keyed by
                // internal template ID with the component ID as the values...
                'children' => [],

                // Weather or not this component was "lazy loaded"...
                'lazyLoaded' => false,

                // A list of any validation errors thrown during the
                // last request...
                'errors' => [],

            ],
        ];
        return $this->htmlAugmenter->addAttributes($output, [
            // {"data":{"counter":0},"memo":{"id":"ctrE01RHT8fRFCnhQ7DZ","name":"test-foo","path":"testfoo","method":"GET","children":[],"errors":[],"locale":"de"},"checksum":"a01fa577ebee4e2e81b277053bc1e4559c5926299532a8d72f93dd7113d02929"}
            'wire:snapshot' => json_encode([
                ...$snapshot,
                // A securely encryped hash of this snapshot. This way,
                // if a malicous user tampers with the snapshot with
                // the goal of accessing un-owned resources on the server,
                // the checksum validation will fail and an error will
                // be thrown...
                // \Livewire\Mechanisms\HandleComponents\Checksum::generate
                'checksum' => hash_hmac('sha256', json_encode($snapshot), '___TODO____HASHKEY'), // TODO hash key
            ]),
            'wire:effects' => '[]',
            'wire:id' => $id
        ]);
    }

    public function update(array $snapshot, array $updates, array $calls): array
    {
        // \Livewire\Mechanisms\HandleComponents\HandleComponents::update
        $memo = $snapshot['memo'];
        $id = $snapshot['memo']['id'];

        $component = $this->fromSnapshot($snapshot);
        $context = new ComponentContext();
        $context->memo = $memo;

        // $this->pushOntoComponentStack($component);

        $updateStateResults = $this->updateProperties($component, $updates);

        $actionResults = $this->callMethods($component, $calls, $context);
        $actionResults = $actionResults->withUpdateStateResults($updateStateResults);

        if ($actionResults->empty() || $actionResults->withRendering) {
            $html = $this->renderDuringUpdate($component, $id);
            $context->addEffect('html', $html);
        }

        if (count($actionResults->js)) {
            $context->addEffect('xjs', $actionResults->js);
        }

        $snapshot = $this->snapshot($component, $context, $id);

        // $this->popOffComponentStack();

        return [$snapshot, $context->effects];
    }

    protected function updateProperties(LivewireComponentInterface $component, $updates): UpdateStateResults
    {
        $results = UpdateStateResults::create();
        foreach ($updates as $path => $value) {
            $results = $results->merge($component->updateState($path, $value));
        }
        return $results;
    }


    private function renderDuringUpdate(LivewireComponentInterface $livewireComponent, string $id): string
    {
        $output = $livewireComponent->render();

        return $this->htmlAugmenter->addAttributes($output, [
            'wire:id' => $id
        ]);
    }


    private function snapshot(LivewireComponentInterface $component, ComponentContext $context, string $id): array
    {
        $snapshot = [
            'data' => $component->jsonSerialize(),
            'memo' => [
                'id' => $id,
                'name' => get_class($component),
                ...$context->memo,
            ],
        ];

        $snapshot['checksum'] = hash_hmac('sha256', json_encode($snapshot), '___TODO____HASHKEY'); // TODO hash key

        return $snapshot;
    }

    protected function callMethods(LivewireComponentInterface $root, array $calls, ComponentContext $context): ActionResults
    {
        $results = ActionResults::create();
        foreach ($calls as $call) {
            $method = $call['method'];
            $params = $call['params'];


            $earlyReturnCalled = false;
            $earlyReturn = null;
            // TODO
            $returnEarly = function ($return = null) use (&$earlyReturnCalled, &$earlyReturn) {
                $earlyReturnCalled = true;
                $earlyReturn = $return;
            };

            $results = $results->merge($root->dispatchAction($method, $params));
        }

        $context->addEffect('returns', $results->returnValues);
        return $results;
    }


    private function fromSnapshot($snapshot): LivewireComponentInterface
    {
        // TODO: Checksum::verify($snapshot);

        $data = $snapshot['data'];
        $name = $snapshot['memo']['name'];


        return $name::deserialize($data);
    }
}
