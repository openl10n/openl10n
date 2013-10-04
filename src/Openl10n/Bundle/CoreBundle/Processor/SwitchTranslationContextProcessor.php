<?php

namespace Openl10n\Bundle\CoreBundle\Processor;

use Openl10n\Bundle\CoreBundle\Action\SwitchTranslationContextAction;
use Openl10n\Bundle\CoreBundle\Context\TranslationContext;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Storage\TranslationContextStorage;

class SwitchTranslationContextProcessor
{
    protected $storage;

    public function __construct(TranslationContextStorage $storage)
    {
        $this->storage = $storage;
    }

    public function execute(SwitchTranslationContextAction $action)
    {
        $project = $action->getProject();
        $context = new TranslationContext(new Locale($action->source), new Locale($action->target));

        $this->storage->set($project, $context);
    }
}
