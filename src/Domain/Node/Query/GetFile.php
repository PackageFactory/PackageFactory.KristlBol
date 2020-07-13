<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Node\Query;

use PackageFactory\KristlBol\Domain\Node\Path;

final class GetFile
{
    /**
     * @var Path
     */
    private $path;

    /**
     * @param Path $path
     */
    public function __construct(Path $path)
    {
        $this->path = $path;
    }

    /**
     * @return Path
     */
    public function getPath(): Path
    {
        return $this->path;
    }
}