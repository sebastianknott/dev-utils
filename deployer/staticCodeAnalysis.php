<?php

declare(strict_types=1);

namespace Deployer;

// Static Code Analysis

desc('Check for syntax errors');
task(
    'sca:lint',
    static function () {
        run('vendor/bin/parallel-lint -e php --blame --exclude vendor .');
    }
);

desc('Check for messy code');
task(
    'sca:phpmd',
    static function () {
        run('vendor/bin/phpmd src text ./config/phpmd/phpmd.xml');
        run('vendor/bin/phpmd test text ./config/phpmd/phpmd.xml');
    }
);

desc('Check for copy/paste violations');
task(
    'sca:phpcpd',
    static function () {
        run('vendor/bin/phpcpd src');
    }
);

desc('Check for code style');
task(
    'sca:phpcs',
    static function () {
        run('vendor/bin/phpcs --parallel=4 --standard=SebastianKnott src test');
    }
);

desc('Fix code quality as good as possible');
task(
    'sca:phpcs:fix',
    static function () {
        run(
            'vendor/bin/phpcbf --parallel=4 --standard=SebastianKnott src test;
        exitCode=$?;
         if [ $exitCode -eq 1 ]; then 
            exit 0
         else
            exit $exitCode
         fi'
        );
    }
);
fail('sca:phpcs', 'sca:phpcs:fix');

desc('Check for messy code with phpstan');
task(
    'sca:phpstan',
    static function () {
        run('vendor/bin/phpstan analyse --configuration=config/phpstan/phpstan.neon src test');
    }
);

desc('Check for messy code with vimeos psalm');
task(
    'sca:psalm',
    static function () {
        run('vendor/bin/psalm -c config/psalm/psalm.xml ');
    }
);

desc('Check code quality');
task(
    'sca',
    ['sca:lint', 'sca:phpcs', 'sca:phpstan', 'sca:psalm', 'sca:phpmd', 'sca:phpcpd']
)->once();
