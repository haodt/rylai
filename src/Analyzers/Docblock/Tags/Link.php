<?php

namespace Rylai\Analyzers\Docblock\Tags;

/**
 * Link tag
 */
class Link extends AbstractDescription
{

    public function __construct(\phpDocumentor\Reflection\DocBlock\Tags\Link $tag)
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
        $serialized["link"] = $this->_tag->getLink();

        return $serialized;
    }
}
