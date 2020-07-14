<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Application;

use PackageFactory\KristlBol\Domain\Node;
use PackageFactory\KristlBol\Domain\Node\DirectoryInterface;
use PackageFactory\KristlBol\Domain\Node\FileInterface;
use PackageFactory\KristlBol\Domain\Node\RecursiveDirectoryIterator;
use PackageFactory\KristlBol\Domain\Target;
use PackageFactory\KristlBol\Domain\Target\Command\WriteDirectory;
use PackageFactory\KristlBol\Domain\Target\Command\WriteFile;

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

    public function generate(): void
    {
        foreach (RecursiveDirectoryIterator::iterate($this->rootDirectory) as $node) {
            if ($node instanceof FileInterface) {
                $this->target->handleWriteFile(
                    new WriteFile(
                        (string) $node->getPath(),
                        $node->findContent()
                    )
                );
            } elseif ($node instanceof DirectoryInterface) {
                $this->target->handleWriteDirectory(
                    new WriteDirectory(
                        (string) $node->getPath()
                    )
                );
            }
        }
    }

    public function serve(): void
    {

    }
}
