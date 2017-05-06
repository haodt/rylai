<?php

namespace Rylai\Analyzers\Docblock\Tags;

/**
 * Generic tag for all custom and unsupported tags
 */
class Generic extends AbstractTag
{
    /**
     * Serialize to json
     * @return string
     */
    public function jsonSerialize()
    {
        $serialized            = parent::jsonSerialize();
        $serialized["content"] = $this->_tag->getDescription()->__toString();

        return $serialized;
    }
}
