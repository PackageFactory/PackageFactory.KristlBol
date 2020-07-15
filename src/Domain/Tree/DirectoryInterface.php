<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Tree;

interface DirectoryInterface extends NodeInterface
{
    /**
     * @return \Iterator<NodeInterface>
     */
    public function findChildren(): \Iterator;

    /**
     * @param Query\GetFile $fileName
     * @return FileInterface|null
     */
    public function findFile(Query\GetFile $getFileQuery): ?FileInterface;
}