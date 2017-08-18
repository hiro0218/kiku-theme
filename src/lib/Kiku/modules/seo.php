<?php
namespace Kiku\Modules;

// basic tags
function basic_tags() {
    echo PHP_EOL;

    // description
    if ( is_home() && !is_paged() ) {
        echo '<meta name="description" content="' . BLOG_DESCRIPTION . '">'. PHP_EOL;
    }

    // author page
    $author_page = get_option('kiku_author_page');
    if ( !empty($author_page) ) {
        echo '<link itemprop="author" href="'. $author_page .'" />'. PHP_EOL;
    }

    // page
    if ( is_singular() ) {
        have_next_page();
    }
}
add_action( 'wp_head',  __NAMESPACE__ . '\\basic_tags', 11 );

function have_next_page() {
    global $post, $page;

    $pages = count( explode('<!--nextpage-->', $post->post_content) );
    if ( $pages > 1 ) {
        if ( $page == $pages ) {
            if ( $page == 2 ) {
                echo sprintf('<link rel="prev" href="%s">'. PHP_EOL, get_the_permalink());
            } else {
                echo sprintf('<link rel="prev" href="%s">'. PHP_EOL, get_the_permalink(). "/" .($page - 1) );
            }
        } else {
            if ( $page == 0 ) {
                echo sprintf('<link rel="next" href="%s">'. PHP_EOL, get_the_permalink(). "/" .($page + 2) );
            } else {
                if ( $page == 2 ) {
                    echo sprintf('<link rel="prev" href="%s">'. PHP_EOL, get_the_permalink());
                } else {
                    echo sprintf('<link rel="prev" href="%s">'. PHP_EOL, get_the_permalink(). "/" .($page - 1) );
                }
                echo sprintf('<link rel="next" href="%s">'. PHP_EOL, get_the_permalink(). "/" .($page + 1) );
            }
        }
    }
}

// DNS Prefetch
function add_resource_hints( $hints, $relation_type ){
    if ( $relation_type == 'dns-prefetch' ) {
        $hints[] = "//googletagmanager.com";
        $hints[] = "//google-analytics.com";
        $hints[] = "//googlesyndication.com";
        $hints[] = "//ssl-images-amazon.com";
    }
    return $hints;
}
add_filter( 'wp_resource_hints',  __NAMESPACE__ . '\\add_resource_hints', 10, 2 );

// mics tags
function mics_tags() {
    echo PHP_EOL;
    echo '<meta name="google" content="notranslate" />'. PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'. PHP_EOL;
    echo '<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">'. PHP_EOL;
    echo PHP_EOL;
}
add_action( 'wp_head',  __NAMESPACE__ . '\\mics_tags', 20 );
