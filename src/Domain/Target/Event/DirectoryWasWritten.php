<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target\Event;

use League\Event\AbstractEvent;
use PackageFactory\KristlBol\Domain\Node\DirectoryInterface;
use PackageFactory\KristlBol\Domain\Node\Path;

final class DirectoryWasWritten extends AbstractEvent
{
    /**
     * @var Path
     */
    private $path;

    /**
     * @param Path $path
     */
    private function __construct(Path $path)
    {
        $this->path = $path;
    }

    /**
     * @param DirectoryInterface $directory
     * @return self
     */
    public static function fromDirectory(DirectoryInterface $directory): self
    {
        return new self($directory->getPath());
    }

    /**
     * @return Path
     */
    public function getPath(): Path
    {
        return $this->path;
    }
}