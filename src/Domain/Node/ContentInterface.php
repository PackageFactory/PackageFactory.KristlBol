<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Node;

interface ContentInterface
{
    /**
     * @return resource
     */
    public function asStream();
}