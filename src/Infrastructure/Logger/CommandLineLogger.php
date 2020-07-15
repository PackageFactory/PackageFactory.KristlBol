<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Infrastructure\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

final class CommandLineLogger extends Logger
{
    private function __construct()
    {
        parent::__construct('KristlBol');
        $this->pushHandler(new StreamHandler('php://stdout'));
    }

    public static function fromOptions(): self
    {
        return new self();
    }
}