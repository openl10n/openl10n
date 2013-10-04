<?php

namespace Openl10n\Bundle\CoreBundle\Repository;

use Openl10n\Bundle\CoreBundle\Model\DomainInterface;

interface TranslationKeyRepositoryInterface
{
    public function findByDomain(DomainInterface $domain);
    public function findOneByHash(DomainInterface $domain, $hash);
}
