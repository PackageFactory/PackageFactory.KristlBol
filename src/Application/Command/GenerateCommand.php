<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Application\Command;

use PackageFactory\KristlBol\Infrastructure\KristlBolFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'generate';

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setDescription('Generate static documents')
            ->setHelp('Generate static documents')
            ->addArgument(
                'config',
                InputArgument::OPTIONAL,
                'Path to KristlBol configuration file'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $kristlBolFactory = new KristlBolFactory();

        if ($pathToConfigFile = $input->getArgument('config')) {
            $kristlBol = $kristlBolFactory->fromNamedConfigurationFile($pathToConfigFile);
            $kristlBol->generate();
            return Command::SUCCESS;
        } else {
            $kristlBol = $kristlBolFactory->fromEnvironment();
            $kristlBol->generate();
            return Command::SUCCESS;
        }
    }
}
