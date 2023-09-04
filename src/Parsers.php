<?php

namespace Php\Project\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile($filePath)
{
    $fileContentString = file_get_contents($filePath);
    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

    if ($fileExtension === 'json') {
        return json_decode($fileContentString, true);
    } elseif ($fileExtension === 'yml' || $fileExtension === 'yaml') {
        return Yaml::parse($fileContentString, Yaml::PARSE_OBJECT_FOR_MAP);
    }
}
