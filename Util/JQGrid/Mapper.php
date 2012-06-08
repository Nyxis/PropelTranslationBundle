<?php

namespace Propel\TranslationBundle\Util\JQGrid;

/**
 * Class to create a jqGrid compatible result.
 *
 * @author Cédric Girard <c.girard@lexik.fr>
 */
class Mapper
{
    /**
     * @var array
     */
    private $datas;

    /**
     * @var int
     */
    private $total;

    /**
     * @var Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * Construct.
     *
     * @param Request $request
     * @param array $datas
     * @param int $total
     */
    public function __construct(\Symfony\Component\HttpFoundation\Request $request, $datas, $total)
    {
        $this->request = $request;
        $this->datas = $datas;
        $this->total = $total;
    }

    /**
     * Create the jqgrid content.
     *
     * @param array $locales
     * @param boolean $jsonEncode
     * @return mixed
     */
    public function generate($locales, $jsonEncode = true)
    {
        $result = array();
        $result['page'] = $this->request->query->get('page', 1);
        $result['records'] = $this->total;
        $result['total'] = (int) ceil($result['records'] / $this->request->query->get('rows', 20));
        $result['rows'] = array();

        $defaultTranslations = array();
        foreach ($locales as $locale) {
            $defaultTranslations[$locale] = '';
        }

        foreach ($this->datas as $translationKey) {
            $id = $translationKey->getId();

            $tmp = array();
            $tmp['id'] = $id;
            $tmp['cell'] = array($id, $translationKey->getDomain(), $translationKey->getKeyName()) + $defaultTranslations;

            foreach ($translationKey->getTranslationContents() as $translation) {
                $tmp['cell'][$translation->getLocale()] = $translation->getContent();
            }

            $tmp['cell'] = array_combine( range(0, count($tmp['cell'])-1), $tmp['cell'] );
            $result['rows'][] = $tmp;
        }

        return $jsonEncode ? json_encode($result) : $result;
    }
}