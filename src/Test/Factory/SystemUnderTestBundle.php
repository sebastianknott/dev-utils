<?php

declare(strict_types=1);

namespace SebastianKnott\DevUtils\Test\Factory;

use ArrayObject;
use Mockery\MockInterface;

/**
 * @psalm-suppress MissingTemplateParam
 */
class SystemUnderTestBundle extends ArrayObject
{
    /**
     * @param array<string,MockInterface>  $parameters
     */
    public function __construct(private readonly object $subject, array $parameters)
    {
        parent::__construct($parameters);
    }

    public function getSubject(): object
    {
        return $this->subject;
    }
}
