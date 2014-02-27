<?php

namespace Openl10n\Bundle\EditorBundle\Facade\Model;

use Openl10n\Bundle\InfraBundle\Model\ProjectInterface;
use Openl10n\Domain\Translation\Model\Phrase;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Model\Domain;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Bundle\InfraBundle\Model\TranslationPhraseInterface;
use Openl10n\Bundle\InfraBundle\Model\TranslationKeyInterface;
use Openl10n\Bundle\InfraBundle\Model\DomainInterface;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class TranslationCommit
{
    /**
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Type("string")
     */
    public $id;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Type("string")
     */
    public $domain;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Type("string")
     */
    public $project;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Type("string")
     */
    public $key;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Type("string")
     */
    public $sourcePhrase;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Type("string")
     */
    public $sourceLocale;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Type("string")
     */
    public $targetPhrase;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Type("string")
     */
    public $targetLocale;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Type("boolean")
     */
    public $isApproved;

    /**
     * @Serializer\Expose
     * @Serializer\Groups({"list", "details"})
     * @Serializer\Type("boolean")
     */
    public $isTranslated;

    public function __construct(
        Project $project,
        Domain $domain,
        Key $key,
        Phrase $source,
        Phrase $target
    )
    {
        $this->id = $key->getHash();
        $this->domain = $domain->getSlug();
        $this->project = $project->getSlug();
        $this->key = $key->getIdentifier();

        $this->sourcePhrase = $source->getText();
        $this->targetPhrase = $target->getText();
        $this->sourceLocale = (string) $source->getLocale();
        $this->targetLocale = (string) $target->getLocale();

        $this->isApproved = $target->isApproved();
        $this->isTranslated = !empty($this->targetPhrase);
    }
}
