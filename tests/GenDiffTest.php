<?php

namespace Php\Project\Tests;

use PHPUnit\Framework\TestCase;
use function Php\Project\GenDiff\genDiff;
use function Php\Project\Parsers\parseFile;

class GenDiffTest extends TestCase
{
    private string $path = __DIR__ . "/fixtures/";

    public function getFilePath($name)
    {
        return $this->path . $name;
    }
    /**
     * @covers Php\Project\Parsers\parseFile
     * @covers Php\Project\GenDiff\genDiff
     * @covers Php\Project\GenDiff\boolValueDisplay
     */
    public function testGenDiffFlatJson()
    {
        $firstFilePath = $this->getFilePath("file1.json");
        $secondFilePath = $this->getFilePath("file2.json");

        $firstFileData = parseFile($firstFilePath);
        $secondFileData = parseFile($secondFilePath);

        $expected = file_get_contents($this->getFilePath("result.txt"));
        $actual = genDiff($firstFileData, $secondFileData);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Php\Project\Parsers\parseFile
     * @covers Php\Project\GenDiff\genDiff
     * @covers Php\Project\GenDiff\boolValueDisplay
     */
    public function testGenDiffFlatYaml()
    {
        $firstFilePath = $this->getFilePath("file1.yml");
        $secondFilePath = $this->getFilePath("file2.yml");

        $firstFileData = parseFile($firstFilePath);
        $secondFileData = parseFile($secondFilePath);

        $expected = file_get_contents($this->getFilePath("result.txt"));
        $actual = genDiff($firstFileData, $secondFileData);

        $this->assertEquals($expected, $actual);
    }
}