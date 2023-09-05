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
     * @covers Php\Project\Formatters\render
     * @covers Php\Project\GenDiff\buildDiffTree
     * @covers Php\Project\GenDiff\prepareKeys
     * @covers Php\Project\Parsers\parseFile
     * @covers Php\Project\Formatters\Stylish\renderStylish
     * @covers Php\Project\Formatters\Stylish\stringify
     * @covers Php\Project\Formatters\Plain\renderPlain
     * @covers Php\Project\Formatters\Plain\stringify
     */
    public function testGenDiffNestedJsonStylish()
    {
        $firstFilePath = $this->getFilePath("fileNested1.json");
        $secondFilePath = $this->getFilePath("fileNested2.json");

        $expected = file_get_contents($this->getFilePath("resultNestedStylish.txt"));
        $actual = genDiff($firstFilePath, $secondFilePath, 'stylish');

        $expectedPlain = file_get_contents($this->getFilePath("resultNestedPlain.txt"));
        $actualPlain = genDiff($firstFilePath, $secondFilePath, 'plain');

        $this->assertEquals($expected, $actual);
        $this->assertEquals($expectedPlain, $actualPlain);
    }

    /**
     * @covers Php\Project\GenDiff\genDiff
     * @covers Php\Project\Formatters\render
     * @covers Php\Project\GenDiff\buildDiffTree
     * @covers Php\Project\GenDiff\prepareKeys
     * @covers Php\Project\Parsers\parseFile
     * @covers Php\Project\Formatters\Stylish\renderStylish
     * @covers Php\Project\Formatters\Stylish\stringify
     * @covers Php\Project\Formatters\Plain\renderPlain
     * @covers Php\Project\Formatters\Plain\stringify
     */
    public function testGenDiffNestedYamlStylish()
    {
        $firstFilePath = $this->getFilePath("fileNested1.yml");
        $secondFilePath = $this->getFilePath("fileNested2.yml");

        $expectedStylish = file_get_contents($this->getFilePath("resultNestedStylish.txt"));
        $actualStylish = genDiff($firstFilePath, $secondFilePath, 'stylish');

        $expectedPlain = file_get_contents($this->getFilePath("resultNestedPlain.txt"));
        $actualPlain = genDiff($firstFilePath, $secondFilePath, 'plain');

        $this->assertEquals($expectedStylish, $actualStylish);
        $this->assertEquals($expectedPlain, $actualPlain);
    }
}
