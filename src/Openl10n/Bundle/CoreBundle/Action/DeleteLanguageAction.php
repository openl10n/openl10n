<?php

namespace Openl10n\Bundle\CoreBundle\Action;

use Openl10n\Bundle\CoreBundle\Model\LanguageInterface;

class DeleteLanguageAction
{
    protected $language;

    public function __construct(LanguageInterface $language)
    {
        $this->language = $language;
    }

    public function getLanguage()
    {
        return $this->language;
    }
}
