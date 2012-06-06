<?php

namespace Lexik\Bundle\TranslationBundle\Translation;

use Symfony\Bundle\FrameworkBundle\Translation\Translator as BaseTranslator;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\ConfigCache;

/**
* Translator service class.
*
* @author Cédric Girard <c.girard@lexik.fr>
*/
class Translator extends BaseTranslator
{
    /**
     * Add all resources available in database.
     *
     */
    public function addDatabaseResources()
    {
        $resources = array();
        $file = sprintf('%s/database.resources.php', $this->options['cache_dir']);
        $cache = new ConfigCache($file, $this->options['debug']);

        if (!$cache->isFresh()) {
            $resources = $this->container->get('lexik_translation.storage_manager')
                ->getRepository($this->container->getParameter('lexik_translation.trans_unit.class'))
                ->getAllDomainsByLocale();

            $metadata = array();
            foreach ($resources as $resource) {
                $metadata[] = new DatabaseFreshResource($resource['locale'], $resource['domain']);
            }

            $content = sprintf("<?php return %s;", var_export($resources, true));
            $cache->write($content, $metadata);
        } else {
            $resources = include $file;
        }

        foreach($resources as $resource) {
            $this->addResource('database', 'DB', $resource['locale'], $resource['domain']);
        }
    }
}