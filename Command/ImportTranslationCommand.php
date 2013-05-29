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

        $this->output->writeln('>>> <comment>Importing translation files</comment>');
        $this->importTranslationFiles(
            $this->findTranslationFiles(
                $this->getContainer()->getParameter('propel.translation.managed_locales')
            )
        );

        if ($this->input->getOption('cache-clear')) {
            $this->output->writeln('<info>Removing translations cache files ...</info>');
            $this->removeTranslationCache();
        }
    }

    /**
     * Imports some translations files
     *
     * @param Finder $finder
     */
    protected function importTranslationFiles($finder)
    {
        if ($finder instanceof Finder) {
            $importer = $this->getContainer()->get('propel.translation.importer.file');

            foreach ($finder as $file) {
                $number = $importer->import($file);
                if ($number) {
                    $this->output->writeln(sprintf('> <info>translations+%d</info> : %s', $number, realpath($file->getRealPath())));
                }
            }
        } else {
            $this->output->writeln('<comment>No file to import for managed locales.</comment>');
        }
    }

    /**
     * Return a Finder object on all translation files
     *
     * @param  array                           $locales
     * @return Symfony\Component\Finder\Finder
     */
    protected function findTranslationFiles(array $locales)
    {
        $kernel        = $this->getApplication()->getKernel();
        $kernelRootDir = $kernel->getRootDir();
        $projectDir    = realpath(sprintf('%s/..', $kernelRootDir));

        $finder = new Finder();
        $finder->files()
            ->name(sprintf('/(.*(%s)\.(xliff|yml|php))/', implode('|', $locales)))
            ->filter(function($file) {
                return (bool) preg_match('/.*\/Resources\/translations\/.*/', $file->getRealPath()); // in translations dirs
            })
            ->in($kernelRootDir)                      // app
            ->in(sprintf('%s/src', $projectDir))      // src
        ;

        // each extra bundles (vendors) which have to be load
        foreach ($this->getContainer()->getParameter('propel.translation.load_bundle') as $bundle) {
            $finder->in(sprintf('%sResources/translations', $kernel->locateResource($bundle)));
        }

        return $finder;
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
