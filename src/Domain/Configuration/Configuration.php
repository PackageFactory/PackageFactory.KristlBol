<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Configuration;

final class Configuration
{
    /**
     * @var array|Batch[]
     */
    private $batches;

    /**
     * @var array|Logger[]
     */
    private $loggers;

    /**
     * @param array $batches
     * @param array $loggers
     */
    private function __construct(array $batches, array $loggers)
    {
        $this->batches = $batches;
        $this->loggers = $loggers;
    }

    /**
     * @param array $array
     * @return self
     */
    public static function fromArray(array $array): self
    {
        if (empty($array['batches'])) {
            throw ConfigurationIsInvalid::becauseNoBatchesAreConfigured();
        }

        $array['loggers'] = $array['loggers'] ?? [];

        return new self(
            array_map(
                function(array $array, string $name) { return  Batch::fromArray($name, $array); },
                $array['batches']
            ),
            array_map(
                function(array $array, string $name) { return  Logger::fromArray($name, $array); },
                $array['loggers']
            )
        );
    }

    /**
     * @return array|Batch[]
     */
    public function getBatches(): array
    {
        return $this->batches;
    }

    /**
     * @param string $name
     * @return null|Batch
     */
    public function getBatchWithName(string $name): ?Batch
    {
        return $this->batches[$name] ?? null;
    }

    /**
     * @return array|Logger[]
     */
    public function getLoggers(): array
    {
        return $this->loggers;
    }

    /**
     * @param string $name
     * @return null|Logger
     */
    public function getLoggerWithName(string $name): ?Logger
    {
        return $this->loggers[$name] ?? null;
    }
}