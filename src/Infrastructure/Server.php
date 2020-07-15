<?php declare(strict_types=1);

use PackageFactory\KristlBol\Application\KristlBol;
use PackageFactory\KristlBol\Domain\Configuration\Configuration;

$foundAutoloader = false;
foreach ([
    getcwd() . '/vendor/autoload.php',
    __DIR__ . '/../../../autoload.php', 
    __DIR__ . '/../../vendor/autoload.php', 
    __DIR__ . '../vendor/autoload.php'
] as $file) {
    if (file_exists($file)) {
        $foundAutoloader = true;
        require_once $file;
        break;
    }
}

if (!$foundAutoloader) {
    die('Could not find autoloader.');
}

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$batchName = getenv('PACKAGE_FACTORY_KRISTLBOL_BATCH_NAME') ?: 'default';
$pathToConfigFile = getenv('PACKAGE_FACTORY_KRISTLBOL_CONFIG_FILE');
if ($pathToConfigFile) {
    $configuration = Configuration::fromConfigurationFile($pathToConfigFile);
} else {
    $configuration = Configuration::fromEnvironment();
}

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();
$response = KristlBol::serve($configuration, $batchName, $serverRequest);

echo $response->getBody();