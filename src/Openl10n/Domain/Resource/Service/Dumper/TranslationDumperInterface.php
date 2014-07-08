<?php

namespace Openl10n\Domain\Resource\Service\Dumper;

use Symfony\Component\Translation\MessageCatalogue;

interface TranslationDumperInterface
{
    /**
     * Writes translation from the catalogue according to the selected format.
     *
     * @param MessageCatalogue $catalogue The message catalogue to dump
     * @param string           $directory The directory where to dump the translation files
     * @param string           $format    The format to use to dump the messages, or null to guess with file extension
     *
     * @throws \InvalidArgumentException
     */
    public function dumpMessages(MessageCatalogue $catalogue, $directory, $format);

    /**
     * Obtains the list of supported formats.
     *
     * @return array
     */
    public function getFormats();
}
