<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target\Command;

use PackageFactory\KristlBol\Domain\Configuration\Configuration;

final class GenerateAll
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }
}