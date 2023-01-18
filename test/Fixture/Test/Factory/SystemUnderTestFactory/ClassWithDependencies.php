<?php

declare(strict_types=1);

namespace SebastianKnott\DevUtils\Test\Fixture\Test\Factory\SystemUnderTestFactory;

class ClassWithDependencies
{
    private SimpleClass $simpleClass;

    /**
     * ClassWithDependencies constructor.
     *
     */
    public function __construct(SimpleClass $simpleClassParameterName)
    {
        $this->simpleClass = $simpleClassParameterName;
    }

    public function getSimpleClass(): SimpleClass
    {
        return $this->simpleClass;
    }
}
