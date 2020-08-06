<?php

declare(strict_types=1);

namespace SebastianKnott\DevUtils\Test\Factory;

use ArrayObject;

class SystemUnderTestBundle extends ArrayObject
{
    /** @var object */
    private $subject;

    public function __construct(object $subject, array $parameters)
    {
        parent::__construct($parameters);
        $this->subject = $subject;
    }

    public function getSubject(): object
    {
        return $this->subject;
    }
}
