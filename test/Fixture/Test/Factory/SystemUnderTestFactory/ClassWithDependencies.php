<?php

declare(strict_types=1);

namespace SebastianKnott\DevUtils\Test\Fixture\Test\Factory\SystemUnderTestFactory;

class ClassWithDependencies
{
    /** @var SimpleClass */
    private $simpleClass;

    /**
     * ClassWithDependencies constructor.
     *
     * @param SimpleClass $simpleClassParameterName
     */
    public function __construct(SimpleClass $simpleClassParameterName)
    {
        $this->simpleClass = $simpleClassParameterName;
    }

    /**
     * @return SimpleClass
     */
    public function getSimpleClass(): SimpleClass
    {
        return $this->simpleClass;
    }
}
