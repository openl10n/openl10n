<?php

namespace Openl10n\Domain\Resource\Service\Loader;

use Symfony\Component\Translation\Loader\LoaderInterface;

class TranslationLoader implements TranslationLoaderInterface
{
    /**
     * Loaders used for import.
     *
     * @var array
     */
    private $loaders = array();

    /**
     * Adds a loader to the translation extractor.
     *
     * @param string          $format The format of the loader
     * @param LoaderInterface $loader
     */
    public function addLoader($format, LoaderInterface $loader)
    {
        $this->loaders[$format] = $loader;
    }

    /**
     * {@inheritdoc}
     */
    public function loadMessages(\SplFileInfo $file, $locale, $domain, $format = null)
    {
        $format = $format ?: $file->getExtension();

        if (!isset($this->loaders[$format])) {
            throw new \InvalidArgumentException(sprintf(
                'Unable to import file %s: '.
                'there is no loader associated with format "%s".',
                $file->getFilename(),
                $format
            ));
        }

        return $this->loaders[$format]->load($file->getPathname(), $locale, $domain);
    }
}
