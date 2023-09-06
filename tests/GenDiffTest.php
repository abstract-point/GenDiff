<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class GenDiffTest extends TestCase
{
    private string $path = __DIR__ . "/fixtures/";

    public function getFilePath($name)
    {
        return $this->path . $name;
    }

    /**
     * @covers Differ\Differ\genDiff
     * @covers Differ\Formatters\render
     * @covers Differ\Differ\buildDiffTree
     * @covers Differ\Differ\prepareKeys
     * @covers Differ\Parsers\parseFile
     * @covers Differ\Formatters\Stylish\renderStylish
     * @covers Differ\Formatters\Stylish\stringify
     * @covers Differ\Formatters\Plain\renderPlain
     * @covers Differ\Formatters\Plain\stringify
     * @covers Differ\Formatters\Json\renderJson
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
     * @covers Differ\Differ\genDiff
     * @covers Differ\Formatters\render
     * @covers Differ\Differ\buildDiffTree
     * @covers Differ\Differ\prepareKeys
     * @covers Differ\Parsers\parseFile
     * @covers Differ\Formatters\Stylish\renderStylish
     * @covers Differ\Formatters\Stylish\stringify
     * @covers Differ\Formatters\Plain\renderPlain
     * @covers Differ\Formatters\Plain\stringify
     * @covers Differ\Formatters\Json\renderJson
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
