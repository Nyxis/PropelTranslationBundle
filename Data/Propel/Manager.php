<?php

namespace Propel\TranslationBundle\Data\Propel;

use Propel\TranslationBundle\Data\DataManagerInterface;

use Propel\TranslationBundle\Model\TranslationKey;
use Propel\TranslationBundle\Model\TranslationKeyQuery;
use Propel\TranslationBundle\Model\TranslationContent;
use Propel\TranslationBundle\Model\TranslationContentQuery;
use Propel\TranslationBundle\Model\TranslationFile;
use Propel\TranslationBundle\Model\TranslationFileQuery;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Propel manager for bundle, loads and save data throught DataManagerInterface
 */
class Manager implements DataManagerInterface
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
     * model classes alias mapping
     * @var array
     */
    protected $modelAliases = array(
        'translation_key' => 'Propel\TranslationBundle\Model\TranslationKey',
        'translation_content' => 'Propel\TranslationBundle\Model\TranslationContent',
        'translation_file' => 'Propel\TranslationBundle\Model\TranslationFile',
    );

    /**
     * return model class name for alias @params
     * @param string $alias alias of classe searched
     * @return string
     */
    public function getModelClassName($alias)
    {
        if (empty($this->modelAliases[$alias])) {
            throw new \InvalidArgumentExeption(sprintf(
                'Unknown model class alias "%s". If you look really for that class, you have to define if in your data manager service.',
                 $alias
             ));
        }

        return $this->modelAliases[$alias];
    }


    /**
     * returns all domains
     * @return array
     */
    public function getAllDomains()
    {
        return TranslationKeyQuery::create()
            ->select(array('Domain'))
            ->distinct()
            ->find()
            ->getData();
    }

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

    /**
     * returns all keys as a paginated liste
     * @param array $locales locales to load
     * @param int $rows
     * @param int $page
     * @param array $filters
     * @return array
     */
    public function getKeysList(array $locales = null, $rows = 20, $page = 1, array $filters = array())
    {
        $sortColumn = isset($filters['sidx']) ? $filters['sidx'] : 'id';
        $order = isset($filters['sord']) ? $filters['sord'] : 'ASC';

        $idList = TranslationKeyQuery::create()
            ->select('Id')
            ->filterByLocaleAndOptions($locales, $filters)
            ->filterOnKeyOrDomain($filters)
            ->orderBy(ucfirst($sortColumn), $order)
            ->offset($rows * ($page-1))
            ->limit($rows)
            ->find()
            ->getData();

        if (empty($idList) < 0) {
            return array();
        }

        return TranslationKeyQuery::create()
            ->filterById($idList)
            ->useTranslationContentQuery()
                ->filterByLocale($locales)
            ->endUse()
            ->groupByKeyName()
            ->orderBy(ucfirst($sortColumn), $order)
            ->find()
            ->getData();
    }

    /**
     * count all TranslationKeys records
     * @param array $locales
     * @param array $filters
     * @return int
     */
    public function countKeys(array $locales, array $filters = array())
    {
        return TranslationKeyQuery::create()
            ->select(array('Id'))
            ->distinct()
            ->filterByLocaleAndOptions($locales, $filters)
            ->filterOnKeyOrDomain($filters)
            ->count();
    }

    /**
     * creates a new TranslationKey and TranslationContent for locales @params
     * @param array $locales
     * @return TranslationKey
     */
    public function createTranslationKey($locales)
    {
        $translationKey = new TranslationKey();

        foreach($locales as $locale) {
            $translationContent = new TranslationContent();
            $translationContent->setLocale($locale);
            $translationContent->setTranslationKey($translationKey);
        }

        return $translationKey;
    }

    /**
     * save translation keys into database, and related translation contents
     * @param mixed $translationKey
     */
    public function saveTranslationKey($translationKey)
    {
        $translationContents = $translationKey->getTranslationContents();
        foreach($translationContents as $translationContent) {
            if(!strlen($translationContent->getContent())) {
                $translationContents->setTranslationKey(null);
                continue; // only filled translation are stored
            }

            if (!$translationContent->getTranslationFile()) {
                $translationContent->setTranslationFile(
                    $this->findOrCreateTranslationFile(
                        $translationKey->getDomain(),
                        $translationContent->getLocale()
                    )
                );
            }
        }

        $translationKey->save();
    }

    /**
     * get or create a translation file for given domain and locale
     * @param string $domain
     * @param string $locale
     * @return TranslationFile
     */
    public function findOrCreateTranslationFile($domain, $locale)
    {
        $fileName = sprintf('%s.%s.yml', $domain, $locale);
        $filePath = $this->container->getParameter('propel.translation.gen_files_dir').'/Resources/translations';
        $hash = md5($fileName.'/'.$filePath);

        $file = TranslationFileQuery::create()
            ->filterByHash($hash)
            ->findOne();

        if(!$file) {
            $file = new TranslationFile();

            $file->setDomain($domain);
            $file->setLocale($locale);
            $file->setExtension('yml');
            $file->setPath($filePath);
            $file->setHash($hash);
            $file->save();
        }

        return $file;
    }

    /**
     * retrieve or create the translation content for given locale and key
     * @param TranslationKey $translationKey
     * @param string $locale
     * @return TranslationContent
     */
    protected function findOrCreateTranslationContent($translationKey, $locale)
    {
        foreach($translationKey->getTranslationContents() as $translationContent) {
            if($translationContent->getLocale() == $locale) {
                return $translationContent;
            }
        }

        $translationContent = new TranslationContent();
        $translationContent->setLocale($locale);
        $translationContent->setTranslationKey($translationKey);
        $translationContent->setTranslationFile(
            $this->findOrCreateTranslationFile(
                $translationKey->getDomain(),
                $translationContent->getLocale()
            )
        );

        return $translationContent;
    }

    /**
     * updates translations in database for id @params with values @params
     * @param int $translationKeyId
     * @param array $data array indexed locale => content
     * @throws IllegalArgumentException
     */
    public function updateTranslationKey($translationKeyId, array $data)
    {
        $translationKey = TranslationKeyQuery::create()
            ->findPk($translationKeyId);

        if(!$translationKey) {
            throw new \IllegalArgumentException('No translationKey found for id '.$translationKeyId);
        }

        foreach($data as $locale => $content) {
            $translationContent = $this->findOrCreateTranslationContent($translationKey, $locale);
            $translationContent->setContent($content);
            $translationKey->save();
        }
    }
}