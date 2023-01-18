<?php

declare(strict_types=1);

namespace Deployer;

require_once __DIR__ . '/deployer/staticCodeAnalysis.php';
require_once __DIR__ . '/deployer/unitTest.php';

// Project name
set('application', 'sebastianknot/dev-utils');
set('release_path', __DIR__);
set('allow_anonymous_stats', false);

desc('Run all checks');
task('check', ['sca', 'test']);

desc('Runs checks usable by CI');
task('ci', ['sca', 'test']);