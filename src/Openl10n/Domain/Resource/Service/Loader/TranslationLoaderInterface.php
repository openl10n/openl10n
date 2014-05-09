<?php

namespace Openl10n\Domain\Resource\Service\Loader;

interface TranslationLoaderInterface
{
    /**
     * Import a translation file.
     *
     * @param \SplFileInfo $file   File containing the translations
     * @param string       $locale The locale of the translations
     * @param string       $domain The domain of the translations
     * @param string|null  $format The format of the file, or null to guess with file extension
     *
     * @return MessageCatalogue The catalogue with the translations
     */
    public function loadMessages(\SplFileInfo $file, $locale, $domain, $format = null);
}
