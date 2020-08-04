<?php

declare(strict_types=1);

namespace SebastianKnott\DevUtils\Test\Unit\Test\Factory;

use Mockery\MockInterface;
use SebastianKnott\DevUtils\Test\Factory\SystemUnderTestBundle;
use SebastianKnott\DevUtils\Test\Infrastructure\DevToolsTestCase;
use stdClass;

class SystemUnderTestBundleTest extends DevToolsTestCase
{
    /** @var MockInterface|stdClass */
    private $mockedSubjectUnderTest;

    /** @var SystemUnderTestBundle */
    private $subject;

    /** @var MockInterface|stdClass */
    private $mockedParameter1;

    /** @var MockInterface|stdClass */
    private $mockedParameter2;

    public function setUp(): void
    {
        $this->mockedSubjectUnderTest = mock(stdClass::class);
        $this->mockedParameter1       = mock(stdClass::class);
        $this->mockedParameter2       = mock(stdClass::class);
        $mockedParameters             = [
            'firstParameter'  => $this->mockedParameter1,
            'secondParameter' => $this->mockedParameter2,
        ];

        $this->subject = new SystemUnderTestBundle($this->mockedSubjectUnderTest, $mockedParameters);
    }

    public function testConstructionOfObject(): void
    {
        $subject   = new stdClass();
        $parameter = self::$faker->word;
        new SystemUnderTestBundle($subject, ['name' => $parameter]);
    }

    public function testGetSubject(): void
    {
        $result = $this->subject->getSubject();

        self::assertSame($this->mockedSubjectUnderTest, $result);
    }

    public function testGetParameterByName(): void
    {
        $result1 = $this->subject['firstParameter'];
        $result2 = $this->subject['secondParameter'];

        self::assertSame($this->mockedParameter1, $result1);
        self::assertSame($this->mockedParameter2, $result2);
    }
}
