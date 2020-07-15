<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Tree;

final class RecursiveDirectoryIterator
{
    /**
     * @param DirectoryInterface $directory
     * @return \Iterator<NodeInterface>
     */
    public static function iterate(DirectoryInterface $directory): \Iterator
    {
        foreach ($directory->findChildren() as $child) {
            yield $child;
            if ($child instanceof DirectoryInterface) {
                yield from self::iterate($child);
            }
        }
    }
}