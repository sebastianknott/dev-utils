<?php

declare(strict_types=1);

namespace SebastianKnott\DevUtils\Test\Unit\Test\Factory;

use Hamcrest\Matcher;
use Hamcrest\MatcherAssert;
use Hamcrest\Matchers as M;
use Mockery\MockInterface;
use Phake_IMock;
use PHPUnit\Framework\TestCase;
use SebastianKnott\DevUtils\Test\Factory\SystemUnderTestFactory;
use SebastianKnott\DevUtils\Test\Fixture\Test\Factory\SystemUnderTestFactory\ClassWithDependencies;
use SebastianKnott\DevUtils\Test\Fixture\Test\Factory\SystemUnderTestFactory\SimpleClass;
use SebastianKnott\HamcrestObjectAccessor\HasProperty as HP;

class SystemUnderTestFactoryTest extends TestCase
{
    /** @var SystemUnderTestFactory */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new SystemUnderTestFactory();
    }

    public function testBuildSutWithMockeryShouldBuildAnInstanceOfSimpleClass(): void
    {
        $result = $this->subject->buildSutWithMockery(SimpleClass::class);

        self::assertInstanceOf(SimpleClass::class, $result->getSubject());
    }

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
     * @param string $methodNamePart
     * @param string $mockClass
     */
    public function testBuildSutWithMockeryClassWitDeps(string $methodNamePart, string $mockClass): void
    {
        $methodName = 'buildSutWith' . $methodNamePart;
        $result     = $this->subject->$methodName(ClassWithDependencies::class);

        MatcherAssert::assertThat(
            $result,
            M::allOf(
                HP::hasProperty(
                    'subject',
                    M::allOf(
                        M::anInstanceOf(ClassWithDependencies::class),
                        HP::hasProperty(
                            'simpleClass',
                            $this->isSimpleClassMock($mockClass)
                        )
                    )
                )
            )
        );
        MatcherAssert::assertThat(
            $result['simpleClassParameterName'],
            $this->isSimpleClassMock($mockClass)
        );
    }

    /**
     * Returns Matcher to check if something is a SimpleClass and of type mockClass.
     *
     * @param string $mockClass
     *
     * @return mixed
     */
    private function isSimpleClassMock(string $mockClass): Matcher
    {
        return M::allOf(
            M::anInstanceOf(SimpleClass::class),
            M::anInstanceOf($mockClass)
        );
    }
}
