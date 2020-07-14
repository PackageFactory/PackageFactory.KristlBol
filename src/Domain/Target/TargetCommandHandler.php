<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target;

use League\Event\EmitterInterface;
use PackageFactory\KristlBol\Domain\Node\DirectoryInterface;
use PackageFactory\KristlBol\Domain\Node\FileInterface;
use PackageFactory\KristlBol\Domain\Node\RecursiveDirectoryIterator;
use PackageFactory\KristlBol\Domain\Target\Event\DirectoryWasWritten;
use PackageFactory\KristlBol\Domain\Target\Event\FileWasWritten;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class TargetComandHandler
{
    /**
     * @var DirectoryInterface
     */
    private $rootDirectory;

    /**
     * @var EmitterInterface
     */
    private $eventEmitter;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param EmitterInterface $eventEmitter
     */
    public function __construct(
        DirectoryInterface $rootDirectory,
        EmitterInterface $eventEmitter,
        LoggerInterface $logger = null
    ) {
        $this->rootDirectory = $rootDirectory;
        $this->eventEmitter = $eventEmitter;
        $this->logger = $logger ?? new NullLogger();
    }

    /**
     * @return void
     */
    public function handleGenerate(Command\Generate $command): void
    {
        foreach (RecursiveDirectoryIterator::iterate($this->rootDirectory) as $node) {
            if ($node instanceof FileInterface) {
                $this->eventEmitter->emit(FileWasWritten::fromFile($node));
                $this->logger->info('File was written: ' . $node->getPath());
            } elseif ($node instanceof DirectoryInterface) {
                $this->eventEmitter->emit(DirectoryWasWritten::fromDirectory($node));
                $this->logger->info('Directory was written: ' . $node->getPath());
            }

            $this->logger->warning(
                sprintf(
                    'Strange node of type "%s" was encountered and ignored.', 
                    get_class($node)
                )
            );
        }
    }
}