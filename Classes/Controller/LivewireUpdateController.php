<?php

namespace Sandstorm\Livewire\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Sandstorm\Livewire\Core\LivewireComponent;
use Sandstorm\Livewire\Core\LivewireComponentRenderer;
use Sandstorm\Livewire\Example\CounterComponentFactory;

class LivewireUpdateController extends ActionController
{
    #[Flow\Inject]
    protected LivewireComponentRenderer $livewireComponentRenderer;

    public function updateAction()
    {

        /* BODY: {
            "_token":"EGTWJGXCAPhLlp8TIGBHYTy5P4ACwbfY0Nbk1Wfb",
            "components":[
                {
                    "snapshot": "{\"data\":{\"counter\":0},\"memo\":{\"id\":\"ctrE01RHT8fRFCnhQ7DZ\",\"name\":\"test-foo\",\"path\":\"testfoo\",\"method\":\"GET\",\"children\":[],\"errors\":[],\"locale\":\"de\"},\"checksum\":\"a01fa577ebee4e2e81b277053bc1e4559c5926299532a8d72f93dd7113d02929\"}",
                    "updates":{},
                    "calls":[{"path":"","method":"increase","params":[]}]}]}
         */
        $parsed = $this->request->getHttpRequest()->getParsedBody();

        $components = $parsed['components'];

        $responses = [];
        foreach ($components as $component) {
            $snapshot = json_decode($component['snapshot'], associative: true);
            $updates = $component['updates'];
            $calls = $component['calls'];

            [ $snapshot, $effects ] = $this->livewireComponentRenderer->update($snapshot, $updates, $calls);

            $responses[] = [
                'snapshot' => json_encode($snapshot),
                'effects' => $effects,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode([
            'components' => $responses,
        ]);

        die();
    }
}
