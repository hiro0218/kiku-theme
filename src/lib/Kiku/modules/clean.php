<?php
namespace Kiku\Modules;

function head_cleanup() {
    // http://wpengineer.com/1438/wordpress-header/
    remove_action('wp_head', 'feed_links_extra', 3);
    add_action('wp_head', 'ob_start', 1, 0);
    add_action('wp_head', function () {
        $pattern = '/.*' . preg_quote(esc_url(get_feed_link('comments_' . get_default_feed())), '/') . '.*[\r\n]+/';
        echo preg_replace($pattern, '', ob_get_clean());
    }, 3, 0);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    add_filter('use_default_gallery_style', '__return_false');

    // emoji
    // http://b.0218.jp/20150425235647.html
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    //add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );

    // embed
    add_filter( 'embed_oembed_discover', '__return_false' );
    remove_action( 'wp_head','rest_output_link_wp_head' );
    remove_action( 'wp_head','wp_oembed_add_discovery_links' );
    remove_action( 'wp_head','wp_oembed_add_host_js' );

    // REST API
    // remove Request Header: REST API endpoint
    remove_action( 'template_redirect', 'rest_output_link_header', 11 );
    // stop REST API Request
    add_filter( 'rest_enabled', '__return_false' );
    // stop JSONP
    add_filter( 'rest_jsonp_enabled', '__return_false' );

    // Jetpack
    remove_action( 'wp_head', 'jetpack_og_tags' );
    add_filter( 'jetpack_implode_frontend_css', '__return_false' );

    // WordPress 4.4 Response image
    add_filter( 'wp_calculate_image_srcset', '__return_false' );
    add_filter( 'wp_calculate_image_sizes', '__return_false' );

    add_filter('use_default_gallery_style', '__return_false');

    global $wp_widget_factory;
    if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
        remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
    }

}
add_action('init', __NAMESPACE__ . '\\head_cleanup');

// Removing devicepx-jetpack.js
function dequeue_devicepx() {
    wp_dequeue_script( 'devicepx' );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\dequeue_devicepx', 20 );

// Remove the WordPress version from RSS feeds
add_filter( 'the_generator', '__return_false' );

// Add a slash to the end of the URL
// http://b.0218.jp/20140413154158.html
function add_trailing_slash($string, $type_of_url) {
    if ($type_of_url != 'single') {
        $string = trailingslashit($string);
    }
    return $string;
}
add_filter('user_trailingslashit', __NAMESPACE__ . '\\add_trailing_slash', 10, 2);

// Remove <p> tags from images
function remove_ptags_from_images($content){
    return preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '$1', $content);
}
add_filter('the_content', __NAMESPACE__ . '\\remove_ptags_from_images');


//
// admin
// --------------------

// Remove unnecessary dashboard widgets
// http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
function remove_dashboard_widgets() {
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
}
add_action('admin_init', __NAMESPACE__ . '\\remove_dashboard_widgets');
