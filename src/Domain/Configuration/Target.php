<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Configuration;

use PackageFactory\KristlBol\Domain\Target\TargetInterface;

final class Target
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
                becauseTargetImplementationDoesNotExist($implementationClassName);
        }

        if (!is_subclass_of($implementationClassName, TargetInterface::class, true)) {
            throw ConfigurationIsInvalid::
                becauseTargetDoesNotReferenceAnImplementationOfTargetInterface($implementationClassName);
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
        return new self($array['target'], $array['targetOptions'] ?? []);
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