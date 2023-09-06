<?php

namespace Php\Project\GenDiff;

use function Php\Project\Parsers\parseFile;
use function Php\Project\Formatters\render;
use function Functional\sort as immutableSort;

function genDiff($firstFilePath, $secondFilePath, $format)
{
    $firstFileData = parseFile($firstFilePath);
    $secondFileData = parseFile($secondFilePath);

    $diffTree = buildDiffTree($firstFileData, $secondFileData);
    //print_r($diffTree);exit;

    return render($diffTree, $format);
}

function buildDiffTree($firstFileData, $secondFileData)
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

function prepareKeys($array1, $array2)
{
    $mergedArray = array_merge($array1, $array2);
    $mergedKeys = array_keys($mergedArray);

    return immutableSort($mergedKeys, fn ($left, $right) => strcmp($left, $right));
}
