<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Configuration;

final class Batch
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var RootDirectory
     */
    private $rootDirectory;

    /**
     * @var array|Target[]
     */
    private $targets;

    /**
     * @param string $name
     * @param RootDirectory $rootDirectory
     * @param array $targets
     */
    private function __construct(string $name, RootDirectory $rootDirectory, array $targets)
    {
        $this->name = $name;
        $this->rootDirectory = $rootDirectory;
        $this->targets = $targets;
    }

    /**
     * @param string $name
     * @param array $array
     * @return self
     */
    public static function fromArray(string $name, array $array): self
    {
        if (!isset($array['rootDirectory'])) {
            throw ConfigurationIsInvalid::becauseNoRootDirectoryImplementationWasSpecifiedInBatch();
        }

        $array['targets'] = $array['targets'] ?? [[
            'target' => 'PackageFactory\\KristlBol\\Infrastructure\\Target\\FlysystemTarget'
        ]];

        return new self(
            $name,
            RootDirectory::fromString($array['rootDirectory']),
            array_map(
                function(array $targetArray) { return Target::fromArray($targetArray); }, 
                $array['targets']
            )
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return RootDirectory
     */
    public function getRootDirectory(): RootDirectory
    {
        return $this->rootDirectory;
    }

    /**
     * @return array|Target[]
     */
    public function getTargets(): array
    {
        return $this->targets;
    }
}