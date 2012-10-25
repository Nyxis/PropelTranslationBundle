<?php

namespace Propel\TranslationBundle\Core;

use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\TranslatorInterface;

use Propel\TranslationBundle\Data\DataManagerInterface;
use Propel\TranslationBundle\Core\Cache\Manager as CacheManager;

class DatabaseLoader implements LoaderInterface
{
    /**
     * service dataManager
     * @var DataManagerInterface
     */
    protected $dataManager;

    /**
     * Constructor.
     *
     * @param DataManagerInterface $dataManager A dataManagerInterface instance
     */
    public function __construct(DataManagerInterface $dataManager)
    {
        $this->dataManager = $dataManager;
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Translation\Loader.LoaderInterface::load()
     */
    public function load($resource, $locale, $domain = 'messages')
    {
        $catalogue = new MessageCatalogue($locale);

        $contentsLists = $this->dataManager->getAllContentsByDomainAndLocale($locale, $domain);

        foreach ($contentsLists as $content) {
            $catalogue->set($content['keyName'], $content['content'], $domain);
        }

        return $catalogue;
    }

    /**
     * Add all resources available in database.
     * @var TranslatorInterface translator
     * @var CacheManager $cache
     */
    public function addDatabaseResources(TranslatorInterface $translator, CacheManager $cache)
    {
        $resources = array();

        if (!$cache->isFresh()) {
            $resources = $this->dataManager->getAllDomainsLocale();

            $metadata = array();
            foreach ($resources as $resource) {
                $metadata[] = new DatabaseResource($resource['locale'], $resource['domain']);
            }

            $content = sprintf("<?php return %s;", var_export($resources, true));
            $cache->write($content, $metadata);
        } else {
            $resources = $cache->getContent();
        }

        foreach ($resources as $resource) {
            $translator->addResource('database', 'DB', $resource['locale'], $resource['domain']);
        }
    }
}
