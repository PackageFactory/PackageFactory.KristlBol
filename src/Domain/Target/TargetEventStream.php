<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target;

use League\Event\Emitter;
use PackageFactory\KristlBol\Domain\Configuration\Batch;

final class TargetEventStream extends Emitter
{
    /**
     * @param Batch $batch
     * @return self
     */
    public static function fromBatch(Batch $batch): self
    {
        $stream = new self();
        
        $targets = [];
        foreach ($batch->getTargets() as $target) {
            $targets[] = Target::fromConfiguredTarget($target);
        }

        $stream->addListener(
            Event\DirectoryWasWritten::class, 
            function (Event\DirectoryWasWritten $event) use ($targets) {
                foreach ($targets as $target) {
                    $target->whenDirectoryWasWritten($event);
                }
            }
        );

        $stream->addListener(
            Event\FileWasWritten::class, 
            function (Event\FileWasWritten $event) use ($targets) {
                foreach ($targets as $target) {
                    $target->whenFileWasWritten($event);
                }
            }
        );

        return $stream;
    }
}