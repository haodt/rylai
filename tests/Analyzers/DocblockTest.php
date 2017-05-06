<?php

namespace Rylai\Tests\Analyzers;

use PHPUnit\Framework\TestCase;
use Rylai\Analyzers\Docblock;
use Rylai\Analyzers\Docblock\AbstractReport;
use Rylai\Analyzers\Docblock\ReportFile;
use Rylai\Reflection\File;

/**
 * Test Docblock analyxer
 */
class DocblockTest extends TestCase
{

    /**
     * Report file used for testing
     * @var ReportFile
     */
    protected $_report;

    /**
     * Set up docblock
     * @return void
     */
    public function setUp()
    {
        $root     = __DIR__ . "/../../fixtures/";
        $file     = new File($root . "CrystalNova.php", $root);
        $docblock = new Docblock;

        $this->_report = $docblock->analyze($file);
    }

    /**
     * Tear down it
     * @return void
     */
    public function tearDown()
    {
        $this->_report = null;
    }

    public function testReport()
    {
        foreach ($this->_report->namespaces as $key => $namespace) {

            $this->_assert($namespace, "Rylai\Fixtures", "", "", []);
            $this->assertEquals($namespace->aliases, [
                [
                    "name"  => "Rylai\Fixtures\Items\Courier",
                    "alias" => "Courier",
                ],
                [
                    "name"  => "Rylai\Fixtures\Traits\SlowEffect",
                    "alias" => "SlowEffect",
                ],
            ]);

            foreach ($namespace->classes as $class) {
                $this->_assert(
                    $class,
                    "Rylai\Fixtures\CrystalNova",
                    "Main support skill",
                    "A burst of damaging frost slows enemy movement and attack rate in the targeted area",
                    []
                );

                /**
                 * Traits test
                 */

                $this->assertEquals(
                    [
                        "Rylai\Fixtures\Traits\SlowEffect",
                        "Rylai\Fixtures\Traits\SkillLevel",
                    ],
                    $class->traits
                );

                /**
                 * Interfaces test
                 */

                $this->assertEquals(
                    [
                        "Rylai\Fixtures\SkillInterface",
                    ],
                    $class->interfaces
                );

                /**
                 * Parent test
                 */

                $this->assertEquals(
                    [
                        "Rylai\Fixtures\Skill",
                    ],
                    $class->parents
                );

                /**
                 * Constants test
                 */

                $this->assertEquals(
                    [
                        [
                            "name"  => "DAMAGE",
                            "type"  => "string",
                            "value" => "MAGIC",
                        ],
                        [
                            "name"  => "RANGE",
                            "type"  => "integer",
                            "value" => 500,
                        ],
                        [
                            "name"  => "MAXRANGE",
                            "type"  => "integer",
                            "value" => 80000,
                        ],
                    ],
                    $class->constants
                );

                /**
                 * Properties test
                 */

                $this->assertEquals(count($class->properties), 7);
                foreach ($class->properties as $key => $property) {
                    switch ($key) {
                        case 0:
                            $this->assertEquals("?", $property->value);
                            $this->assertEquals($property->modifier, "public");
                            $this->assertEquals($property->type, "float");
                            $this->assertEquals($property->class, "Rylai\Fixtures\CrystalNova");
                            $this->_assert(
                                $property,
                                "castAnimation",
                                "Cast Animation",
                                "",
                                []
                            );
                            break;
                        case 1:
                            $this->assertEquals("?", $property->value);
                            $this->assertEquals($property->modifier, "public");
                            $this->assertEquals($property->type, "int");
                            $this->assertEquals($property->class, "Rylai\Fixtures\CrystalNova");
                            $this->_assert(
                                $property,
                                "castRange",
                                "Cast Range",
                                "",
                                []
                            );
                            break;
                        case 2:
                            $this->assertEquals("?", $property->value);
                            $this->assertEquals($property->modifier, "public");
                            $this->assertEquals($property->type, "string");
                            $this->assertEquals($property->class, "Rylai\Fixtures\CrystalNova");
                            $this->_assert(
                                $property,
                                "description",
                                "Effect description",
                                "Slow persists if debuff was placed before spell immunity and when not dispelled.",
                                []
                            );
                            break;
                        case 3:
                            $this->assertEquals("?", $property->value);
                            $this->assertEquals($property->modifier, "protected");
                            $this->assertEquals($property->type, "\Courier");
                            $this->assertEquals($property->class, "Rylai\Fixtures\CrystalNova");
                            $this->_assert(
                                $property,
                                "_courier",
                                "Courier bought",
                                "",
                                []
                            );
                            break;
                        // Inherit
                        case 4:
                            $this->assertEquals("?", $property->value);
                            $this->assertEquals($property->modifier, "protected");
                            $this->assertEquals($property->type, "int");
                            $this->assertEquals($property->class, "Rylai\Fixtures\Traits\SlowEffect");
                            $this->_assert(
                                $property,
                                "_duration",
                                "Slow duration",
                                "Calculate by seconds",
                                []
                            );
                            break;
                        case 5:
                            $this->assertEquals("?", $property->value);
                            $this->assertEquals($property->modifier, "protected");
                            $this->assertEquals($property->type, "int");
                            $this->assertEquals($property->class, "Rylai\Fixtures\Skill");
                            $this->_assert(
                                $property,
                                "_triggered",
                                "Total trigger time",
                                "",
                                []
                            );
                            break;
                        case 6:
                            $this->assertEquals("?", $property->value);
                            $this->assertEquals($property->modifier, "protected");
                            $this->assertEquals($property->type, "int");
                            $this->assertEquals($property->class, "Rylai\Fixtures\Traits\SkillLevel");
                            $this->_assert(
                                $property,
                                "_level",
                                "Skill level",
                                "",
                                []
                            );
                            break;
                    }
                }

                /**
                 * Methods test
                 */

                $this->assertEquals(count($class->methods), 4);
                foreach ($class->methods as $key => $method) {
                    switch ($key) {
                        case 0:
                            $this->assertEquals(
                                "cast(\$mana = 200,Rylai\Fixtures\Items\Courier \$courier)",
                                $method->signature
                            );
                            $this->assertEquals($method->class, "Rylai\Fixtures\CrystalNova");
                            $this->_assert(
                                $method,
                                "cast",
                                "The air temperature around Rylai drops rapidly, chilling all around her to the core.",
                                "",
                                [
                                    [
                                        "name"    => "todo",
                                        "content" => "test",
                                    ],
                                    [
                                        "name"        => "link",
                                        "description" => "For example",
                                        "link"        => "http://github.com",
                                    ],
                                    [
                                        "name"        => "param",
                                        "type"        => "mixed",
                                        "variable"    => "mana",
                                        "description" => "Mana cost",
                                    ],
                                    [
                                        "name"        => "param",
                                        "type"        => "\Courier",
                                        "variable"    => "courier",
                                        "description" => "Buy courier",
                                    ],
                                    [
                                        "name"        => "return",
                                        "type"        => "void",
                                        "description" => "",
                                    ],
                                ]
                            );
                            $this->assertEquals($method->class, "Rylai\Fixtures\CrystalNova");
                            break;

                        case 1:
                            $this->assertEquals(
                                "setSlowDuration(\$duration)",
                                $method->signature
                            );
                            $this->_assert(
                                $method,
                                "setSlowDuration",
                                "Set slow duration",
                                "",
                                [
                                    [
                                        "name"        => "param",
                                        "type"        => "int",
                                        "variable"    => "duration",
                                        "description" => "",
                                    ],
                                    [
                                        "name"        => "return",
                                        "type"        => "void",
                                        "description" => "",
                                    ],
                                ]
                            );
                            $this->assertEquals($method->class, "Rylai\Fixtures\Traits\SlowEffect");
                            break;

                        case 2:
                            $this->assertEquals(
                                "trigger(\$item)",
                                $method->signature
                            );
                            $this->_assert(
                                $method,
                                "trigger",
                                "Trigger item",
                                "",
                                [
                                    [
                                        "name"        => "param",
                                        "type"        => "mixed",
                                        "variable"    => "item",
                                        "description" => "",
                                    ],
                                    [
                                        "name"        => "return",
                                        "type"        => "void",
                                        "description" => "",
                                    ],
                                ]
                            );
                            $this->assertEquals($method->class, "Rylai\Fixtures\Skill");
                            break;

                        case 3:
                            $this->assertEquals(
                                "levelUpSkill(\$level)",
                                $method->signature
                            );
                            $this->_assert(
                                $method,
                                "levelUpSkill",
                                "Set skill level",
                                "",
                                [
                                    [
                                        "name"        => "param",
                                        "type"        => "int",
                                        "variable"    => "level",
                                        "description" => "",
                                    ],
                                ]
                            );
                            $this->assertEquals($method->class, "Rylai\Fixtures\Traits\SkillLevel");
                            break;
                    }
                }

            }
        }
    }

    /**
     * Assert summary name description and tags as standards properties
     * @param  AbstractReport $report
     * @param  string         $name
     * @param  string         $summary
     * @param  string         $description
     * @param  string         $tags
     * @return string
     */
    protected function _assert(AbstractReport $report, $name, $summary, $description, $tags)
    {
        $this->assertEquals($name, $report->name);
        $this->assertEquals($summary, $report->summary);
        $this->assertEquals($description, $report->description);
        $this->assertEquals($tags, $report->tags);
    }
}
