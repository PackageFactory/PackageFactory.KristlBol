<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain;

final class KristlBol
{
    /**
     * @var Node\DirectoryInterface
     */
    private $rootDirectory;

    /**
     * @var Target\TargetInterface
     */
    private $target;

    /**
     * @param Node\DirectoryInterface $rootDirectory
     * @param Target\TargetInterface $target
     */
    public function __construct(
        Node\DirectoryInterface $rootDirectory,
        Target\TargetInterface $target
    ) {
        $this->rootDirectory = $rootDirectory;
        $this->target = $target;
    }

    /**
     * @return Node\DirectoryInterface
     */
    public function getRootDirectory(): Node\DirectoryInterface
    {
        return $this->rootDirectory;
    }

    /**
     * @return Target\TargetInterface
     */
    public function getTarget(): Target\TargetInterface
    {
        return $this->target;
    }
}