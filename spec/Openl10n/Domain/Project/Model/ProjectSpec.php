<?php

namespace spec\Openl10n\Domain\Project\Model;

use Openl10n\Value\String\Slug;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProjectSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new Slug('foobar'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\Project\Model\Project');
    }
}
