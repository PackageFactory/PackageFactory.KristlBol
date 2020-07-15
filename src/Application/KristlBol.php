<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Application;

use PackageFactory\KristlBol\Domain\Configuration\Configuration;
use PackageFactory\KristlBol\Domain\Shared\Path;
use PackageFactory\KristlBol\Domain\Target\Command\GenerateAll;
use PackageFactory\KristlBol\Domain\Target\Command\GenerateBatch;
use PackageFactory\KristlBol\Domain\Target\TargetCommandHandler;
use PackageFactory\KristlBol\Domain\Tree\Directory;
use PackageFactory\KristlBol\Domain\Tree\Query\GetFile;
use PackageFactory\KristlBol\Infrastructure\Shared\Content\StringContent;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

final class KristlBol
{
    /**
     * @param Configuration $configuration
     * @param string|null $batchName
     * @return void
     */
    public static function generate(Configuration $configuration, ?string $batchName = null): void
    {
        $targetCommandHandler = new TargetCommandHandler;

        if ($batchName === null) {
            $targetCommandHandler->handleGenerateAll(
                new GenerateAll($configuration)
            );
        } else {
            $targetCommandHandler->handleGenerateBatch(
                new GenerateBatch($configuration, $configuration->getBatchWithName($batchName))
            );
        }
    }

    /**
     * @param Configuration $configuration
     * @param UriInterface $uri
     * @param string $batchName
     * @return ResponseInterface
     */
    public static function serve(
        Configuration $configuration, 
        string $batchName, 
        ServerRequestInterface $request
    ): ResponseInterface {
        $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
        $batch = $configuration->getBatchWithName($batchName);
        $rootDirectory = Directory::fromConfiguredRootDirectory($batch->getRootDirectory());
        $file = $rootDirectory->findFile(new GetFile(Path::fromUri($request->getUri())));

        if ($file) {
            return $psr17Factory->createResponse(200)->withBody(
                $psr17Factory->createStreamFromResource($file->findContent()->toStream())
            );
        } else {
            return $psr17Factory->createResponse(404)->withBody(
                $psr17Factory->createStream('Not Found')
            );
        }
    }
}
