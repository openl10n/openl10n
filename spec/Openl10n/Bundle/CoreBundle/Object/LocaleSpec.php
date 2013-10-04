<?php

namespace spec\Openl10n\Bundle\CoreBundle\Object;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LocaleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('en_GB');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Bundle\CoreBundle\Object\Locale');
    }

    function it_should_have_string_representation()
    {
        $this->__toString()->shouldReturn('en_GB');
    }

    function it_should_return_language_code()
    {
        $this->getPrimaryLanguage()->shouldReturn('en');
    }

    function it_should_return_region_code()
    {
        $this->getRegion()->shouldReturn('GB');
    }

    function it_should_return_display_name()
    {
        $this->getDisplayName('en')->shouldReturn('English (United Kingdom)');
        $this->getDisplayName('fr')->shouldReturn('anglais (Royaume-Uni)');
    }
}
