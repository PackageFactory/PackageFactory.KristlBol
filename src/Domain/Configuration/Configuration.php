<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Domain\Configuration;

final class Configuration
{
    /**
     * @var array|Batch[]
     */
    private $batches;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param array $batches
     * @param Logger $logger
     */
    private function __construct(array $batches, Logger $logger)
    {
        $this->batches = $batches;
        $this->logger = $logger;
    }

    /**
     * @param array $array
     * @return self
     */
    public static function fromArray(array $array): self
    {
        if (empty($array['batches'])) {
            throw ConfigurationIsInvalid::becauseNoBatchesAreConfigured();
        }

        $batches = [];
        foreach ($array['batches'] as $name => $value) {
            $batches[$name] = Batch::fromArray($name, $value);
        }

        return new self(
            $batches,
            Logger::fromArray($array['logger'] ?? [
                'logger' => 'PackageFactory\KristlBol\Infrastructure\Logger\CommandLineLogger'
            ])
        );
    }

    /**
     * @param string $pathToComposerJson
     * @return self
     */
    public static function fromComposerJson(string $pathToComposerJson): self
    {
        if (!file_exists($pathToComposerJson)) {
            throw ConfigurationIsInvalid::becauseNoSuitableConfigurationFileCouldBeFound([
                $pathToComposerJson
            ]);
        }

        $contents = file_get_contents($pathToComposerJson);

        try {
            $contentsAsArray = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            throw ConfigurationIsInvalid::becauseOfAnUnderlyingException($e);
        }

        return self::fromArray($contentsAsArray['extra']['kristlbol'] ?? []);
    }

    /**
     * @param string $pathToConfigurationFile
     * @return self
     */
    public static function fromConfigurationFile(string $pathToConfigurationFile): self
    {
        if (!file_exists($pathToConfigurationFile)) {
            throw ConfigurationIsInvalid::becauseNoSuitableConfigurationFileCouldBeFound([
                $pathToConfigurationFile
            ]);
        }
        $contents = file_get_contents($pathToConfigurationFile);

        try {
            $contentsAsArray = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            throw ConfigurationIsInvalid::becauseOfAnUnderlyingException($e);
        }

        return self::fromArray($contentsAsArray);
    }

    /**
     * @return self
     */
    public static function fromEnvironment(): self
    {
        $kristlBolRcFilePath = getcwd() . DIRECTORY_SEPARATOR . '.kristlbolrc';
        if (file_exists($kristlBolRcFilePath)) {
            return self::fromConfigurationFile($kristlBolRcFilePath);
        }

        $composerJsonFilePath = getcwd() . DIRECTORY_SEPARATOR . 'composer.json';
        if (file_exists($composerJsonFilePath)) {
            return self::fromComposerJson($composerJsonFilePath);
        }

        throw ConfigurationIsInvalid::becauseNoSuitableConfigurationFileCouldBeFound([
            $kristlBolRcFilePath,
            $composerJsonFilePath
        ]);
    }

    /**
     * @return array|Batch[]
     */
    public function getBatches(): array
    {
        return $this->batches;
    }

    /**
     * @param string $name
     * @return Batch
     */
    public function getBatchWithName(string $name): Batch
    {
        if (!isset($this->batches[$name])) {
            throw ConfigurationIsInvalid::
                becauseRequiredBatchIsNotConfigured($name);
        }

        return $this->batches[$name];
    }

    /**
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }
}