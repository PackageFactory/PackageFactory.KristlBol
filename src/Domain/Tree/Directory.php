<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Tree;

use PackageFactory\KristlBol\Domain\Configuration\RootDirectory as ConfiguredRootDirectory;

final class Directory
{
    public static function fromConfiguredRootDirectory(
        ConfiguredRootDirectory $configuredRootDirectory
    ): DirectoryInterface {
        $className = $configuredRootDirectory->getImplementationClassName();
        return new $className;
    }
}