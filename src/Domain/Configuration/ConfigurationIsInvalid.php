<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Configuration;

use PackageFactory\KristlBol\Domain\Node\DirectoryInterface;
use PackageFactory\KristlBol\Domain\Target\TargetInterface;
use Psr\Log\LoggerInterface;

final class ConfigurationIsInvalid extends \DomainException
{
    private function __construct(string $message, \Exception $previous = null)
    {
        parent::__construct('Configuration is invalid '. $message, 0 ,$previous);
    }

    public static function becauseNoSuitableConfigurationFileCouldBeFound(array $triedPaths): self
    {
        return new self(
            sprintf(
                'beacause no suitable configuration could be found. Tried paths:%s',
                PHP_EOL . '    * ' . join(PHP_EOL . '    * ', $triedPaths)
            )
        );
    }

    public static function becauseOfAnUnderlyingException(\Exception $e): self
    {
        return new self(
            sprintf(
                'because an underlying exception occurred: %s',
                $e->getMessage()
            ),
            $e
        );
    }

    public static function becauseNoBatchesAreConfigured(): self
    {
        return new self('@TODO: Mising batch configuration!');
    }

    public static function becauseRequiredBatchIsNotConfigured(string $batchName): self
    {
        return new self('@TODO: Batch "' . $batchName . '" is not configured!');
    }

    public static function becauseNoRootDirectoryImplementationWasSpecifiedInBatch(): self
    {
        return new self('@TODO: root directory implementation not configured!');
    }

    public static function becauseRootDirectoryImplementationDoesNotExist(): self
    {
        return new self('@TODO: root directory implementation does not exist!');
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

    public static function becauseTargetImplementationDoesNotExist(): self
    {
        return new self('@TODO: target implementation does not exist!');
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

    public static function becauseLoggerImplementationDoesNotExist(): self
    {
        return new self('@TODO: logger implementation does not exist!');
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