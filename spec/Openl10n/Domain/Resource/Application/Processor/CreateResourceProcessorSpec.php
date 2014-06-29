<?php

namespace spec\Openl10n\Domain\Resource\Application\Processor;

use Openl10n\Domain\Resource\Repository\ResourceRepository;
use Openl10n\Domain\Resource\Service\Loader\TranslationLoaderInterface;
use Openl10n\Domain\Resource\Service\Uploader\FileUploaderInterface;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateResourceProcessorSpec extends ObjectBehavior
{
    public function let(
        ResourceRepository $resourceRepository,
        TranslationRepository $translationRepository,
        FileUploaderInterface $fileUploader,
        TranslationLoaderInterface $translationLoader,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->beConstructedWith(
            $resourceRepository,
            $translationRepository,
            $fileUploader,
            $translationLoader,
            $eventDispatcher
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\Resource\Application\Processor\CreateResourceProcessor');
    }
}
