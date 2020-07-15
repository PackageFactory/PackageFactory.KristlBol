<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target\Command;

use PackageFactory\KristlBol\Domain\Configuration\Batch;
use PackageFactory\KristlBol\Domain\Configuration\Configuration;

final class GenerateBatch
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Batch
     */
    private $batch;

    /**
     * @param Configuration $configuration
     * @param Batch $batch
     */
    public function __construct(Configuration $configuration, Batch $batch)
    {
        $this->configuration = $configuration;
        $this->batch = $batch;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * @return Batch
     */
    public function getBatch(): Batch
    {
        return $this->batch;
    }
}