<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Infrastructure\Target;

use League\Flysystem\Filesystem;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Adapter;
use PackageFactory\KristlBol\Domain\Target\TargetInterface;
use PackageFactory\KristlBol\Domain\Target\Command;
use PackageFactory\KristlBol\Domain\Target\Event\DirectoryWasWritten;
use PackageFactory\KristlBol\Domain\Target\Event\FileWasWritten;

final class FlysystemTarget implements TargetInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param AdapterInterface $flysystemAdapter
     */
    private function __construct(AdapterInterface $flysystemAdapter)
    {
        $this->filesystem = new Filesystem($flysystemAdapter);
    }

    /**
     * @param array $options
     * @return self
     */
    public static function fromOptions(array $options): self
    {
        $options['outputDirectory'] = $options['outputDirectory'] ?? getcwd() . DIRECTORY_SEPARATOR . 'dist';
        return new self(new Adapter\Local($options['outputDirectory']));
    }

    /**
     * @param DirectoryWasWritten $command
     * @return void
     */
    public function whenDirectoryWasWritten(DirectoryWasWritten $event): void
    {
        $this->filesystem->createDir((string) $event->getPath());
    }

    /**
     * @param FileWasWritten $command
     * @return void
     */
    public function whenFileWasWritten(FileWasWritten $event): void
    {
        $this->filesystem->writeStream(
            (string) $event->getPath(), 
            $event->getContent()->toStream()
        );
    }
}