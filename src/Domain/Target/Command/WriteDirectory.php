<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target\Command;

final class WriteDirectory
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}