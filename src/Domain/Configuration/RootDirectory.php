<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Configuration;

use PackageFactory\KristlBol\Domain\Node\DirectoryInterface;

final class RootDirectory
{
    /**
     * @var string
     */
    private $implementationClassName;

    /**
     * @param string $implementationClassName
     */
    private function __construct(string $implementationClassName)
    {
        if (!class_implements($implementationClassName, DirectoryInterface::class)) {
            throw ConfigurationIsInvalid::
                becauseRootDirectoryDoesNotReferenceAnImplementationOfDirectoryInterface($implementationClassName);
        }

        $this->implementationClassName = $implementationClassName;
    }

    /**
     * @param string $string
     * @return self
     */
    public static function fromString(string $string): self
    {
        return new self($string);
    }

    /**
     * @return string
     */
    public function getImplementationClassName(): string
    {
        return $this->implementationClassName;
    }
}