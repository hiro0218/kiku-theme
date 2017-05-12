<?php
namespace Kiku\Modules;

function highlight_search_results($content) {
    if ( !is_admin() && is_search() && is_main_query() ) {
        $keys = implode('|', explode(' ', get_search_query()));
        $content = preg_replace('/'. $keys .'/iu', '<mark>$0</mark>', $content);
    }
    return $content;
}
// add_filter('the_title', __NAMESPACE__ . '\\highlight_search_results');
add_filter('the_excerpt', __NAMESPACE__ . '\\highlight_search_results');
