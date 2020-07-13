<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Node;

interface FileInterface extends NodeInterface
{
    public function getContent(): ContentInterface;
}