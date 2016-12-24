<?php

namespace Rylai\Reflection;

use Go\ParserReflection\ReflectionFile;

class File
{
    protected $_reflection;

    protected $_name;

    public function __construct($path, $root)
    {

        $this->_name       = str_replace($root, "", $path);
        $this->_reflection = new ReflectionFile($path);

    }

    public function getName()
    {
        return $this->_name;
    }

    public function getReflection()
    {
        return $this->_reflection;
    }
}
