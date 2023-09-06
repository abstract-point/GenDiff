<?php

namespace Differ\Formatters\Plain;

function renderPlain($tree, $path = '')
{
    $result = array_map(
        function ($node) use ($path) {
            switch ($node['type']) {
                case "parent":
                    $path .= "{$node['key']}.";
                    return renderPlain($node['children'], $path);
                case "removed":
                    $path .= $node['key'];
                    return "Property '{$path}' was removed";
                case "added":
                    $path .= $node['key'];
                    $value = stringify($node['value']);
                    return "Property '{$path}' was added with value: {$value}";
                case "changed":
                    $path .= $node['key'];
                    $firstValue = stringify($node['firstValue']);
                    $secondValue = stringify($node['secondValue']);
                    return "Property '{$path}' was updated. From {$firstValue} to {$secondValue}";
            }
        },
        $tree
    );
    $cleanedResult = array_filter($result, fn ($item) => !empty($item));

    return implode("\n", $cleanedResult);
}

function stringify($value)
{
    if (is_object($value) || is_array($value)) {
        return "[complex value]";
    } elseif ($value === false) {
        return "false";
    } elseif ($value === true) {
        return "true";
    } elseif ($value === null) {
        return "null";
    } else {
        return "'{$value}'";
    }
}
