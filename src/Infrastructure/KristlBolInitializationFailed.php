<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Infrastructure;

final class KristlBolInitializationFailed extends \RuntimeException
{
    private function __construct(string $message, \Exception $previous = null)
    {
        parent::__construct('Initialization failed '. $message, 0 ,$previous);
    }

    public static function becauseNoSuitableConfigurationFileCouldBeFound(array $triedPaths): self
    {
        return new self(
            sprintf(
                'beacause no suitable configuration could be found. Tried paths:%s',
                PHP_EOL . '    *' . join(PHP_EOL . '    *', $triedPaths)
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
}