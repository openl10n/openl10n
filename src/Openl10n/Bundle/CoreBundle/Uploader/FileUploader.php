<?php

namespace Openl10n\Bundle\CoreBundle\Uploader;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader implements FileUploaderInterface
{
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function upload(UploadedFile $file)
    {
        $tempname = mt_rand(0, 9999999).'_'.$file->getClientOriginalName();

        return $file->move(sys_get_temp_dir(), $tempname);
    }

    public function remove(File $file)
    {
        $this->filesystem->remove($file->getPathname());
    }
}
