<?php

namespace spec\Openl10n\Value\String;

use PhpSpec\ObjectBehavior;

class SlugSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('hello-world');
        $this->shouldHaveType('Openl10n\Value\String\Slug');
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
