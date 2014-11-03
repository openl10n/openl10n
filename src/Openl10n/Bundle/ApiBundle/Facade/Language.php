<?php

namespace Openl10n\Bundle\ApiBundle\Facade;

use JMS\Serializer\Annotation as Serializer;
use Openl10n\Value\Localization\DisplayLocale;
use Openl10n\Value\Localization\Locale;

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

    public function __construct(Locale $locale)
    {
        $displayLocale = DisplayLocale::createFromLocale($locale);

        $this->locale = (string) $locale;
        $this->name = $displayLocale->getName();
    }
}
