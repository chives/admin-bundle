<?php

namespace spec\FSi\Bundle\AdminBundle\Display\Property\Formatter;

use FSi\Bundle\AdminBundle\Display\Property\ValueFormatter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CollectionSpec extends ObjectBehavior
{
    function let(ValueFormatter $formatter)
    {
        $this->beConstructedWith([$formatter]);
    }

    function it_ignore_empty_values()
    {
        $this->format(0)->shouldReturn(0);
        $this->format(null)->shouldReturn(null);
        $this->format([])->shouldReturn([]);
    }

    function it_throw_exception_when_value_is_not_an_array()
    {
        $this->shouldThrow(
            new \InvalidArgumentException('Collection formatter requires value to be iterable, stdClass given')
        )->during('format', [new \stdClass()]);
    }

    function it_format_each_element_of_collection_using_formatters(ValueFormatter $formatter)
    {
        $value = [
            'first-date' => new \DateTime(),
            'second-date' => new \DateTime()
        ];
        $formatter->format(Argument::any())->will(function($argument) {return $argument[0];});
        $this->format($value)->shouldReturn($value);
    }

    function it_format_each_element_of_iterator_using_formatters(ValueFormatter $formatter)
    {
        $value = [
            'first-date' => new \DateTime(),
            'second-date' => new \DateTime()
        ];
        $formatter->format(Argument::any())->will(function($argument) {return $argument[0];});
        $this->format(new \ArrayIterator($value))->shouldReturn($value);
    }
}
