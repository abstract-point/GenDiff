<?php

namespace Php\Project\Formatters\Stylish;

function renderStylish($tree, $depth = 1)
{
    $margin = str_repeat(" ", ($depth * 4));
    $marginChange = str_repeat(" ", ($depth * 4 - 2));
    $marginCloseBracket = $depth === 1 ? '' : str_repeat(" ", (($depth - 1) * 4));

    $result = array_map(
        function ($node) use ($depth, $margin, $marginChange) {
            if ($node['type'] === 'parent') {
                $children = renderStylish($node['children'], $depth + 1);
                return "{$margin}{$node['key']}: {$children}";
            }
            if ($node['type'] === 'plus') {
                $value = stringify($node['value'], $depth);
                return "{$marginChange}+ {$node['key']}: {$value}";
            }
            if ($node['type'] === 'minus') {
                $value = stringify($node['value'], $depth);
                return "{$marginChange}- {$node['key']}: {$value}";
            }
            if ($node['type'] === 'changed') {
                $firstValue = stringify($node['firstValue'], $depth);
                $secondValue = stringify($node['secondValue'], $depth);
                $subStrFirst = "{$marginChange}- {$node['key']}: {$firstValue}\n";
                $subStrSecond = "{$marginChange}+ {$node['key']}: {$secondValue}";
                return "{$subStrFirst}{$subStrSecond}";
            }
            if ($node['type'] === 'same') {
                $value = stringify($node['value'], $depth);
                return "{$margin}{$node['key']}: {$value}";
            }
        },
        $tree
    );

    return "{\n" . implode("\n", $result) . "\n{$marginCloseBracket}}";
}

function stringify($node, $depth)
{
    $nodeString = json_encode($node, JSON_PRETTY_PRINT);
    $symbols = ['"', ','];
    $preparedNodeString = str_replace($symbols, "", $nodeString);

    if (is_object($node) || is_array($node)) {
        $arr = explode("\n", $preparedNodeString);
        $result = array_map(
            function ($item) use ($depth) {
                $margin = str_repeat(' ', $depth * 4);
                return "{$margin}{$item}";
            },
            $arr
        );
        return ltrim(implode("\n", $result), ' ');
    }

    return $preparedNodeString;
}
