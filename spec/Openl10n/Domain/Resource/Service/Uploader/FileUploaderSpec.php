<?php

namespace spec\Openl10n\Domain\Resource\Service\Uploader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\Resource\Service\Uploader\FileUploader');
    }

    // function it_can_move_uploaded_file(UploadedFile $file)
    // {
    //     // https://github.com/phpspec/prophecy/issues/58
    //     $file->move(
    //        Argument::type('string'),
    //        Argument::type('string')
    //     )->shouldBeCalled();

    //     $this->upload($file);
    // }

    function it_can_remove_file(Filesystem $filesystem, File $file)
    {
        $file->getPathname()->willReturn('/path/to/file');
        $filesystem->remove('/path/to/file')->shouldBeCalled();

        $this->remove($file);
    }
}
