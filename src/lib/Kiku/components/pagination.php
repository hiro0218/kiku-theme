<?php
namespace Kiku\Components;

function the_pagination() {
    $args = [
        'range'           => 4,
        'custom_query'    => false,
        'previous_string' => '<i class="material-icons">chevron_left</i>',
        'next_string'     => '<i class="material-icons">chevron_right</i>',
        'first_page'      => '<i class="material-icons">first_page</i>',
        'last_string'     => '<i class="material-icons">last_page</i>',
    ];

    $args['range'] = (int) $args['range'] - 1;
    if ( !$args['custom_query'] ) {
        $args['custom_query'] = $GLOBALS['wp_query'];
    }

    $count = (int) $args['custom_query']->max_num_pages;
    $page  = intval( get_query_var( 'paged' ) );
    $ceil  = ceil( $args['range'] / 2 );

    if ( $count <= 1 ) {
        return FALSE;
    }

    if ( !$page ) {
        $page = 1;
    }

    if ( $count > $args['range'] ) {
        if ( $page <= $args['range'] ) {
            $min = 1;
            $max = $args['range'] + 1;
        } elseif ( $page >= ($count - $ceil) ) {
            $min = $count - $args['range'];
            $max = $count;
        } elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
            $min = $page - $ceil;
            $max = $page + $ceil;
        }
    } else {
        $min = 1;
        $max = $count;
    }

    $pagination = '';
    $previous  = esc_attr(get_pagenum_link(intval($page) - 1));
	$firstpage = esc_attr(get_pagenum_link(1));

    if ( $firstpage && (1 != $page) ) {
        $pagination .= '<li class="pagination-frist"><a href="' . $firstpage . '">' . $args['first_page'] . '</a></li>';
    }
    if ( $previous && (1 != $page) ) {
        $pagination .= '<li class="pagination-previous"><a href="' . $previous . '">' . $args['previous_string'] . '</a></li>';
    }

    if ( !empty($min) && !empty($max) ) {
        for( $i = $min; $i <= $max; $i++ ) {
            if ($page == $i) {
                $pagination .= '<li class="pagination-active"><span>' . str_pad( (int)$i, 2, '0', STR_PAD_LEFT ) . '</span></li>';
            } else {
                $pagination .= sprintf( '<li><a href="%s">%002d</a></li>', esc_attr( get_pagenum_link($i) ), $i );
            }
        }
    }

    $next = esc_attr(get_pagenum_link(intval($page) + 1));
    $lastpage = esc_attr( get_pagenum_link($count) );

    if ($next && ($count != $page) ) {
        $pagination .= '<li class="pagination-next"><a href="' . $next . '">' . $args['next_string'] . '</a></li>';
    }

    if ( $lastpage && ($count != $page) ) {
        $pagination .= '<li class="pagination-last"><a href="' . $lastpage . '">' . $args['last_string'] . '</a></li>';
    }

    // from setting
    $data = get_option('kiku_insert_data_top_of_pagination');
    if ( !empty($data) ) {
        echo $data;
    }

    if ( isset($pagination) ) {
        echo '<nav class="pagination-container">';
        echo '<ul class="pagination">'. $pagination .'</ul>';
        echo '</nav>';
    }
}
