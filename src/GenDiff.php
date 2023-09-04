<?php

namespace Php\Project\GenDiff;

use function Php\Project\Parsers\parseFile;
use function Php\Project\Formatters\Stylish\renderStylish;

function run($firstFilePath, $secondFilePath, $format)
{
    echo genDiff($firstFilePath, $secondFilePath, $format);
    exit;
}

function genDiff($firstFilePath, $secondFilePath, $format)
{
    $firstFileData = parseFile($firstFilePath);
    $secondFileData = parseFile($secondFilePath);

    $diffTree = buildDiffTree($firstFileData, $secondFileData);

    switch ($format) {
        case "stylish":
            $result = renderStylish($diffTree);
            break;
    }

    return $result;
}

function buildDiffTree($firstFileData, $secondFileData)
{
    $firstFileDataArray = (array) $firstFileData;
    $secondFileDataArray = (array) $secondFileData;

    $mergedKeys = array_keys(array_merge($firstFileDataArray, $secondFileDataArray));

    sort($mergedKeys);

    $tree = array_map(
        function ($key) use ($firstFileDataArray, $secondFileDataArray) {
            if (!array_key_exists($key, $firstFileDataArray)) {
                return ["key" => $key, "value" => $secondFileDataArray[$key], "type" => "plus"];
            }
            if (!array_key_exists($key, $secondFileDataArray)) {
                return ["key" => $key, "value" => $firstFileDataArray[$key], "type" => "minus"];
            }

            $firstNode = $firstFileDataArray[$key];
            $secondNode = $secondFileDataArray[$key];

            if ((is_object($firstNode) && is_object($secondNode)) || (is_array($firstNode) && is_array($secondNode))) {
                $children = buildDiffTree($firstNode, $secondNode);
                return ["key" => $key, "type" => "parent", "children" => $children];
            }
            if ($firstNode === $secondNode) {
                return ["key" => $key, "value" => $firstNode, "type" => "same"];
            } else {
                return ["key" => $key, "firstValue" => $firstNode, "secondValue" => $secondNode, "type" => "changed"];
            }
        },
        $mergedKeys
    );
    return $tree;
}
