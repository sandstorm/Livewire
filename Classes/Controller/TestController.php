<?php

namespace Sandstorm\Livewire\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\ResourceManagement\ResourceManager;
use Sandstorm\Livewire\Core\LivewireComponentRenderer;
use Sandstorm\Livewire\Example\CounterComponent;

class TestController extends ActionController
{
    #[Flow\Inject]
    protected LivewireComponentRenderer $livewireComponentRenderer;

    #[Flow\Inject]
    protected ResourceManager $resourceManager;

    public function indexAction()
    {

        $livewireScriptUri = $this->resourceManager->getPublicPackageResourceUri('Sandstorm.Livewire', 'vendor/livewire.js');
        $output = $this->livewireComponentRenderer->render(CounterComponent::create());

        $output .= '<script src="' . $livewireScriptUri . '" data-csrf="TODO WHAT IS THIS" data-uri="/livewire/update" data-navigate-once="true"></script>';
        echo $output;


        die();
    }
}
