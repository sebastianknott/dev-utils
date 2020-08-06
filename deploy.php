<?php

declare(strict_types=1);

namespace Deployer;

require_once __DIR__ . '/deployer/staticCodeAnalysis.php';
require_once __DIR__ . '/deployer/unitTest.php';

// Project name
set('application', 'sebastianknot/dev-utils');
set('release_path', __DIR__);
set('allow_anonymous_stats', false);

desc('Checks for unsecure packages');
task(
    'security-checker',
    static function () {
        run('vendor/bin/security-checker security:check');
    }
);

desc('Run all checks');
task('check', ['security-checker', 'sca', 'test']);