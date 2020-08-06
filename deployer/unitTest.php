<?php

declare(strict_types=1);

namespace Deployer;

// Tests

desc('Runs phpunit tests');
task(
    'test:phpunit',
    static function () {
        run('vendor/bin/phpunit');
        run('vendor/bin/coverage-check tmp/phpunit/clover.xml 100');
    }
)->once();

desc('Runs infections for phpunit');
task(
    'test:infection',
    static function () {
        run(
            'vendor/bin/infection --threads=4 --min-covered-msi=100 --no-progress '
            . '--only-covered --coverage=tmp/phpunit --show-mutations'
        );
        run('rm -r ./tmp/phpunit');
    }
)->once();
before('test:infection', 'test:phpunit');

desc('Run automatic test suit');
task('test', ['test:infection'])->once();