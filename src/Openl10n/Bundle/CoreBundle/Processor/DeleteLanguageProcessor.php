<?php

namespace Openl10n\Bundle\CoreBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Action\DeleteLanguageAction;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteLanguageProcessor
{
    protected $projectManager;
    protected $eventDispatcher;

    public function __construct(
        ObjectManager $projectManager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->projectManager = $projectManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(DeleteLanguageAction $action)
    {
        $language = $action->getLanguage();

        $this->projectManager->remove($language);
        $this->projectManager->flush($language);
    }
}
