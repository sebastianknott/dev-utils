<?php

declare(strict_types=1);

namespace Deployer;

use ComposerLocator;

if (!function_exists('getComposerPackagePath')) {
    function getComposerPackagePath(string $packageName)
    {
        return ComposerLocator::getPath($packageName);
    }
}