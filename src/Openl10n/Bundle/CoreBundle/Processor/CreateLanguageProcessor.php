<?php

namespace Openl10n\Bundle\CoreBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Action\CreateLanguageAction;
use Openl10n\Bundle\CoreBundle\Factory\LanguageFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateLanguageProcessor
{
    protected $projectManager;
    protected $languageRepository;
    protected $eventDispatcher;

    public function __construct(
        ObjectManager $projectManager,
        LanguageFactoryInterface $languageFactory,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->projectManager = $projectManager;
        $this->languageFactory = $languageFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(CreateLanguageAction $action)
    {
        $project = $action->getProject();
        $locale = new Locale($action->locale);

        $language = $this->languageFactory->createNew($project, $locale);
        $this->projectManager->persist($language);
        $this->projectManager->flush($language);

        return $language;
    }
}
