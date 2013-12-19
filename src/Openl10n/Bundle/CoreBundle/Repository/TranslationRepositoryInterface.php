<?php

namespace Openl10n\Bundle\CoreBundle\Repository;

use Openl10n\Bundle\CoreBundle\Model\DomainInterface;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Specification\TranslationSpecificationInterface;

interface TranslationRepositoryInterface
{
    public function findByDomain(DomainInterface $domain);
    public function findOneByKey(DomainInterface $domain, $key);
    public function findOneByHash(ProjectInterface $project, $hash);
    public function findSatisfying(TranslationSpecificationInterface $spec);
    public function paginateSatisfying(TranslationSpecificationInterface $spec);
}
