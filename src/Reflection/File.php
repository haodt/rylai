<?php

namespace Rylai\Reflection;

use Go\ParserReflection\ReflectionFile;

/**
 * File abstraction
 *
 * From raw file name eg `/var/www/SomeClass.php`
 */
class File
{
    /**
     * File reflection with attribute needed
     * @var ReflectionFile
     */
    protected $_reflection;

    /**
     * File name as in absolute path + file name
     * @var string
     */
    protected $_name;

    /**
     * Constructing instance
     *
     * File name will be cut from difference between path to file and root path eg for path as `/var/www/test/sample/Test.php` and root as `/var/www/test/` , name will be sample/Test.php
     * @param string $path
     * @param string $root
     */
    public function __construct($path, $root)
    {

        $this->_name       = str_replace($root, "", $path);
        $this->_reflection = new ReflectionFile($path);

    }

    /**
     * Get file name
     *
     * This will be used for identify file in report
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Get file reflection
     *
     * File reflection about its properties , methods ...
     * @return ReflectionFile
     */
    public function getReflection()
    {
        return $this->_reflection;
    }
}
