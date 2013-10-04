<?php

namespace Openl10n\Bundle\CoreBundle\Resolver;

use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Storage\TranslationContextStorage;
use Openl10n\Bundle\CoreBundle\Context\TranslationContext;
use Symfony\Component\HttpFoundation\Request;

class TranslationContextResolver
{
    protected $request;
    protected $storage;

    public function __construct(TranslationContextStorage $storage)
    {
        $this->storage = $storage;
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    public function resolveContext(ProjectInterface $project, Locale $target = null, Locale $source = null)
    {
        if (null === $source || !$project->hasLocale($source)) {
            $source = $this->findAppropriateSourceLocale($project);
        }

        if (null === $target || !$project->hasLocale($target)) {
            $target = $this->findAppropriateTargetLocale($project);
        }

        return new TranslationContext($source, $target);
    }

    protected function findAppropriateSourceLocale(ProjectInterface $project)
    {
        $context = $this->storage->get($project);
        if (null === $context) {
            return $project->getDefaultLocale();;
        }

        $source = $context->getSource();
        if (!$project->hasLocale($source)) {
            return $project->getDefaultLocale();
        }

        return $source;
    }

    protected function findAppropriateTargetLocale(ProjectInterface $project)
    {
        $context = $this->storage->get($project);

        if (null !== $context) {
            $target = $context->getTarget();

            if ($project->hasLocale($target)) {
                return $target;
            }
        }

        // Get request locale
        $locale = new Locale($this->request->getLocale());
        if ($project->hasLocale($locale)) {
            return $locale;
        }

        return $project->getDefaultLocale();;
    }
}
