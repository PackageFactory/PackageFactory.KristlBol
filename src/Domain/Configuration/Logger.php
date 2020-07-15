<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Configuration;

use Psr\Log\LoggerInterface;

final class Logger
{
    /**
     * @var string
     */
    private $implementationClassName;

    /**
     * @var array<mixed>
     */
    private $options;

    /**
     * @param string $implementationClassName
     * @param array<mixed> $options
     */
    private function __construct(string $implementationClassName, array $options)
    {
        if (!class_exists($implementationClassName)) {
            throw ConfigurationIsInvalid::
                becauseLoggerImplementationDoesNotExist($implementationClassName);
        }

        if (!is_subclass_of($implementationClassName, LoggerInterface::class, true)) {
            throw ConfigurationIsInvalid::
                becauseLoggerDoesNotReferenceAnImplementationOfLoggerInterface($implementationClassName);
        }

        $this->implementationClassName = $implementationClassName;
        $this->options = $options;
    }

    /**
     * @param array $options
     * @return self
     */
    public static function fromArray(array $array): self 
    {
        return new self($array['logger'], $array['loggerOptions'] ?? []);
    }

    /**
     * @return string
     */
    public function getImplementationClassName(): string
    {
        return $this->implementationClassName;
    }

    /**
     * @return array<mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}