<?php

namespace spec\Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Application\Action\ImportTranslationFileAction;
use Openl10n\Domain\Translation\Repository\DomainRepository;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Openl10n\Domain\Translation\Service\Loader\TranslationLoaderInterface;
use Openl10n\Domain\Translation\Service\Uploader\FileUploaderInterface;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Slug;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportTranslationFileProcessorSpec extends ObjectBehavior
{
    function let(
        DomainRepository $domainRepository,
        TranslationRepository $translationRepository,
        FileUploaderInterface $fileUploader,
        TranslationLoaderInterface $translationLoader,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->beConstructedWith(
            $domainRepository,
            $translationRepository,
            $fileUploader,
            $translationLoader,
            $eventDispatcher
        );

        $this->shouldHaveType('Openl10n\Domain\Translation\Application\Processor\ImportTranslationFileProcessor');
    }

    function it_can_import_translation_file(
        DomainRepository $domainRepository,
        TranslationRepository $translationRepository,
        FileUploaderInterface $fileUploader,
        TranslationLoaderInterface $translationLoader,
        EventDispatcherInterface $eventDispatcher,
        Project $project,
        UploadedFile $uploadedFile,
        ImportTranslationFileAction $action
    )
    {
        //$action->getProject()->willReturn($project);
        //$action->getLocale()->willReturn('en_GB');
        //$action->getDomain()->willReturn('foobar');
        //$action->getFile()->willReturn($uploadedFile);

        //$this->execute($action);
    }
}
