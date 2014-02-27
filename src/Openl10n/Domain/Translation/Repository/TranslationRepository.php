<?php

namespace Openl10n\Domain\Translation\Repository;

use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Model\Domain;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Model\Phrase;
use Openl10n\Domain\Translation\Specification\TranslationSpecification;
use Openl10n\Value\Localization\Locale;

interface TranslationRepository
{
    public function createNewKey(Domain $domain, $identifier);

    public function createNewPhrase(Key $key, Locale $locale, $text = '');

    public function findOneByHash(Project $project, $hash);

    public function findSatisfying(TranslationSpecification $specification);

    public function saveKey(Key $key);

    public function savePhrase(Phrase $phrase);
}
