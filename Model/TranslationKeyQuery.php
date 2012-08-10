<?php

namespace Propel\TranslationBundle\Model;

use Propel\TranslationBundle\Model\om\BaseTranslationKeyQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'translation_key' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.vendor.quentincerny.propel-translation-bundle.Propel.TranslationBundle.Model
 */
class TranslationKeyQuery extends BaseTranslationKeyQuery
{
    /**
     * filter on all locales @param, and filter by a content in options
     * @param  array               $locales locales to filter with
     * @param  array               $options
     * @return TranslationKeyQuery
     */
    public function filterByLocaleAndOptions(array $locales = null, array $options = null)
    {
        if (is_null($locales)) {
            return $this;
        }

        $subQuery = self::create()
            ->select('Id')
            ->distinct()
            ->useTranslationContentQuery()
                ->filterByLocale($locales);

        foreach ($locales as $locale) {
            if (!empty($options[$locale])) {
                $subQuery->filterByContent(sprintf("'%%%s%%'", $options[$locale]));
            }
        }

        $idList = $subQuery->endUse()
            ->find()
            ->getData();

        if (count($idList) > 0) {
            $this->filterById($idList);
        }

        return $this;
    }

    /**
     * filters on a domain or a key if search mode is active
     * @param  array               $filters
     * @return TranslationKeyQuery
     */
    public function filterOnKeyOrDomain(array $filters = array())
    {
        if (empty($filters['_search'])) {
            return $this;
        }

        if (!empty($filters['domain'])) {
            $this->fitlerByDomain(sprintf('%%%s%%', $filters['domain']));
        }

        if (!empty($filters['key'])) {
            $this->filterByKeyName(sprintf('%%%s%%', $filters['key']));
        }

        return $this;
    }

} // TranslationKeyQuery
