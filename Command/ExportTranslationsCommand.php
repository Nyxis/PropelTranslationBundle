<?php

namespace Propel\TranslationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Export translations from the database in to files.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class ExportTranslationsCommand extends ContainerAwareCommand
{
    /**
     * @var Symfony\Component\Console\Input\InputInterface
     */
    private $input;

    /**
     * @var Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this->setName('propel:translation:export');
        $this->setDescription('Export translations from the database to files.');

        $this->addOption('locales', 'l', InputOption::VALUE_OPTIONAL, 'Only export files for given locales. e.g. "--locales=en,de"', null);
        $this->addOption('domains', 'd', InputOption::VALUE_OPTIONAL, 'Only export files for given domains. e.g. "--domains=messages,validators"', null);
        $this->addOption('format', 'f', InputOption::VALUE_OPTIONAL, 'Force the output format.', null);
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $filesToExport = $this->getFilesToExport();

        if (count($filesToExport) > 0) {
            foreach ($filesToExport as $file) {
                $this->exportFile($file);
            }
        } else {
            $this->output->writeln('<comment>No translation\'s files in the database.</comment>');
        }
    }

    /**
     * Returns all file to export.
     *
     * @return array
     */
    protected function getFilesToExport()
    {
        $locales = $this->input->getOption('locales') ? explode(',', $this->input->getOption('locales')) : array();
        $domains = $this->input->getOption('domains') ? explode(',', $this->input->getOption('domains')) : array();

        return $this->getContainer()
            ->get('propel.translation.data_manager')
            ->findFilesByLocalesAndDomaines($locales, $domains);
    }

    /**
     * Get translations to export and export translations into a file.
     *
     * @param File $file
     */
    protected function exportFile($file)
    {
        $this->output->writeln(sprintf('<info># Exporting "%s/%s":</info>', $file->getPath(), $file->getName()));

        $translations = $this->getContainer()
            ->get('propel.translation.data_manager')
            ->getTranslationsForFile($file);

        if (count($translations) > 0) {
            $format = $this->input->getOption('format') ?
                $this->input->getOption('format') :
                $file->getExtension();

            $outputFile = sprintf('%s/%s.%s.%s',
                $file->getPath(),
                $file->getDomain(),
                $file->getLocale(),
                $format
            );

            $translations = $this->mergeExistingTranslations($file, $outputFile, $translations);
            $this->doExport($outputFile, $translations, $format);
        } else {
            $this->output->writeln('<comment>No translations to export.</comment>');
        }
    }

    /**
     * If the output file exists we merge existing translations with those from the database.
     *
     * @param File $file
     * @param string $outputFile
     * @param array $translations
     * @return array
     */
    protected function mergeExistingTranslations($file, $outputFile, $translations)
    {
        if (file_exists($outputFile)) {
            $loader = $this->getContainer()->get(sprintf('translation.loader.%s', $file->getExtension()));
            $messageCatalogue = $loader->load($outputFile, $file->getLocale(), $file->getDomain());

            $translations = array_merge($messageCatalogue->all($file->getDomain()), $translations);
        }

        return $translations;
    }

    /**
     * Export translations.
     *
     * @param string $outputFile
     * @param array $translations
     * @param string $format
     */
    protected function doExport($outputFile, $translations, $format)
    {
        $this->output->writeln(sprintf('<comment>Output file: %s</comment>', $outputFile));
        $this->output->write(sprintf('<comment>%d translations to export: </comment>', count($translations)));

        $exporterId = sprintf('propel.translation.exporter.%s', $format);

        if ($this->getContainer()->has($exporterId)) {
            $exporter = $this->getContainer()->get($exporterId);
            $exported = $exporter->export($outputFile, $translations);

            $this->output->writeln($exported ? '<comment>success</comment>' : '<error>fail</error>');
        } else {
            $this->output->writeln(sprintf('<error>No exporter found for "%s" extention</error>', $format));
        }
    }
}