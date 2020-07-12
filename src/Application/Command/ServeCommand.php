<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Application\Command;

use League\Flysystem\Filesystem;
use PackageFactory\VirtualDOM\Rendering\HTML5StringRenderer;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

final class ServeCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'serve';

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setDescription('Serve documents')
            ->setHelp('Serve documents from KristlBolFile via HTTP for Development purposes')
            ->addArgument(
                'file', 
                InputArgument::OPTIONAL, 
                'Path to KristlBolFile.php',
                getcwd() . DIRECTORY_SEPARATOR . 'KristlBolFile.php'
            )
            ->addArgument(
                'port', 
                InputArgument::OPTIONAL, 
                'Port to listen on',
                8080
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop = \React\EventLoop\Factory::create();

        /** @var KristlBolFile $kristlBolFile */
        $kristlBolFile = require $input->getArgument('file');

        $server = new \React\Http\Server(
            $loop, 
            function (ServerRequestInterface $request) use ($kristlBolFile) {
                if ($document = $kristlBolFile->document($request->getUri())) {
                    return new \React\Http\Message\Response(
                        200,
                        array(
                            'Content-Type' => 'text/html'
                        ),
                        sprintf(
                            '<!doctype %s>%s', 
                            $document->getDoctype(),
                            HTML5StringRenderer::render($document)
                        )
                    );
                } else {
                    return new \React\Http\Message\Response(
                        404,
                        array(
                            'Content-Type' => 'text/html'
                        ),
                        'Not found'
                    );
                }
            }
        );
        $socket = new \React\Socket\Server((int) $input->getArgument('port'), $loop);
        $server->listen($socket);
        $output->writeln([
            sprintf(
                '"%s" server can be reached via http://127.0.0.1:%s',
                $kristlBolFile->describe(),
                $input->getArgument('port')
            ),
            ''
        ]);

        $loop->run();
        return Command::SUCCESS;
    }
}
