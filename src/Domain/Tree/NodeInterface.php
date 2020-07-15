<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Tree;

use PackageFactory\KristlBol\Domain\Shared\Path;

interface NodeInterface
{
    public function getPath(): Path;
}