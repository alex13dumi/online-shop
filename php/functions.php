<?php
function FormatName($name)
{
    $name = trim($name);
    $name = strtolower($name);
    $name = ucwords($name);
    return $name;
}

