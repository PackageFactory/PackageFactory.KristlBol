<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target\Event;

use League\Event\AbstractEvent;
use PackageFactory\KristlBol\Domain\Node\ContentInterface;
use PackageFactory\KristlBol\Domain\Node\FileInterface;
use PackageFactory\KristlBol\Domain\Node\Path;

final class FileWasWritten extends AbstractEvent
{
/**
     * @var Path
     */
    private $path;

    /**
     * @var ContentInterface
     */
    private $content;

    /**
     * @param string $path
     */
    private function __construct(Path $path, ContentInterface $content)
    {
        $this->path = $path;
        $this->content = $content;
    }

    /**
     * @param FileInterface $file
     * @return self
     */
    public static function fromFile(FileInterface $file): self
    {
        return new self($file->getPath(), $file->findContent());
    }

    /**
     * @return Path
     */
    public function getPath(): Path
    {
        return $this->path;
    }

    /**
     * @return ContentInterface
     */
    public function getContent(): ContentInterface
    {
        return $this->content;
    }
}