<?php

namespace Openl10n\Bundle\CoreBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Openl10n\Bundle\CoreBundle\Object\Locale;

/**
 * TranslationKey default implementation
 */
class TranslationKey implements TranslationKeyInterface
{
    /**
     * @var DomainInterface
     */
    protected $domain;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var ArrayCollection
     */
    protected $phrases;

    /**
     * Constructor.
     *
     * @param DomainInterface $domain The translation domain
     * @param string          $key    The translation key identifier
     */
    public function __construct(DomainInterface $domain, $key)
    {
        $this->domain = $domain;
        $this->key = $key;

        // Default attributes
        $this->hash = sha1($domain->getSlug().'#'.$key);
        $this->phrases = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhrases()
    {
        return $this->phrases;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhrase(Locale $locale)
    {
        foreach ($this->phrases as $phrase) {
            if (0 === strcmp($locale, $phrase->getLocale())) {
                return $phrase;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getKey();
    }
}
