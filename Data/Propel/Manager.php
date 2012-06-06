<?php

namespace Propel\TranslationBundle\Data\Propel;

use Propel\TranslationBundle\Data\DataManagerInterface;

use Propel\TranslationBundle\Model\TranslationKeyQuery;
use Propel\TranslationBundle\Model\TranslationContentQuery;

/**
 * Propel manager for bundle, loads and save data throught DataManagerInterface
 */
class Manager implements DataManagerInterface
{

    /**
     * returns all domains and locale
     * @return array
     * @see DataManagerInterface
     */
    public function getAllDomainsLocale()
    {
        $data = TranslationKeyQuery::create()
            ->joinWithTranslationContent()
            ->select(array('TranslationContent.Locale'))
            ->withColumn('DISTINCT(Domain)')
            ->find();

        $return = array();
        foreach($data as $line) {
            $return[] = array(
                'locale' => $line['TranslationContent.Locale'],
                'domain' => $line['DISTINCTDomain']
            );
        }

        return $return;
    }

    /**
     * returns all translations contents for given locale and domain
     * @param string $domain
     * @param string $locale
     * @return array
     */
    public function getAllContentsByDomainAndLocale($locale, $domain)
    {
        $data = TranslationContentQuery::create()
            ->select(array('Content', 'TranslationKey.KeyName'))
            ->filterByLocale($locale)
            ->useTranslationKeyQuery()
                ->filterByDomain($domain)
            ->endUse()
            ->find()
            ->getData();

        $return = array();
        foreach($data as $line) {
            $return[] = array(
                'key' => $line['TranslationKey.KeyName'],
                'content' => $line['Content']
            );
        }

        return $return;
    }

}