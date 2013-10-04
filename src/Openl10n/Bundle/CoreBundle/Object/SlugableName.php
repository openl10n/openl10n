<?php

namespace Openl10n\Bundle\CoreBundle\Object;

class SlugableName extends Name
{
    /**
     * @param Slug $slug
     */
    public function __construct(Slug $slug)
    {
        parent::__construct(ucfirst($slug->toString()));
    }
}
