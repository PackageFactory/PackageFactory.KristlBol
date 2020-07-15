<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Logger;

use PackageFactory\KristlBol\Domain\Configuration\Logger as ConfiguredLogger;
use Psr\Log\LoggerInterface;

final class Logger
{
    public static function fromConfiguredLogger(ConfiguredLogger $configuredLogger): LoggerInterface
    {
        $className = $configuredLogger->getImplementationClassName();

        if (method_exists($className, 'fromOptions')) {
            return $className::fromOptions($configuredLogger->getOptions());
        } else {
            return new $className;
        }
    }
}