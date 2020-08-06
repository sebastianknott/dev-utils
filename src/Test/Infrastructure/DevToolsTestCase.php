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
    /**
     * A ready made faker instance for your unit tests.
     *
     * @var Generator
     */
    public static $faker;

    /**
     * An instance of my subject factory for easy sut creation and mocking.
     *
     * @var SystemUnderTestFactory
     */
    public static $factory;

    /**
     * This method will instantiate the factory and faker. Father more the global functions of hamcrest and mockery
     * will be loaded.
     */
    public static function setUpBeforeClass(): void
    {
        self::$factory = new SystemUnderTestFactory();

        self::$faker = Factory::create('de_DE');
        self::$faker->seed(9876543255);

        include_once ComposerLocator::getPath('hamcrest/hamcrest-php') . '/hamcrest/Hamcrest.php';
        include_once ComposerLocator::getPath('sebastianknott/hamcrest-object-accessor') . '/src/functions.php';
        include_once ComposerLocator::getPath('mockery/mockery') . '/library/helpers.php';
    }

    /**
     * Necessary tearDown functionality for Mockery.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
