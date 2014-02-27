<?php

namespace spec\Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Application\Action\ExportTranslationFileAction;
use Openl10n\Domain\Translation\Repository\DomainRepository;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Openl10n\Domain\Translation\Service\Dumper\TranslationDumperInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ExportTranslationFileProcessorSpec extends ObjectBehavior
{
    function let(
        DomainRepository $domainRepository,
        TranslationRepository $translationRepository,
        TranslationDumperInterface $translationDumper,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->beConstructedWith($domainRepository, $translationRepository, $translationDumper, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\Translation\Application\Processor\ExportTranslationFileProcessor');
    }

    // function it_can_export_translations(
    //     DomainRepository $domainRepository,
    //     TranslationRepository $translationRepository,
    //     TranslationDumperInterface $translationDumper,
    //     Project $project,
    //     ExportTranslationFileAction $action
    // )
    // {
    // }
}
