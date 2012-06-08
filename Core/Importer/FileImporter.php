<?php

namespace Propel\TranslationBundle\Core\Importer;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Import a translation file into the database.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class FileImporter
{
    /**
     * services container
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container A ContainerInterface instance
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Impoort the given file and return the number of inserted translations.
     *
     * @param \Symfony\Component\Finder\SplFileInfo $file
     * @return int
     */
    public function import(\Symfony\Component\Finder\SplFileInfo $file)
    {
        $imported = 0;
        list($domain, $locale, $extention) = explode('.', $file->getFilename());

        $dataManager = $this->container->get('propel.translation.data_manager');

        $messageCatalogue = $this->container->get(sprintf('translation.loader.%s', $extention))
            ->load($file->getPathname(), $locale, $domain);

        foreach ($messageCatalogue->all($domain) as $key => $content) {

            $translationFile = $dataManager->findOrCreateTranslationFile(
                $domain, $locale, dirname($file->getRealPath())
            );

            $key = $dataManager->findOrCreateTranslationKey(
                $domain, $key
            );

            $translationContent = $dataManager->findOrCreateTranslationContent(
                $key, $locale, $translationFile
            );

            $translationContent->setContent($content);
            $translationContent->save();

            $imported++;
        }

        return $imported;
    }
}