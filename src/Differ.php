<?php

namespace Differ\Differ;

use function Differ\Parsers\parseFile;
use function Differ\Formatters\render;
use function Functional\sort as immutableSort;

function genDiff(string $firstFilePath, string $secondFilePath, string $format = "stylish")
{
    $firstFileData = parseFile($firstFilePath);
    $secondFileData = parseFile($secondFilePath);

    $diffTree = buildDiffTree($firstFileData, $secondFileData);

    return render($diffTree, $format);
}

function buildDiffTree(mixed $firstFileData, mixed $secondFileData)
{
    $firstFileDataArray = (array) $firstFileData;
    $secondFileDataArray = (array) $secondFileData;
    $mergedKeys = prepareKeys($firstFileDataArray, $secondFileDataArray);

    $tree = array_map(
        function ($key) use ($firstFileDataArray, $secondFileDataArray) {
            if (!array_key_exists($key, $firstFileDataArray)) {
                return ["key" => $key, "value" => $secondFileDataArray[$key], "type" => "added"];
            }
            if (!array_key_exists($key, $secondFileDataArray)) {
                return ["key" => $key, "value" => $firstFileDataArray[$key], "type" => "removed"];
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

function prepareKeys(array $array1, array $array2)
{
    $mergedArray = array_merge($array1, $array2);
    $mergedKeys = array_keys($mergedArray);

    return immutableSort($mergedKeys, fn ($left, $right) => strcmp($left, $right));
}
