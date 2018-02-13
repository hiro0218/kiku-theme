<?php

namespace App;

use Roots\Sage\Asset;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template;

function template($layout = 'base')
{
    return Template::$instances[$layout];
}

function template_part($template, array $context = [], $layout = 'base')
{
    extract($context);
    include template($layout)->partial($template);
}

/**
 * @param $filename
 * @return string
 */
function asset_path($filename)
{
    static $manifest;
    isset($manifest) || $manifest = new JsonManifest(get_stylesheet_directory() . '/' . Asset::$dist . '/assets.json');
    return (string) new Asset($filename, $manifest);
}

