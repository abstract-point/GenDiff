<?php

namespace Differ\Formatters\Json;

function renderJson($diffTree)
{
    return json_encode($diffTree);
}
