<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target;

interface TargetInterface
{
    public function whenDirectoryWasWritten(Event\DirectoryWasWritten $event): void;
    public function whenFileWasWritten(Event\FileWasWritten $event): void;
}