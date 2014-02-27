<?php

namespace Openl10n\Domain\Project\Application\Action;

use Openl10n\Domain\Project\Model\Language;

class DeleteLanguageAction
{
    protected $language;

    public function __construct(Language $language)
    {
        $this->language = $language;
    }

    public function getLanguage()
    {
        return $this->language;
    }
}
