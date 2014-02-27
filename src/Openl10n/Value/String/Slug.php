<?php

namespace Openl10n\Value\String;

/**
 * Slug value object.
 */
class Slug
{
    const REGEX = '/^[a-zA-Z0-9\-\.\_]+$/';

    /**
     * @var string
     */
    protected $slug;

    /**
     * Build a slug object with a valid string.
     *
     * @param string $slug The slug string representation
     */
    public function __construct($slug)
    {
        if (!preg_match(self::REGEX, $slug)) {
            throw new \InvalidArgumentException(sprintf(
                'The given slug (%s) should only contains alphanumeric chars, '.
                'dots, hyphens or underscores',
                $slug
            ));
        }

        $this->slug = $slug;
    }

    /**
     * String representation of the slug.
     *
     * @return string Representation of the slug
     */
    public function toString()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->toString();
    }
}
