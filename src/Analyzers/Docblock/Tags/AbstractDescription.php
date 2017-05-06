<?php

namespace Rylai\Analyzers\Docblock\Tags;

/**
 * Tag which having description
 */
abstract class AbstractDescription extends AbstractTag
{
    /**
     * Serialize to json
     * @return string
     */
    public function jsonSerialize()
    {
        $serialized                = parent::jsonSerialize();
        $serialized["description"] = (string) $this->_tag->getDescription();

        return $serialized;
    }
}
