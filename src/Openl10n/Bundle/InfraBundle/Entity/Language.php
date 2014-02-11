<?php

namespace Openl10n\Bundle\InfraBundle\Entity;

use Openl10n\Domain\Project\Model\Language as BaseLanguage;
use Openl10n\Value\Localization\Locale;

class Language extends BaseLanguage
{
    private $id;

    public function getLocale()
    {
        if (!$this->locale instanceof Locale) {
            $this->locale = Locale::parse($this->locale);
        }

        return $this->locale;
    }
}
