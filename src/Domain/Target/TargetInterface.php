<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target;

interface TargetInterface
{
    public function handleWriteDirectory(Command\WriteDirectory $command): void;
    public function handleWriteFile(Command\WriteFile $command): void;
}