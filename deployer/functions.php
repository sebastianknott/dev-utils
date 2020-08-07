<?php

declare(strict_types=1);

namespace Deployer;

use SebastianKnott\DevUtils\Deployer\ComposerPackageFinder;

if (!function_exists('getComposerPackagePath')) {

    function getComposerPackagePath(string $packageName)
    {
        $composerPackageFinder = new ComposerPackageFinder();

        return $composerPackageFinder->getPackagePath($packageName);
    }
}