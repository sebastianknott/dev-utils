<?php

declare(strict_types=1);

namespace SebastianKnott\DevUtils\Deployer;

use ComposerLocator;

class ComposerPackageFinder
{
    public function getPackagePath(string $package): string
    {
        return ComposerLocator::getPath($package) ?? ComposerLocator::getRootPath();
    }
}
