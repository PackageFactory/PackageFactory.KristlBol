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
            ->addOption(
                'config', 
                'c',
                InputArgument::OPTIONAL, 
                'Path to ConfigurationFile'
            )
            ->addOption(
                'port', 
                'p',
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

        $process = new \React\ChildProcess\Process(
            sprintf('php -S 0.0.0.0:%s %s', $input->getOption('port'), __DIR__ . '/../../Infrastructure/Server.php'),
            getcwd(),
            ['PACKAGE_FACTORY_KRISTLBOL_CONFIG_FILE' => $input->getOption('config')]
        );
        $process->start($loop);

        $output->writeln([
            sprintf('Server started on port %s.', $input->getOption('port')),
            sprintf('Reachable via %s', 'http://127.0.0.1:' . $input->getOption('port'))
        ]);

        $process->stdout->on('data', function ($chunk) use ($output) {
            $output->writeln([$chunk]);
        });

        $process->on('exit', function($exitCode) use ($output) {
            $output->writeln(['Process exited with code ' . $exitCode]);
        });

        $loop->run();
        return Command::SUCCESS;
    }
}
