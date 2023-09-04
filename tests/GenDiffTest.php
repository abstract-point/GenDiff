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

    /**
     * @covers Php\Project\GenDiff\genDiff
     * @covers Php\Project\GenDiff\buildDiffTree
     * @covers Php\Project\Parsers\parseFile
     * @covers Php\Project\Formatters\Stylish\renderStylish
     * @covers Php\Project\Formatters\Stylish\iter
     * @covers Php\Project\Formatters\Stylish\stringify
     */
    public function testGenDiffNestedJsonStylish()
    {
        $firstFilePath = $this->getFilePath("fileNested1.json");
        $secondFilePath = $this->getFilePath("fileNested2.json");

        $expected = file_get_contents($this->getFilePath("resultNested.txt"));
        $actual = genDiff($firstFilePath, $secondFilePath, 'stylish');

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Php\Project\GenDiff\genDiff
     * @covers Php\Project\GenDiff\buildDiffTree
     * @covers Php\Project\Parsers\parseFile
     * @covers Php\Project\Formatters\Stylish\renderStylish
     * @covers Php\Project\Formatters\Stylish\iter
     * @covers Php\Project\Formatters\Stylish\stringify
     */
    public function testGenDiffNestedYamlStylish()
    {
        $firstFilePath = $this->getFilePath("fileNested1.yml");
        $secondFilePath = $this->getFilePath("fileNested2.yml");

        $expected = file_get_contents($this->getFilePath("resultNested.txt"));
        $actual = genDiff($firstFilePath, $secondFilePath, 'stylish');

        $this->assertEquals($expected, $actual);
    }
}