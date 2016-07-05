<?php
namespace Kiku\Modules;

function add_profile($content) {
    $content['twitter']  = 'Twitter ID';
    $content['facebook'] = 'Facebook ID';

    return $content;
}
add_filter('user_contactmethods', __NAMESPACE__ . '\\add_profile', 10, 1);
