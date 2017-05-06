<?php

namespace Rylai\Analyzers\Docblock\Tags;

use phpDocumentor\Reflection\DocBlock\Tag;

/**
 * Tag abstraction for serialize and unserialize
 */
abstract class AbstractTag implements \JsonSerializable
{
    /**
     * Tag
     * @var Tag
     */
    protected $_tag;

    public function __construct(Tag $tag)
    {
        $this->_tag = $tag;
    }

    /**
     * Create new tag with type enforced
     * @param  Tag    $tag
     * @return AbstractTag
     */
    public static function create(Tag $tag)
    {
        switch (get_class($tag)) {
            case "phpDocumentor\Reflection\DocBlock\Tags\Link":
                return new Link($tag);
            case "phpDocumentor\Reflection\DocBlock\Tags\Param":
                return new Param($tag);
            case "phpDocumentor\Reflection\DocBlock\Tags\Return_":
                return new Return_($tag);
            default:
                return new Generic($tag);
        }
    }

    /**
     * Serialize to json
     * @return string
     */
    public function jsonSerialize()
    {
        return [
            "name" => $this->_tag->getName(),
        ];
    }

    /**
     * Convert to array for easier testing
     * @return array
     */
    public function toArray()
    {
        return $this->jsonSerialize();
    }
}
