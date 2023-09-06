<?php

namespace Differ\Formatters\Plain;

function renderPlain(array $tree, string $path = '')
{
    $result = array_map(
        function ($node) use ($path) {
            switch ($node['type']) {
                case "parent":
                    $currentPath = $path . "{$node['key']}.";
                    return renderPlain($node['children'], $currentPath);
                case "removed":
                    $currentPath = $path . "{$node['key']}";
                    return "Property '{$currentPath}' was removed";
                case "added":
                    $currentPath = $path . "{$node['key']}";
                    $value = stringify($node['value']);
                    return "Property '{$currentPath}' was added with value: {$value}";
                case "changed":
                    $currentPath = $path . "{$node['key']}";
                    $firstValue = stringify($node['firstValue']);
                    $secondValue = stringify($node['secondValue']);
                    return "Property '{$currentPath}' was updated. From {$firstValue} to {$secondValue}";
            }
            return "same";
        },
        $tree
    );
    $cleanedResult = array_filter($result, fn ($item) => $item !== "same");

    return implode("\n", $cleanedResult);
}

function stringify(mixed $value)
{
    if (is_object($value) || is_array($value)) {
        return "[complex value]";
    } elseif ($value === false) {
        return "false";
    } elseif ($value === true) {
        return "true";
    } elseif ($value === null) {
        return "null";
    } elseif ($value === 0) {
        return "0";
    } else {
        return "'{$value}'";
    }
}
