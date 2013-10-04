<?php

namespace Openl10n\Bundle\CoreBundle\Storage;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Openl10n\Bundle\CoreBundle\Context\TranslationContext;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;

class TranslationContextStorage
{
    const SESSION_PREFIX = 'openl10n.translation_context.';

    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function set(ProjectInterface $project, TranslationContext $context)
    {
        $this->session->set(self::SESSION_PREFIX.$project->getSlug(), $context);
    }

    public function get(ProjectInterface $project)
    {
        return $this->session->get(self::SESSION_PREFIX.$project->getSlug());
    }
}
