<?php

namespace Rylai\Analyzers\Docblock\Tags;

/**
 * Param tag for method
 */
class Param extends AbstractDescription
{
    public function __construct(\phpDocumentor\Reflection\DocBlock\Tags\Param $tag)
    {
        parent::__construct($tag);
    }
    /**
     * Serialize to json
     * @return string
     */
    public function jsonSerialize()
    {
        $serialized             = parent::jsonSerialize();
        $serialized["variable"] = $this->_tag->getVariableName();
        $serialized["type"]     = (string) $this->_tag->getType();

        return $serialized;
    }
}
