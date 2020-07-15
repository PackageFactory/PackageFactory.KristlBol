<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Application\Command;

use PackageFactory\KristlBol\Application\KristlBol;
use PackageFactory\KristlBol\Domain\Configuration\Configuration;
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
            ->addOption(
                'config',
                'c',
                InputArgument::OPTIONAL,
                'Path to KristlBol configuration file'
            )
            ->addOption(
                'batch',
                'b',
                InputArgument::OPTIONAL,
                'If set, only this batch will be generated'
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
        if ($pathToConfigFile = $input->getOption('config')) {
            $configuration = Configuration::fromConfigurationFile($pathToConfigFile);
        } else {
            $configuration = Configuration::fromEnvironment();
        }

        KristlBol::generate($configuration, $input->getOption('batch'));
        return Command::SUCCESS;
    }
}
