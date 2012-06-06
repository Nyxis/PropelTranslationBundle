<?php

namespace Propel\TranslationBundle\Core;

use Symfony\Component\Config\ConfigCache;

class CacheManager
{
    /**
     * debug env
     * @var ConfigCache
     */
    protected $configCache;

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

}