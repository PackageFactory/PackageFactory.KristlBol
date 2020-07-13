<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target\Command;

use PackageFactory\KristlBol\Domain\Node\ContentInterface;

final class WriteFile
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var ContentInterface
     */
    private $content;

    /**
     * @param string $path
     */
    public function __construct(string $path, ContentInterface $content)
    {
        $this->path = $path;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getPath(): string
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