<?php

namespace Propel\TranslationBundle\Data;

/**
 * interface for data manager in the bundle, @implements for other ORM usages
 */
interface DataManagerInterface
{
    /**
     * return all domaines and locales as an array
     *
     * return format :
     * array(
     *      array('domain' => 'message1', 'locale' => 'en' ),
     *      array('domain' => 'message1', 'locale' => 'fr' ),
     *      ....
     * );
     *
     */
    public function getAllDomainsLocale();
}
