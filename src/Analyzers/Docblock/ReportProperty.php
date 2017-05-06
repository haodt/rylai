<?php

namespace Rylai\Analyzers\Docblock;

use phpDocumentor\Reflection\Docblock;
use phpDocumentor\Reflection\DocblockFactory;

/**
 * Report property of class
 */
class ReportProperty extends AbstractReport
{
    public function __construct()
    {
        parent::__construct();
        $this->_alloweds = array_merge($this->_alloweds, ["value", "modifier", "type", "class"]);
    }
    /**
     * Parse property
     *
     * @todo Fetch default value at runtime, right not property with default value will display as `?`
     * @param  \ReflectionProperty   $target
     * @param  DocblockFactory      $factory
     * @param  Docblock             $docblock
     * @return void
     */
    protected function _afterParse(\ReflectionProperty $target, DocblockFactory $factory, Docblock $docblock)
    {
        $this->value    = $target->isDefault() ? "?" : null;
        $this->modifier = implode(" ", \Reflection::getModifierNames($target->getModifiers()));
        $this->class    = $target->getDeclaringClass()->getName();

        foreach ($docblock->getTagsByName("var") as $var) {
            $this->type = (string) $var->getType();
        }

        $this->tags = array_filter($this->tags, function ($tag) {
            return $tag["name"] != "var";
        });
    }
}
