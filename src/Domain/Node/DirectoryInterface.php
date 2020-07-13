<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Node;

interface DirectoryInterface extends NodeInterface
{
    /**
     * @return \Iterator<NodeInterface>
     */
    public function getChildren(): \Iterator;

    /**
     * @param Query\GetFile $fileName
     * @return FileInterface|null
     */
    public function getFile(Query\GetFile $getFileQuery): ?FileInterface;
}