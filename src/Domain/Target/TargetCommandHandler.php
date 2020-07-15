<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target;

use PackageFactory\KristlBol\Domain\Configuration\Batch;
use PackageFactory\KristlBol\Domain\Logger\Logger;
use PackageFactory\KristlBol\Domain\Tree\DirectoryInterface;
use PackageFactory\KristlBol\Domain\Tree\FileInterface;
use PackageFactory\KristlBol\Domain\Tree\RecursiveDirectoryIterator;
use PackageFactory\KristlBol\Domain\Target\Event\DirectoryWasWritten;
use PackageFactory\KristlBol\Domain\Target\Event\FileWasWritten;
use PackageFactory\KristlBol\Domain\Tree\Directory;
use Psr\Log\LoggerInterface;

final class TargetCommandHandler
{
    /**
     * @param Command\GenerateAll $command
     * @return void
     */
    public function handleGenerateAll(Command\GenerateAll $command): void
    {
        $configuration = $command->getConfiguration();
        $logger = Logger::fromConfiguredLogger($configuration->getLogger());

        $logger->info('Writing all batches...');

        foreach ($configuration->getBatches() as $batch) {
            $this->writeBatch($batch, $logger);
        }

        $logger->info('Finished writing all batches.');
    }

    /**
     * @param Command\GenerateBatch $command
     * @return void
     */
    public function handleGenerateBatch(Command\GenerateBatch $command): void
    {
        $configuration = $command->getConfiguration();
        $logger = Logger::fromConfiguredLogger($configuration->getLogger());

        $this->writeBatch($command->getBatch(), $logger);
    }

    /**
     * @param Batch $batch
     * @param LoggerInterface $logger
     * @return void
     */
    protected function writeBatch(Batch $batch, LoggerInterface $logger): void
    {
        $logger->info('Writing batch "' . $batch->getName() . '"...');

        $stream = TargetEventStream::fromBatch($batch);
        $rootDirectory = Directory::fromConfiguredRootDirectory($batch->getRootDirectory());

        foreach (RecursiveDirectoryIterator::iterate($rootDirectory) as $node) {
            if ($node instanceof FileInterface) {
                $stream->emit(FileWasWritten::fromFile($node));
                $logger->info('File was written: ' . $node->getPath());
            } elseif ($node instanceof DirectoryInterface) {
                $stream->emit(DirectoryWasWritten::fromDirectory($node));
                $logger->info('Directory was written: ' . $node->getPath());
            } else {
                $logger->warning(
                    sprintf(
                        'Strange node of type "%s" was encountered and ignored.', 
                        get_class($node)
                    )
                );
            }
        }

        $logger->info('Finished writing batch "' . $batch->getName() . '".');
    }
}