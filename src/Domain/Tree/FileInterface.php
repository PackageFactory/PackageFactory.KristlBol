<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Tree;

use PackageFactory\KristlBol\Domain\Shared\ContentInterface;

interface FileInterface extends NodeInterface
{
    public function findContent(): ContentInterface;
}