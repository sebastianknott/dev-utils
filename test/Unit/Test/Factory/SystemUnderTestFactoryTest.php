<?php

declare(strict_types=1);

namespace SebastianKnott\DevUtils\Test\Unit\Test\Factory;

use Hamcrest\Matcher;
use Mockery\MockInterface;
use Phake_IMock;
use SebastianKnott\DevUtils\Test\Factory\SystemUnderTestFactory;
use SebastianKnott\DevUtils\Test\Fixture\Test\Factory\SystemUnderTestFactory\ClassWithDependencies;
use SebastianKnott\DevUtils\Test\Fixture\Test\Factory\SystemUnderTestFactory\SimpleClass;
use SebastianKnott\DevUtils\Test\Infrastructure\DevToolsTestCase;

class SystemUnderTestFactoryTest extends DevToolsTestCase
{
    private SystemUnderTestFactory $subject;

    public function setUp(): void
    {
        $this->subject = new SystemUnderTestFactory();
    }

    public function testBuildSutWithMockeryShouldBuildAnInstanceOfSimpleClass(): void
    {
        $result = $this->subject->buildSutWithMockery(SimpleClass::class);

        self::assertInstanceOf(SimpleClass::class, $result->getSubject());
    }

    /**
     * @return array<string,array<string,string>>
     */
    public function testBuildSutWithMockeryClassWitDepsDataProvider(): array
    {
        return [
            'Mockery' => [
                'methodNamePart' => 'Mockery',
                'mockClass'      => MockInterface::class,
            ],
            'Phake'   => [
                'methodNamePart' => 'Phake',
                'mockClass'      => Phake_IMock::class,
            ],
        ];
    }

    /**
     * @dataProvider testBuildSutWithMockeryClassWitDepsDataProvider
     *
     */
    public function testBuildSutWithMockeryClassWitDeps(string $methodNamePart, string $mockClass): void
    {
        $methodName = 'buildSutWith' . $methodNamePart;
        $result     = $this->subject->$methodName(ClassWithDependencies::class);

        assertThat(
            $result,
            allOf(
                hasProperty(
                    'subject',
                    allOf(
                        anInstanceOf(ClassWithDependencies::class),
                        hasProperty(
                            'simpleClass',
                            $this->isSimpleClassMock($mockClass)
                        )
                    )
                )
            )
        );
        assertThat(
            $result['simpleClassParameterName'],
            $this->isSimpleClassMock($mockClass)
        );
    }

    /**
     * Returns Matcher to check if something is a SimpleClass and of type mockClass.
     *
     *
     */
    private function isSimpleClassMock(string $mockClass): Matcher
    {
        return allOf(
            anInstanceOf(SimpleClass::class),
            anInstanceOf($mockClass)
        );
    }
}
