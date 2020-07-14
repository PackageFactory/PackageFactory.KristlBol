<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Configuration;

use PackageFactory\KristlBol\Domain\Node\DirectoryInterface;
use PackageFactory\KristlBol\Domain\Target\TargetInterface;
use Psr\Log\LoggerInterface;

final class ConfigurationIsInvalid extends \DomainException
{
    public static function becauseNoBatchesAreConfigured(): self
    {
        return new self('@TODO: Mising batch configuration!');
    }

    public static function becauseNoRootDirectoryImplementationWasSpecifiedInBatch(): self
    {
        return new self('@TODO: Mising root directory implementation!');
    }

    public static function becauseRootDirectoryDoesNotReferenceAnImplementationOfDirectoryInterface(string $value): self
    {
        return new self(
            sprintf(
                'Configured root directory "%s" does not implement "%s".',
                $value,
                DirectoryInterface::class
            )
        );
    }

    public static function becauseTargetDoesNotReferenceAnImplementationOfTargetInterface(string $value): self
    {
        return new self(
            sprintf(
                'Configured target "%s" does not implement "%s".',
                $value,
                TargetInterface::class
            )
        );
    }

    public static function becauseLoggerDoesNotReferenceAnImplementationOfLoggerInterface(string $value): self
    {
        return new self(
            sprintf(
                'Configured logger "%s" does not implement "%s".',
                $value,
                LoggerInterface::class
            )
        );
    }
}