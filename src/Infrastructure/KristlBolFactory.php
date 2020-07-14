<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Infrastructure;

use PackageFactory\KristlBol\Application\KristlBol;

final class KristlBolFactory
{
    public function fromNamedConfigurationFile(string $relativePathFromCwdToConfigurationFile): KristlBol
    {
        $configurationFilePath = getcwd() . DIRECTORY_SEPARATOR .  $relativePathFromCwdToConfigurationFile;
        if (file_exists($configurationFilePath)) {
            $configurationFileAsString = file_get_contents($configurationFilePath);
            $configurationFile = [];

            try {
                $configurationFile = json_decode($configurationFileAsString, true, 512, JSON_THROW_ON_ERROR);
            } catch (\Exception $e) {
                throw KristlBolInitializationFailed::becauseOfAnUnderlyingException($e);
            }

            return $this->fromKristBolRc($configurationFile);
        }

        throw KristlBolInitializationFailed::becauseNoSuitableConfigurationFileCouldBeFound([
            $configurationFilePath
        ]);
    }

    public function fromEnvironment(): KristlBol
    {
        $kristlBolRcFilePath = getcwd() . DIRECTORY_SEPARATOR . '.kristlbolrc';
        if (file_exists($kristlBolRcFilePath)) {
            $kristlBolRcAsString = file_get_contents($kristlBolRcFilePath);
            $kristlBolRc = [];

            try {
                $kristlBolRc = json_decode($kristlBolRcAsString, true, 512, JSON_THROW_ON_ERROR);
            } catch (\Exception $e) {
                throw KristlBolInitializationFailed::becauseOfAnUnderlyingException($e);
            }

            return $this->fromKristBolRc($kristlBolRc);
        }

        $composerJsonFilePath = getcwd() . DIRECTORY_SEPARATOR . 'composer.json';
        if (file_exists($composerJsonFilePath)) {
            $composerJsonAsString = file_get_contents($composerJsonFilePath);

            try {
                $composerJson = json_decode($composerJsonAsString, true, 512, JSON_THROW_ON_ERROR);
            } catch (\Exception $e) {
                throw KristlBolInitializationFailed::becauseOfAnUnderlyingException($e);
            }

            return $this->fromComposerJson($composerJson);
        }

        throw KristlBolInitializationFailed::becauseNoSuitableConfigurationFileCouldBeFound([
            $kristlBolRcFilePath,
            $composerJsonFilePath
        ]);
    }

    public function fromKristBolRc(array $kristlBolRc): KristlBol
    {
        throw new \Exception('@TODO: KristlBolFactory->fromKristBolRc()');
    }

    public function fromComposerJson(array $composerJson): KristlBol
    {
        throw new \Exception('@TODO: KristlBolFactory->fromComposerJson()');
    }
}