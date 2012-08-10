<?php

namespace Propel\TranslationBundle\Core\Cache;

use Symfony\Component\Finder\Finder;

/**
 * Translation cache manager class
 *
 */
class Manager
{
    /**
     * config cache object list to manage
     * @var ConfigCache
     */
    protected $cacheFileList;

    /**
     * Constructor.
     *
     * @param string $cacheDir
     * @param bool   $debug
     * @param string $projectRootDir
     */
    public function __construct(array $cacheDirList, $debug)
    {
        $this->cacheFileList = array();
        foreach ($cacheDirList as $cacheDir) {
            $this->cacheFileList[] = new File(sprintf('%s/database.resources.php', $cacheDir), $debug);
        }
    }

    /**
     * test if managed cached files are fresh
     * @return bool
     */
    public function isFresh()
    {
        foreach ($this->cacheFileList as $cacheFile) {
            if (!$cacheFile->isFresh()) {
                return false;
            }
        }

        return true;
    }

    /**
     * write content and metadata in managed cache files
     * @param string $content
     * @param mixed  $metadata
     */
    public function write($content, $metadata)
    {
        foreach ($this->cacheFileList as $cacheFile) {
            $cacheFile->write($content, $metadata);
        }
    }

    /**
     * includes cache file and returns it's content
     * @return mixed
     */
    public function getContent()
    {
        $return = array();
        foreach ($this->cacheFileList as $cacheFile) {
            $return = array_replace_recursive(
                $return, include $cacheFile->getFilepath()
            );
        }

        return $return;
    }

    /**
     * removes all cache files for locales @params
     * @param  array            $locales list of locales to remove
     * @throws RuntimeException
     */
    public function removeLocalesFiles(array $locales)
    {
        $finder = new Finder();
        $finder->files()
            ->filter(function($file){ // filter "cache" directories

                return preg_match('/.*\/cache\/[\w]+\/translations\/.*/', $file->getRealPath());
            });

        foreach ($locales as $locale) { // base catalogues and meta files
            $finder->name(sprintf('catalogue.%s.php*', $locale));
        }

        foreach ($this->cacheFileList as $cacheFile) {
            $finder->name($cacheFile->getFilename().'*') // for meta too
                ->in($cacheFile->getDirname()); // scratch only managed directories
        }

        foreach ($finder as $file) {
            if (!unlink($file->getRealpath())) {
                throw new \RuntimeException(sprintf('Delete "%s" cache file failed.',
                    $file->getRealpath()
                ));
            }
        }
    }
}
