<?php

namespace spec\Openl10n\Domain\Translation\Application\Processor;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateResourceProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\Translation\Application\Processor\CreateResourceProcessor');
    }
}
