<?php

namespace Openl10n\Bundle\CoreBundle\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

interface FileUploaderInterface
{
    public function upload(UploadedFile $file);
    public function remove(File $file);
}
