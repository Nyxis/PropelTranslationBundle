<?php

namespace Propel\TranslationBundle\Core;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Finder\Finder;

/**
 * Translation cache manager class
 *
 */
class CacheManager
{
    /**
     * debug env
     * @var ConfigCache
     */
    protected $configCache;

    /**
     * cache dir path for current app
     * @var string
     */
    protected $appCacheDir;

    /**
     * root dir path, used for multi-app support
     * @var string
     */
    protected $projectRootDir;

    /**
     * flag to activate if bundle has to managed multiple cache dirs
     * @var bool
     */
    protected $multiApp;

    /**
     * cache file path
     * @var string
     */
    protected $cacheFile;

    /**
     * Constructor.
     *
     * @param string $cacheDir
     * @param bool $debug
     * @param bool $multiApp
     * @param string $projectRootDir
     */
    public function __construct($cacheDir, $debug, $multiApp, $projectRootDir)
    {
        $this->appCacheDir = $cacheDir;
        $this->cacheFile = sprintf('%s/database.resources.php', $cacheDir);
        $this->configCache = new ConfigCache($this->cacheFile, $debug);

        $this->multiApp = $multiApp;
        $this->projectRootDir = $projectRootDir;
    }

    /**
     * configCache method alias for cache validation
     * @return bool
     */
    public function isFresh()
    {
        return false;
        return $this->configCache->isFresh();
    }

    /**
     * configCache method alias for cache writting
     * @param string $content
     * @param mixed $metadata
     */
    public function write($content, $metadata)
    {
        return $this->configCache->write($content, $metadata);
    }

    /**
     * includes cache file and returns it's content
     * @return mixed
     */
    public function getContent()
    {
        return include $file;
    }

    /**
     * returns dir's path to look in for cache files
     * @return string
     */
    protected function getRootPathForCacheFinder()
    {
        return empty($this->multiApp) ?
            $this->appCacheDir : // only this app
            $this->projectRootDir; // all project
    }

    /**
     * removes all cache files for locales @params
     * @param array $locales list of locales to remove
     * @throws RuntimeException
     */
    public function removeLocalesFiles(array $locales)
    {
        $finder = new Finder();

        foreach($locales as $locale) { // base catalogues and meta files
            $finder->files()->name(sprintf('catalogue.%s.php*', $locale));
        }

        $finder->files()->name('database.resources.php*') // resources for triggering cache rebuild
            ->in($this->getRootPathForCacheFinder());

        foreach($finder as $file) {
            if (preg_match('/.*\/cache\/[\w]+\/translations\/.*/', $file->getRelativePath())) {
                continue; // lock, delete only in "translations" dirs
            }

            if (!unlink($file->getRealpath())) {
                throw new \RuntimeException(sprintf('Delete "%s" cache file failed.',
                    $file->getRealpath()
                ));
            }
        }
    }
}