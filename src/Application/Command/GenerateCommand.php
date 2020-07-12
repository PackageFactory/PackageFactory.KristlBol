<?php declare(strict_types=1);
namespace PackageFactory\KristlBol\Application\Command;

use League\Flysystem\Filesystem;
use PackageFactory\VirtualDOM\Rendering\HTML5StringRenderer;
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
            ->setHelp('Generate static documents from KristlBolFile')
            ->addArgument(
                'file', 
                InputArgument::OPTIONAL, 
                'Path to KristlBolFile.php',
                getcwd() . DIRECTORY_SEPARATOR . 'KristlBolFile.php'
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
        /** @var KristlBolFile $kristlBolFile */
        $kristlBolFile = require $input->getArgument('file');
        $filesystem = new Filesystem($kristlBolFile->output());
        foreach ($filesystem->listContents() as $item) {
            $filesystem->delete($item['path']);
        }

        $output->writeln([
            sprintf(
                'Generating Static Documents for "%s"',
                $kristlBolFile->describe()
            ),
            ''
        ]);

        foreach ($kristlBolFile->documents() as $document) {
            $output->writeln([$document->getPath()]);
            $filesystem->write(
                $document->getPath(), 
                sprintf(
                    '<!doctype %s>%s', 
                    $document->getDoctype(),
                    HTML5StringRenderer::render($document)
                )
            );
        }

        return Command::SUCCESS;
    }
}
