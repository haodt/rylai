<?php

namespace Rylai\Analyzers\Docblock\Tags;

/**
 * Return_ tag for method
 */
class Return_ extends AbstractDescription
{
    public function __construct(\phpDocumentor\Reflection\DocBlock\Tags\Return_ $tag)
    {
        parent::__construct($tag);
    }
    /**
     * Serialize to json
     * @return string
     */
    public function jsonSerialize()
    {
        $serialized         = parent::jsonSerialize();
        $serialized["type"] = (string) $this->_tag->getType();

        return $serialized;
    }
}
