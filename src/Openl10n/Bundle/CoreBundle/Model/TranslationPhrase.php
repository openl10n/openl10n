<?php

namespace Openl10n\Bundle\CoreBundle\Model;

use Openl10n\Bundle\CoreBundle\Object\Locale;

/**
 * Translation default implementation.
 */
class TranslationPhrase implements TranslationPhraseInterface
{
    /**
     * @var TranslationKey
     */
    protected $key;

    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var boolean
     */
    protected $isApproved;

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * Constructor.
     *
     * @param TranslationKey $key    The translation key
     * @param Locale         $locale The locale of the text
     * @param string         $text   The text
     */
    public function __construct(TranslationKey $key, Locale $locale, $text = '')
    {
        $this->key = $key;
        $this->locale = $locale;
        $this->text = $text;

        // Default attributes
        $this->isApproved = false;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function setText($text)
    {
        $this->text = $text;
        $this->isApproved = false;
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setApproved($isApproved)
    {
        $this->isApproved = $isApproved;
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isApproved()
    {
        return $this->isApproved;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getLocale().':'.$this->getText();
    }
}
