<?php
namespace Kiku\Components;

function the_pager() {
    // article only
    if ( !is_single() ) {
        return;
    }

    $pager = "";
    $args = [
        'previous_string' => '<span class="pager-icon"><i class="material-icons">chevron_left</i></span>',
        'next_string'     => '<span class="pager-icon"><i class="material-icons">chevron_right</i></span>',
    ];
    $prev = [];
    $next = [];
    $prev_post = get_previous_post();
    $next_post = get_next_post();

    // previous post
    if (!empty($prev_post)) {
        $prev['uri']   = get_permalink($prev_post->ID);
        $prev['title'] = esc_html($prev_post->post_title);
        $prev['attr']  = '';
    } else {
        // oldest
        $prev['uri']   = '';
        $prev['title'] = '';
        $prev['attr']  = '';
    }
    if (!empty($prev['uri'])) {
        $pager .= '<a href="' . $prev['uri'] . '"  class="pager-previous column is-half '. $prev['attr'] .'" title="'. $prev['title'] .'">';
        $pager .= $args['previous_string'];
        $pager .= '<span class="pager-instruct">prev</span>';
        $pager .= '<span class="pager-title">'. $prev['title'] .'</span>';
        $pager .= '</a>';
    }

    // next post
    if (!empty($next_post)) {
        $next['uri']   = get_permalink($next_post->ID);
        $next['title'] = esc_html($next_post->post_title);
        $next['attr']  = '';
    } else {
        // latest
        $next['uri']   = '';
        $next['title'] = '';
        $next['attr']  = '';
    }
    if (!empty($next['uri'])) {
        $pager .= '<a href="' . $next['uri'] . '" class="pager-next column is-half '. $next['attr'] .'" title="'. $next['title'] .'">';
        $pager .= $args['next_string'];
        $pager .= '<span class="pager-instruct">next</span>';
        $pager .= '<span class="pager-title">'. $next['title'] .'</span>';
        $pager .= '</a>';
    }

    echo '<nav class="pager">';
    echo '<div class="columns is-gapless">';
    echo $pager;
    echo '<div>';
    echo '</nav>';
}
