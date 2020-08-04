<?php

declare(strict_types=1);

namespace SebastianKnott\DevUtils\Test\Infrastructure;

use ComposerLocator;
use Faker\Factory;
use Faker\Generator;
use Mockery;
use PHPUnit\Framework\TestCase;
use SebastianKnott\DevUtils\Test\Factory\SystemUnderTestFactory;

class DevToolsTestCase extends TestCase
{
    /** @var Generator */
    public static $faker;

    /** @var SystemUnderTestFactory */
    public static $factory;

    public static function setUpBeforeClass(): void
    {
        self::$factory = new SystemUnderTestFactory();

        self::$faker = Factory::create('de_DE');
        self::$faker->seed(9876543255);

        require_once ComposerLocator::getPath('hamcrest/hamcrest-php') . '/hamcrest/Hamcrest.php';
        require_once ComposerLocator::getPath('sebastianknott/hamcrest-object-accessor') . '/src/functions.php';
        require_once ComposerLocator::getPath('mockery/mockery') . '/library/helpers.php';
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
