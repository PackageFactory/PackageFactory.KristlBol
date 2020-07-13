<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Node;

interface NodeInterface
{
    public function getPath(): Path;
}