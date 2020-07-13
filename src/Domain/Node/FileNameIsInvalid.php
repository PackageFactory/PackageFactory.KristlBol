<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Node;

final class FileNameIsInvalid extends \DomainException
{
    public static function becauseItIsEmpty(): self
    {
        return new self('@TODO: empty');
    }

    public static function becauseItContainsSlashes(string $value): self
    {
        return new self('@TODO: leading slash');
    }

    public static function becauseItIsNotAValidUrlPath(string $value): self
    {
        return new self('@TODO: invalid url path');
    }
}

