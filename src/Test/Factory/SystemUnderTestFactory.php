<?php

declare(strict_types=1);

namespace SebastianKnott\DevUtils\Test\Factory;

use Closure;
use Mockery;
use Phake;
use ReflectionClass;

class SystemUnderTestFactory
{
    /**
     * Builds a subject with mocked constructor dependencies with Mockery.
     *
     * @param string $className
     *
     * @return object
     */
    public function buildSutWithMockery(string $className): object
    {
        $buildFunction = static function ($className): object {
            return Mockery::mock($className);
        };

        return $this->generateSubjectByBuildFunction($className, $buildFunction);
    }

    /**
     * Builds a subject with mocked constructor dependencies with Mockery.
     *
     * @param string $className
     *
     * @return object
     */
    public function buildSutWithPhake(string $className): object
    {
        $buildFunction = static function ($className): object {
            return Phake::mock($className);
        };

        return $this->generateSubjectByBuildFunction($className, $buildFunction);
    }

    /**
     * Generates instance of class. Uses buildFunction to generate constructor parameters.
     *
     * @param string  $className
     * @param Closure $buildFunction
     *
     * @return SystemUnderTestBundle
     */
    private function generateSubjectByBuildFunction(string $className, Closure $buildFunction): SystemUnderTestBundle
    {
        $reflection  = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();

        if ($constructor !== null) {
            $parameters = $constructor->getParameters();
        }

        $parametersInstancesWithName = [];
        $parametersInstances         = [];
        foreach ($parameters ?? [] as $parameter) {
            $parameterClass  = $parameter->getClass();
            $parameterName   = $parameter->getName();
            $mockedParameter = $buildFunction($parameterClass->getName());

            $parametersInstancesWithName[$parameterName] = $mockedParameter;
            $parametersInstances[]                       = $mockedParameter;
        }

        $systemUnderTestSubject = new $className(...$parametersInstances);

        return new SystemUnderTestBundle(
            $systemUnderTestSubject,
            $parametersInstancesWithName ?? []
        );
    }
}
