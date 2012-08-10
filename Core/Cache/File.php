<?php

namespace Propel\TranslationBundle\Core\Cache;

use Symfony\Component\Config\ConfigCache;

/**
 * translation cache file
 * override ConfigCache class for accessing attributes
 */
class File extends ConfigCache
{
    /**
     * cache dirname
     * @var string
     */
    protected $dirname;

    /**
     * cache file name
     * @var string
     */
    protected $filename;

    /**
     * Constructor.
     *
     * @param string  $filepath The absolute cache path
     * @param Boolean $debug    Whether debugging is enabled or not
     */
    public function __construct($filepath, $debug)
    {
        parent::__construct($filepath, $debug);

        $this->filename = basename($filepath);
        $this->dirname = dirname($filepath);
    }

    /**
     * return cache file dirname
     * @return string
     */
    public function getDirname()
    {
        return $this->dirname;
    }

    /**
     * return cache file name
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * return complete cache file path
     * @return string
     */
    public function getFilepath()
    {
        return sprintf('%s/%s',
            $this->getDirname(),
            $this->getFilename()
        );
    }

}
