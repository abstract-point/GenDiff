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
     * @covers Php\Project\Formatters\Json\renderJson
     */
    public function testGenDiffJson()
    {
        $firstFilePath = $this->getFilePath("file1.json");
        $secondFilePath = $this->getFilePath("file2.json");

        $expected = file_get_contents($this->getFilePath("resultStylish.txt"));
        $actual = genDiff($firstFilePath, $secondFilePath, 'stylish');

        $expectedPlain = file_get_contents($this->getFilePath("resultPlain.txt"));
        $actualPlain = genDiff($firstFilePath, $secondFilePath, 'plain');

        $expectedJson = file_get_contents($this->getFilePath("resultJson.txt"));
        $actualJson = genDiff($firstFilePath, $secondFilePath, 'json');

        $this->assertEquals($expected, $actual);
        $this->assertEquals($expectedPlain, $actualPlain);
        $this->assertEquals($expectedJson, $actualJson);
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
     * @covers Php\Project\Formatters\Json\renderJson
     */
    public function testGenDiffYaml()
    {
        $firstFilePath = $this->getFilePath("file1.yml");
        $secondFilePath = $this->getFilePath("file2.yml");

        $expectedStylish = file_get_contents($this->getFilePath("resultStylish.txt"));
        $actualStylish = genDiff($firstFilePath, $secondFilePath, 'stylish');

        $expectedPlain = file_get_contents($this->getFilePath("resultPlain.txt"));
        $actualPlain = genDiff($firstFilePath, $secondFilePath, 'plain');

        $expectedJson = file_get_contents($this->getFilePath("resultJson.txt"));
        $actualJson = genDiff($firstFilePath, $secondFilePath, 'json');

        $this->assertEquals($expectedStylish, $actualStylish);
        $this->assertEquals($expectedPlain, $actualPlain);
        $this->assertEquals($expectedJson, $actualJson);
    }
}
