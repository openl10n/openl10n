<?php

namespace Openl10n\Bundle\CoreBundle\Translation;

use Symfony\Component\Translation\Dumper\DumperInterface;
use Symfony\Component\Translation\Dumper\FileDumper;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Translation\MessageCatalogue;

class TranslationDumper implements TranslationDumperInterface
{
    /**
     * Dumpers used for export.
     *
     * @var array
     */
    private $dumpers = array();

    /**
     * Adds a dumper to the writer.
     *
     * @param string          $format The format of the dumper
     * @param DumperInterface $dumper The dumper
     */
    public function addDumper($format, DumperInterface $dumper)
    {
        // Ignore dumper which are not filedumper
        if (!$dumper instanceof FileDumper) {
            return;
        }

        $this->dumpers[$format] = $dumper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormats()
    {
        return array_keys($this->dumpers);
    }

    /**
     * {@inheritdoc}
     */
    public function dumpMessages(MessageCatalogue $catalogue, $directory , $format = null)
    {
        $format = $format ?: $file->getExtension();

        if (!isset($this->dumpers[$format])) {
            throw new \InvalidArgumentException(sprintf(
                'Unable to export into file %s: '.
                'there is no dumper associated with format "%s".',
                $file->getPathname(),
                $format
            ));
        }

        // Make sur directory exists
        if (!is_dir($directory)) {
            $fs = new Filesystem();
            $fs->mkdir($directory);
        }

        // The file where the catalogue
        $this->dumpers[$format]->dump($catalogue, array('path' => $directory));
    }
}
