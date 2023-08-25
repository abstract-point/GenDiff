<?php
namespace Php\Project\Tests;

use PHPUnit\Framework\TestCase;
use function Php\Project\GenDiff\genDiff;

class GenDiffTest extends TestCase
{
    private string $path = __DIR__ . "/fixtures/";

    public function getFilePath($name)
    {
        return $this->path . $name;
    }

    public function testGenDiffFlat()
    {
        $file1 = $this->getFilePath("file1.json");
        $file2 = $this->getFilePath("file2.json");
        $expected = file_get_contents($this->getFilePath("result.txt"));
        $actual = genDiff($file1, $file2);

        $this->assertEquals($expected, $actual);
    }
}