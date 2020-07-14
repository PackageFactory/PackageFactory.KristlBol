<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target\Command;

use PackageFactory\KristlBol\Domain\Node\ContentInterface;

final class Generate
{
    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }
}