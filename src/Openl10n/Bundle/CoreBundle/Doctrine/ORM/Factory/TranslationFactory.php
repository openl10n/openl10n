<?php

namespace Openl10n\Bundle\CoreBundle\Doctrine\ORM\Factory;

use Openl10n\Bundle\CoreBundle\Entity\TranslationKey;
use Openl10n\Bundle\CoreBundle\Entity\TranslationPhrase;
use Openl10n\Bundle\CoreBundle\Factory\TranslationFactoryInterface;
use Openl10n\Bundle\CoreBundle\Model\DomainInterface;
use Openl10n\Bundle\CoreBundle\Model\TranslationKeyInterface;
use Openl10n\Bundle\CoreBundle\Object\Locale;

class TranslationFactory implements TranslationFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNewKey(DomainInterface $domain, $key)
    {
        return new TranslationKey($domain, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function createNewPhrase(TranslationKeyInterface $key, Locale $locale)
    {
        return new TranslationPhrase($key, $locale);
    }
}
