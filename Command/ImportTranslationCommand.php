<?php

namespace Propel\TranslationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

/**
* Imports translation files content in the database.
* Only imports files for locales defined in lexik_translation.managed_locales.
*
* @author Cédric Girard <c.girard@lexik.fr>
*/
class ImportTranslationCommand extends ContainerAwareCommand
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
        $this->setName('propel:translation:import');
        $this->setDescription('Import all translations from flat files (xliff, yml, php) into the database.');

        $this->addOption('cache-clear', 'c', InputOption::VALUE_NONE, 'Remove translations cache files for managed locales.', null);
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->output->writeln('<info>*** Importing translation files ***</info>');
        $this->importAppTranslationFiles(
            $this->getContainer()->getParameter('propel.translation.managed_locales')
        );

        if ($this->input->getOption('cache-clear')) {
            $this->output->writeln('<info>Removing translations cache files ...</info>');
            $this->removeTranslationCache();
        }
    }

    /**
     * Imports application translation files.
     *
     * @param array $locales
     */
    protected function importAppTranslationFiles(array $locales)
    {
        $finder = $this->findTranslationsFiles(
            $this->getApplication()->getKernel()->getRootDir().'/..',
            $locales
        );

        $this->importTranslationFiles($finder);
    }

    /**
     * Imports some translations files.
     *
     * @param Finder $finder
     */
    protected function importTranslationFiles($finder)
    {
        if ($finder instanceof Finder) {
            $importer = $this->getContainer()->get('propel.translation.importer.file');

            foreach ($finder as $file) {
                $this->output->write(sprintf('<comment>Importing "%s" ... </comment>', realpath($file->getRealPath())));
                $number = $importer->import($file);
                $this->output->writeln(sprintf('<comment>%d translations</comment>', $number));
            }
        } else {
            $this->output->writeln('<comment>No file to import for managed locales.</comment>');
        }
    }

    /**
     * Return a Finder object if $path has a Resources/translations folder.
     *
     * @param  string                          $path
     * @return Symfony\Component\Finder\Finder
     */
    protected function findTranslationsFiles($path, array $locales)
    {
        $finder = new Finder();
        $finder->files()
            ->name(sprintf('/(.*(%s)\.(xliff|yml|php))/', implode('|', $locales)))
            ->filter(function($file) {
                return (bool) preg_match('/.*\/Resources\/translations\/.*/', $file->getRealPath()) // in properly dirs
                    && (bool) !preg_match('/.*\/vendor\/.*/', $file->getRealPath()); // but not in cache
            });

        return $finder->in($path);
    }

    /**
     * Remove translation cache files managed locales.
     */
    public function removeTranslationCache()
    {
        $this->getContainer()->get('propel.translation.cache_manager')->removeLocalesFiles(
            $this->getContainer()->getParameter('propel.translation.managed_locales')
        );
    }
}

