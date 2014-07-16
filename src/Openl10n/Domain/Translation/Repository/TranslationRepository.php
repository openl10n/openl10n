<?php

namespace Openl10n\Domain\Translation\Repository;

use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Model\Phrase;
use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Domain\Translation\Specification\TranslationSpecification;
use Openl10n\Domain\Translation\Value\StringIdentifier;
use Openl10n\Value\Localization\Locale;

interface TranslationRepository
{
    /**
     * @return \Openl10n\Bundle\InfraBundle\Entity\Key
     */
    public function createNewKey(Resource $resource, StringIdentifier $identifier);

    /**
     * @return \Openl10n\Bundle\InfraBundle\Entity\Phrase
     */
    public function createNewPhrase(Key $key, Locale $locale, $text = '');

    /**
     * @param StringIdentifier $identifier
     */
    public function findOneByKey(Resource $resource, $identifier);

    public function findOneByHash(Project $project, $hash);

    /**
     * @return \Pagerfanta\Pagerfanta
     */
    public function findSatisfying(TranslationSpecification $specification);

    public function saveKey(Key $key);

    public function removeKey(Key $key);

    public function savePhrase(Phrase $phrase);

    public function removePhrase(Phrase $phrase);
}
