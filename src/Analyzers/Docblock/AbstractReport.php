<?php

namespace Rylai\Analyzers\Docblock;

use phpDocumentor\Reflection\DocBlock as DocumentorDocblock;
use phpDocumentor\Reflection\DocBlockFactory;
use Rylai\Analyzers\Docblock\Tags\AbstractTag;

/**
 * Report of analyzed file
 */
abstract class AbstractReport implements \JsonSerializable
{
    /**
     * Storing properties inside array for ease in serialize and unserialize
     * @var array
     */
    protected $_properties;

    /**
     * Allowed properties
     * @var string[]
     */
    protected $_alloweds = false;

    public function __construct()
    {
        $this->_alloweds = ["name", "summary", "description", "tags"];
    }

    /**
     * Serialize to json
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->_properties;
    }

    /**
     * Test if property is allowed
     * @param  string  $property
     * @return boolean
     */
    protected function _isAllowed($property)
    {
        return in_array($property, $this->_alloweds);
    }

    /**
     * Test if property exists
     * @param  string  $property
     * @return boolean
     */
    public function __isset($property)
    {
        return $this->_isAllowed($property);
    }

    /**
     * Magic method for setter
     * @param string $property
     * @param any $value
     */
    public function __set($property, $value)
    {
        if (!$this->_isAllowed($property)) {
            throw new \Exception("Property $property is not writable");
        }
        $this->_properties[$property] = $value;
    }

    /**
     * Magic method for getter
     * @param string $property
     * @return var
     */
    public function __get($property)
    {
        if (!$this->_isAllowed($property)) {
            throw new \Exception("Property $property is not readable");
        }
        if (!isset($this->_properties[$property])) {
            return null;
        }
        return $this->_properties[$property];
    }

    /**
     * Parse target and read docblock
     *
     * We separated some standard tags like params,return,link ... in phpdocumentor for different arrays with special properties . Other tags will just be name,content pairs
     *
     * @param mixed $target
     * @param DocBlockFactory $factory
     * @return DocumentorDocblock
     */
    public function parse($target, DocBlockFactory $factory)
    {
        $this->name = $target->getName();
        $doccomment = (method_exists($target, "getDocComment")) ? $target->getDocComment() : "";
        $doccomment = ($doccomment) ?: "/** */";
        $docblock   = $factory->create($doccomment);

        $this->summary     = $docblock->getSummary();
        $this->description = (string) $docblock->getDescription();

        $tags = [];
        foreach ($docblock->getTags() as $tag) {
            $tags[] = AbstractTag::create($tag)->toArray();
        }

        $this->tags = $tags;

        call_user_func_array([$this, "_afterParse"], [$target, $factory, $docblock]);
    }
}
