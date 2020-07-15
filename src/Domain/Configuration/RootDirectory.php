<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Configuration;

use PackageFactory\KristlBol\Domain\Tree\DirectoryInterface;

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
        if (!class_exists($implementationClassName)) {
            throw ConfigurationIsInvalid::
                becauseRootDirectoryImplementationDoesNotExist($implementationClassName);
        }

        if (!is_subclass_of($implementationClassName, DirectoryInterface::class, true)) {
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