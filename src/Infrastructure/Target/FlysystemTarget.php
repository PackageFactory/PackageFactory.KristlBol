<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Infrastructure\Target;

use League\Flysystem\Filesystem;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Adapter;
use PackageFactory\KristlBol\Domain\Target\TargetInterface;
use PackageFactory\KristlBol\Domain\Target\Command;

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
     * @param Command\WriteDirectory $command
     * @return void
     */
    public function handleWriteDirectory(Command\WriteDirectory $command): void
    {
        $this->filesystem->createDir((string) $command->getPath());
    }

    /**
     * @param Command\WriteFile $command
     * @return void
     */
    public function handleWriteFile(Command\WriteFile $command): void
    {
        $this->filesystem->writeStream(
            (string) $command->getPath(), 
            $command->getContent()->getStream()
        );
    }
}