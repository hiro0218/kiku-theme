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
    echo '<link rel="alternate" hreflang="'. get_locale() .'" href="'. BLOG_URL .'" />'. PHP_EOL;

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

function ogp_tags() {
    $og_tag = [];

    $og_tag['og:locale'] = get_locale();
    if ( $og_tag['og:locale'] == 'ja' ) {
        $og_tag['og:locale'] = 'ja_JP';
    } else if ( $og_tag['og:locale'] == 'th' ) {
        $og_tag['og:locale'] = 'th_TH';
    }

    echo PHP_EOL;

    $og_tag['fb:app_id'] = get_option('kiku_appid');

    if ( is_home() || is_front_page() ) {
        $og_tag['og:type']        = 'blog';
        $og_tag['og:title']       = BLOG_NAME;
        $og_tag['og:url']         = BLOG_URL;
        $og_tag['og:description'] = BLOG_DESCRIPTION;

    } else if ( is_singular() ) {
        $og_tag['og:type']        = 'article';
        $og_tag['og:title']       = get_the_title();
        $og_tag['og:url']         = get_permalink();
        $og_tag['og:description'] = \Kiku\Util::get_excerpt_content();

        // get date
        $pub = get_the_date('c');
        $mod = get_the_modified_date('c');

        // published
        $og_tag['article:published_time'] = $pub;
        // modified
        if ( $mod != $pub ) {
            $og_tag['article:modified_time'] = $mod;
            $og_tag['og:updated_time']       = $mod;
        }

    } else if ( is_404() ) {
        $og_tag['og:type']   = 'object';
        $og_tag['og:title']  = "Page Not Found - ". BLOG_NAME;
    }

    $template = '<meta property="%s" content="%s" />'. PHP_EOL;
    foreach ( $og_tag as $tag_property => $tag_content ) {
        $tag_content = array_unique( (array)$tag_content );
        foreach ( $tag_content as $tag_content_single ) {
            if ( empty( $tag_content_single ) ) {  // Don't ever output empty tags
                continue;
            }
            echo sprintf( $template, esc_attr( $tag_property ), esc_attr( $tag_content_single ) );
        }
    }
}
add_action( 'wp_head',  __NAMESPACE__ . '\\ogp_tags', 12 );

// Twitter Card
function twitter_tags() {
    $twitter_id = get_option('kiku_twitter');
    if ($twitter_id) {
        if ( substr($twitter_id, 0, 1) != "@") {
            $twitter_id = "@".$twitter_id;
        }

        echo PHP_EOL;
        echo '<meta name="twitter:site" content="'. $twitter_id .'">' . PHP_EOL;
    	echo '<meta name="twitter:creator" content="'. $twitter_id .'">' . PHP_EOL;
    	echo '<meta name="twitter:card" content="summary">' . PHP_EOL;
    }
}
add_action( 'wp_head',  __NAMESPACE__ . '\\twitter_tags', 13 );

function image_tags() {
    $image_url = "";

    if ( is_home() ) {
        $image_url = get_site_icon_url();
    } else if ( is_archive() || is_search() || is_404() ) {
        $image_url = "";
    } else {
        global $Image;
        $image_url = $Image->get_post_image_from_tag(false);
        if ( !$image_url ) {
            $image_url = get_site_icon_url();
        }
    }

    if ( $image_url ) {
        echo PHP_EOL;
        echo '<meta property="og:image" content="'. $image_url. '" />'. PHP_EOL;
        echo '<meta name="twitter:image" content="'. $image_url. '" />'. PHP_EOL;
    }
}
add_action( 'wp_head',  __NAMESPACE__ . '\\image_tags', 14 );

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
