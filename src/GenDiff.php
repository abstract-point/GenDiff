<?php
namespace Php\Project\GenDiff;

function genDiff($args)
{
    $pathToFirstFile = $args['<firstFile>'];
    $pathToSecondFile = $args['<secondFile>'];

    $firstFile = json_decode(file_get_contents($pathToFirstFile), true);
    $secondFile = json_decode(file_get_contents($pathToSecondFile), true);
    //var_dump($firstFile);
    boolValueDisplay($firstFile);
    boolValueDisplay($secondFile);

    //var_dump($firstFile);
    
    $merged = array_merge($firstFile, $secondFile);
    ksort($merged);
    //var_dump($merged);
    $result = "{\n";
    foreach ($merged as $key => $value) {
        if (array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile)) {
            if ($firstFile[$key] === $secondFile[$key]) {
                $result .= "  {$key}: {$value}\n";
            } else {
                $result .= "- {$key}: {$firstFile[$key]}\n";
                $result .= "+ {$key}: {$secondFile[$key]}\n";
            }
        }
        if (array_key_exists($key, $firstFile) && !array_key_exists($key, $secondFile)) {
            $result .= "- {$key}: {$firstFile[$key]}\n";
        }
        if (!array_key_exists($key, $firstFile) && array_key_exists($key, $secondFile)) {
            $result .= "+ {$key}: {$secondFile[$key]}\n";
        }
    }
    $result .= "}";
    echo $result;
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