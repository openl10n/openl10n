<?php

namespace Openl10n\Bundle\CoreBundle\Specification;

use Openl10n\Bundle\CoreBundle\Model\TranslationKeyInterface;

interface TranslationSpecificationInterface
{
    public function isSatisfiedBy(TranslationKeyInterface $translationKey);
}
