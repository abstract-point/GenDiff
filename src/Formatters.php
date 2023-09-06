<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\renderStylish;
use function Differ\Formatters\Plain\renderPlain;
use function Differ\Formatters\Json\renderJson;

function render(array $diffTree, string $format)
{
    if ($format === "stylish") {
        return renderStylish($diffTree);
    } elseif ($format === "plain") {
        return renderPlain($diffTree);
    } elseif ($format === "json") {
        return renderJson($diffTree);
    }
}
