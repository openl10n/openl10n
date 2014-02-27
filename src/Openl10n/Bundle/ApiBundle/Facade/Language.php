<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Domain\Project\Model\Language as LanguageModel;
use Openl10n\Value\Localization\DisplayLocale;

class Language
{
    /**
     * @Serializer\Type("string")
     */
    public $locale;

    /**
     * @Serializer\Type("string")
     */
    public $name;

    public function __construct(LanguageModel $language)
    {
        $locale = $language->getLocale();
        $displayLocale = DisplayLocale::createFromLocale($locale);

        $this->locale = (string) $locale;
        $this->name = $displayLocale->getName();
    }
}
