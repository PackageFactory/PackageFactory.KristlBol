<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Shared;

interface ContentInterface
{
    /**
     * @return resource
     */
    public function toStream();
}