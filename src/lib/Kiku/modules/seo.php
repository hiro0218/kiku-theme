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
    // echo '<link rel="alternate" hreflang="'. get_locale() .'" href="'. BLOG_URL .'" />'. PHP_EOL;

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
function dns_prefetch_tags() {
    echo PHP_EOL;
    echo '<meta http-equiv="x-dns-prefetch-control" content="on">'. PHP_EOL;
    $generate_dns = [
        "cdnjs.cloudflare.com",
        "stats.wp.com",
        "www.google-analytics.com",
        "ecx.images-amazon.com",
        "stats.g.doubleclick.net",
        "ajax.googleapis.com",
        "fonts.googleapis.com",
        "pixel.wp.com"
    ];
    $tag_template = '<link rel="dns-prefetch" href="//%s">' . PHP_EOL;

    foreach ( $generate_dns as $domain ) {
        echo sprintf( $tag_template, $domain );
    }
}
// Until WordPress 4.6 Release
if ( !function_exists('wp_resource_hints') ) {
    add_action( 'wp_head',  __NAMESPACE__ . '\\dns_prefetch_tags', 15 );
}

function add_resource_hints( $hints, $relation_type ){
    if ( $relation_type == 'dns-prefetch' ){
        $hints[] = "//www.google-analytics.com";
        $hints[] = "//images-amazon.com";
        $hints[] = "//images-na.ssl-images-amazon.com";
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
