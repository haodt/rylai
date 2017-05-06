<?php

namespace Rylai\Analyzers\Docblock;

use phpDocumentor\Reflection\Docblock;
use phpDocumentor\Reflection\DocblockFactory;

/**
 * Report method of class
 */
class ReportMethod extends AbstractReport
{
    public function __construct()
    {
        parent::__construct();
        $this->_alloweds = array_merge($this->_alloweds, ["modifier", "signature", "class"]);
    }

    /**
     * Report method signature and params
     *
     * @param  \ReflectionMethod $target
     * @param  DocblockFactory  $factory
     * @param  Docblock         $docblock
     * @return void
     */
    protected function _afterParse(\ReflectionMethod $target, DocblockFactory $factory, Docblock $docblock)
    {
        $this->modifier  = implode(" ", \Reflection::getModifierNames($target->getModifiers()));
        $this->signature = $target->getName();
        $this->class     = $target->getDeclaringClass()->getName();

        $params = [];
        foreach ($target->getParameters() as $param) {

            $type    = ($param->getType()) ? $param->getType() . " " : "";
            $default = "";
            if ($param->isDefaultValueAvailable()) {
                $default = $param->getDefaultValue();
                $default = is_array($default) ? "[" . implode(",", $default) . "]" : $default;
                $default = is_bool($default) ? (($default) ? "true" : "false") : $default;
                $default = " = " . $default;
            }
            $name = "$" . $param->getName();

            $params[] = $type . $name . $default;
        }

        $this->signature .= "(" . implode(",", $params) . ")";
    }
}
