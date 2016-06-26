<?php

// 省略文字数
function new_excerpt_length($length) {
   return EXCERPT_LENGTH;
}
add_filter('excerpt_length',   'new_excerpt_length');
add_filter('excerpt_mblength', 'new_excerpt_length');

// 省略記号
function new_excerpt_more() {
   return EXCERPT_HELLIP;
}
add_filter('excerpt_more', 'new_excerpt_more');
add_filter('the_excerpt', ["Util",'get_excerpt_content']);
