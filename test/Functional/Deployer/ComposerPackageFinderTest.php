<?php

declare(strict_types=1);

namespace SebastianKnott\DevUtils\Test\Functional\Deployer;

use ComposerLocator;
use SebastianKnott\DevUtils\Deployer\ComposerPackageFinder;
use SebastianKnott\DevUtils\Test\Infrastructure\DevToolsTestCase;

class ComposerPackageFinderTest extends DevToolsTestCase
{
    /** @var ComposerPackageFinder */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new ComposerPackageFinder();
    }

    public function testGetPackagePathForRootPackge(): void
    {
        $expectedPath = dirname(__DIR__, 3);
        $result       = $this->subject->getPackagePath('sebastianknott/dev-utils');
        self::assertSame($expectedPath, $result);
    }

    public function testGetPackagePathForSomeLibrary(): void
    {
        $foregedPackage = 'phpunit/phpunit';
        $expectedPath   = ComposerLocator::getPath($foregedPackage);
        $result         = $this->subject->getPackagePath($foregedPackage);
        self::assertSame($expectedPath, $result);
    }
}
