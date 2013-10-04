<?php

namespace Openl10n\Bundle\CoreBundle\Model;

interface LanguageInterface
{
    public function getProject();
    public function getLocale();
}
