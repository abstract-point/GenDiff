<?php

namespace Php\Project\GenDiff;

use function Php\Project\Parsers\parseFile;

function run($firstFile, $secondFile)
{
    //var_dump(__DIR__);exit;
    
    $firstFileData = parseFile($firstFile);
    $secondFileData = parseFile($secondFile);

    echo genDiff($firstFileData, $secondFileData);
}

function genDiff($firstFileData, $secondFileData)
{
    //TODO: стоит попробовать использовать var_export($value, true)
    boolValueDisplay($firstFileData);
    boolValueDisplay($secondFileData);
    
    $mergedFile = array_merge($firstFileData, $secondFileData);
    ksort($mergedFile);

    $result = "{\n";

    foreach ($mergedFile as $key => $value) {
        if (array_key_exists($key, $firstFileData) && array_key_exists($key, $secondFileData)) {
            if ($firstFileData[$key] === $secondFileData[$key]) {
                $result .= "    {$key}: {$value}\n";
            } else {
                $result .= "  - {$key}: {$firstFileData[$key]}\n";
                $result .= "  + {$key}: {$secondFileData[$key]}\n";
            }
        }
        if (array_key_exists($key, $firstFileData) && !array_key_exists($key, $secondFileData)) {
            $result .= "  - {$key}: {$firstFileData[$key]}\n";
        }
        if (!array_key_exists($key, $firstFileData) && array_key_exists($key, $secondFileData)) {
            $result .= "  + {$key}: {$secondFileData[$key]}\n";
        }
    }
    $result .= "}";

    return $result;
}

function boolValueDisplay(&$arr)
{
    foreach ($arr as $key => $value) {
        $displayValue = '';
        if (is_bool($value)) {
            $displayValue = $value ? 'true' : "false";
            $arr[$key] = $displayValue;
        }
    }
}
