<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Target;

use PackageFactory\KristlBol\Domain\Configuration\Target as ConfiguredTarget;

final class Target
{
    /**
     * @param ConfiguredTarget $configuredTarget
     * @return self
     */
    public static function fromConfiguredTarget(ConfiguredTarget $configuredTarget): TargetInterface
    {
        $className = $configuredTarget->getImplementationClassName();

        if (method_exists($className, 'fromOptions')) {
            return $className::fromOptions($configuredTarget->getOptions());
        } else {
            return new $className;
        }
    }
}