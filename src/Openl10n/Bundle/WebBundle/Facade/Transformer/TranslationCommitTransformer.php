<?php

namespace Openl10n\Bundle\WebBundle\Facade\Transformer;

use Openl10n\Bundle\CoreBundle\Context\TranslationContext;
use Openl10n\Bundle\CoreBundle\Model\TranslationKeyInterface;
use Openl10n\Bundle\CoreBundle\Model\TranslationPhrase;
use Openl10n\Bundle\WebBundle\Facade\Model\TranslationCommit;

class TranslationCommitTransformer
{
    protected $context;

    public function __construct(TranslationContext $context)
    {
        $this->context = $context;
    }

    public function transform(TranslationKeyInterface $key)
    {
        $source = $this->context->getSource();
        $target = $this->context->getTarget();

        $sourcePhrase = $key->getPhrase($source) ?: new TranslationPhrase($key, $source);
        $targetPhrase = $key->getPhrase($target) ?: new TranslationPhrase($key, $target);

        return new TranslationCommit($key, $sourcePhrase, $targetPhrase);
    }
}
