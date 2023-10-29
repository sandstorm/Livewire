<?php

namespace Sandstorm\Livewire\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\ResourceManagement\ResourceManager;
use Sandstorm\Livewire\Controller\TestComponents\ActionAttributesComponent;
use Sandstorm\Livewire\Controller\TestComponents\SimpleActionAndModelComponent;
use Sandstorm\Livewire\Core\LivewireComponentRenderer;

class TestController extends ActionController
{
    #[Flow\Inject]
    protected LivewireComponentRenderer $livewireComponentRenderer;

    #[Flow\Inject]
    protected ResourceManager $resourceManager;

    public function actionAttributesAction()
    {

        $livewireScriptUri = $this->resourceManager->getPublicPackageResourceUri('Sandstorm.Livewire', 'vendor/livewire.js');
        $output = $this->livewireComponentRenderer->render(ActionAttributesComponent::create());

        $output .= '<script src="' . $livewireScriptUri . '" data-csrf="TODO WHAT IS THIS" data-uri="/livewire/update" data-navigate-once="true"></script>';
        echo $output;


        die();
    }

    public function simpleActionAndModelAction()
    {

        $livewireScriptUri = $this->resourceManager->getPublicPackageResourceUri('Sandstorm.Livewire', 'vendor/livewire.js');
        $output = $this->livewireComponentRenderer->render(SimpleActionAndModelComponent::create());

        $output .= '<script src="' . $livewireScriptUri . '" data-csrf="TODO WHAT IS THIS" data-uri="/livewire/update" data-navigate-once="true"></script>';
        echo $output;


        die();
    }
}
