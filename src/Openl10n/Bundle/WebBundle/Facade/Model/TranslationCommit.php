<?php

namespace Openl10n\Bundle\WebBundle\Facade\Model;

use Openl10n\Bundle\CoreBundle\Model\TranslationKeyInterface;
use Openl10n\Bundle\CoreBundle\Model\TranslationPhraseInterface;

class TranslationCommit
{
    protected $key;
    protected $source;
    protected $target;

    public function __construct(
        TranslationKeyInterface $key,
        TranslationPhraseInterface $source,
        TranslationPhraseInterface $target
    )
    {
        $this->key = $key;
        $this->source = $source;
        $this->target = $target;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function isSourceValid()
    {
        return $this->source->isApproved();
    }

    public function isTranslated()
    {
        return '' !==  $this->target->getText();
    }

    public function isApproved()
    {
        return $this->target->isApproved();
    }
}
