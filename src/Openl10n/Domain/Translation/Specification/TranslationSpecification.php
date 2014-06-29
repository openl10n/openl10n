<?php

namespace Openl10n\Domain\Translation\Specification;

use Openl10n\Domain\Translation\Model\Key;

interface TranslationSpecification
{
    /**
     * @return boolean
     */
    public function isSatisfiedBy(Key $translationKey);
}
