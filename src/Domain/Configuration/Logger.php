<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Configuration;

final class Logger
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $implementationClassName;

    /**
     * @var array<mixed>
     */
    private $options;

    /**
     * @param string $name
     * @param string $implementationClassName
     * @param array<mixed> $options
     */
    private function __construct(string $name, string $implementationClassName, array $options)
    {
        if (!class_implements($implementationClassName, TargetInterface::class)) {
            throw ConfigurationIsInvalid::
                becauseLoggerDoesNotReferenceAnImplementationOfLoggerInterface($implementationClassName);
        }

        $this->name = $name;
        $this->implementationClassName = $implementationClassName;
        $this->options = $options;
    }

    /**
     * @param string $name
     * @param array $options
     * @return self
     */
    public static function fromArray(string $name, array $array): self 
    {
        return new self($name, $array['logger'], $array['loggerOptions']);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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