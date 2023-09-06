<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $filePath)
{
    $fileContentString = file_get_contents($filePath);
    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

    if ($fileExtension === 'json') {
        return json_decode((string) $fileContentString, true);
    } elseif ($fileExtension === 'yml' || $fileExtension === 'yaml') {
        return Yaml::parse((string) $fileContentString, Yaml::PARSE_OBJECT_FOR_MAP);
    }
}
