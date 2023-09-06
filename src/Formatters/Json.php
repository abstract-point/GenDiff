<?php

namespace Differ\Formatters\Json;

function renderJson(array $diffTree)
{
    return json_encode($diffTree);
}
