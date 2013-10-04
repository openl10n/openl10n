<?php

namespace Openl10n\Bundle\CoreBundle\Factory;

use Openl10n\Bundle\CoreBundle\Model\DomainInterface;
use Openl10n\Bundle\CoreBundle\Model\TranslationKeyInterface;
use Openl10n\Bundle\CoreBundle\Object\Locale;

interface TranslationFactoryInterface
{
    public function createNewKey(DomainInterface $domain, $key);
    public function createNewPhrase(TranslationKeyInterface $key, Locale $locale);
}
