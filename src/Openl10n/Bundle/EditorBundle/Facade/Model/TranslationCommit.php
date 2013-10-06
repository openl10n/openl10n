<?php

namespace Openl10n\Bundle\EditorBundle\Facade\Model;

use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Model\TranslationPhraseInterface;
use Openl10n\Bundle\CoreBundle\Model\TranslationKeyInterface;
use Openl10n\Bundle\CoreBundle\Model\DomainInterface;

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
        ProjectInterface $project,
        DomainInterface $domain,
        TranslationKeyInterface $key,
        TranslationPhraseInterface $source,
        TranslationPhraseInterface $target
    )
    {
        $this->id = $key->getHash();
        $this->domain = $domain->getSlug();
        $this->project = $project->getSlug();
        $this->key = $key->getKey();

        $this->sourcePhrase = $source->getText();
        $this->targetPhrase = $target->getText();
        $this->sourceLocale = $source->getLocale()->toString();
        $this->targetLocale = $target->getLocale()->toString();

        $this->isApproved = $target->isApproved();
        $this->isTranslated = !empty($this->targetPhrase);
    }
}
