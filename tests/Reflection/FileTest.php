<?php

namespace Rylai\Tests\Reflection;

use PHPUnit\Framework\TestCase;
use Rylai\Reflection\File;

/**
 * Test file reflection
 */
class FileTest extends TestCase
{
    /**
     * @dataProvider fileProvider
     */
    public function testName(File $file, $name)
    {
        $this->assertEquals($file->getName(), $name);
    }

    public function fileProvider()
    {
        $root = __DIR__ . "/../../fixtures/";
        return [
            [
                new File($root . "CrystalNova.php", $root),
                "CrystalNova.php",
            ],
            [
                new File($root . "Items/Courier.php", $root),
                "Items/Courier.php",
            ],
        ];
    }
}
