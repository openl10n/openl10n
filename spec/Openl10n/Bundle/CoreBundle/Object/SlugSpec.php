<?php

namespace spec\Openl10n\Bundle\CoreBundle\Object;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SlugSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('hello-world');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Bundle\CoreBundle\Object\Slug');
    }

    function it_should_be_constructed_with_a_valid_slug()
    {
        $this->shouldThrow('\InvalidArgumentException')->during('__construct', array('inv@lide~slug!'));
    }

    function it_should_have_string_representation()
    {
        $this->__toString()->shouldReturn('hello-world');
    }
}
