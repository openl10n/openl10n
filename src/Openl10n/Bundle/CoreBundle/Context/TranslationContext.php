<?php

namespace Openl10n\Bundle\CoreBundle\Context;

use Openl10n\Bundle\CoreBundle\Object\Locale;

class TranslationContext
{
    protected $source;
    protected $target;

    public function __construct(Locale $source, Locale $target)
    {
        $this->source = $source;
        $this->target = $target;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getTarget()
    {
        return $this->target;
    }
}
