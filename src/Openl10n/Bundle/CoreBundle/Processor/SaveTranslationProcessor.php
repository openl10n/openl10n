<?php

namespace Openl10n\Bundle\CoreBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Action\SaveTranslationAction;
use Openl10n\Bundle\CoreBundle\Factory\TranslationFactoryInterface;

class SaveTranslationProcessor
{
    protected $translationFactory;
    protected $translationManager;

    public function __construct(
        TranslationFactoryInterface $translationFactory,
        ObjectManager $translationManager
    )
    {
        $this->translationFactory = $translationFactory;
        $this->translationManager = $translationManager;
    }

    public function execute(SaveTranslationAction $action)
    {
        $key = $action->getKey();
        $locale = $action->getLocale();

        $phrase = $key->getPhrase($locale);
        if (null === $phrase) {
            $phrase = $this->translationFactory->createNewPhrase($key, $locale);
        }

        $phrase->setText($action->text);
        $phrase->setApproved($action->isApproved);

        $this->translationManager->persist($phrase);
        $this->translationManager->flush($phrase);

        return $phrase;
    }
}
