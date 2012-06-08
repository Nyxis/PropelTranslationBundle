<?php

namespace Propel\TranslationBundle\Core;

use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DatabaseLoader implements LoaderInterface
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
     * (non-PHPdoc)
     * @see Symfony\Component\Translation\Loader.LoaderInterface::load()
     */
    public function load($resource, $locale, $domain = 'messages')
    {
        $catalogue = new MessageCatalogue($locale);

        $contentsLists = $this->container->get('propel.translation.data_manager')
                ->getAllContentsByDomainAndLocale($locale, $domain);

        foreach ($contentsLists as $content) {
            $catalogue->set($content['key'], $content['content'], $domain);
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

        // if (!$cache->isFresh()) {
            $resources = $this->container->get('propel.translation.data_manager')
                ->getAllDomainsLocale();

            $metadata = array();
            foreach ($resources as $resource) {
                $metadata[] = new DatabaseResource($resource['locale'], $resource['domain']);
            }

            $content = sprintf("<?php return %s;", var_export($resources, true));
            $cache->write($content, $metadata);
        // } else {
        //     $resources = $cache->getContent();
        // }

        foreach($resources as $resource) {
            $translator->addResource('database', 'DB', $resource['locale'], $resource['domain']);
        }
    }
}