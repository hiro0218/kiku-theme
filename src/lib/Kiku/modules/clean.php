<?php

class Clean {
    function __construct() {
        add_action('init', [$this, 'head_claen']);
        // Remove the WordPress version from RSS feeds
        add_filter('the_generator', '__return_false');
        add_filter('user_trailingslashit', [$this, 'add_trailing_slash'], 10, 2);
        add_filter('the_content',  [$this, 'remove_ptags_from_images']);
        add_filter('document_title_parts', [$this, 'remove_description_from_title_tag'], 10, 1);
        add_action('template_redirect', [$this, 'disabled_pages']);

        add_action('admin_init', [$this, 'remove_dashboard_widgets']);
        // Remove "thank you for creating with Wordpress"
        add_filter('admin_footer_text', '__return_false');
        // Access denied Author page -> update options-permalink
        add_filter('author_rewrite_rules', '__return_empty_array');
        add_filter('xmlrpc_methods', [$this, 'filter_xmlrpc_method'], 10, 1);
        add_action('xmlrpc_call', [$this, 'disable_xmlrpc']);
        add_action('pre_ping', [$this, 'disable_self_ping']);
    }

    public function head_claen() {
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
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'locale_stylesheet');
        remove_action('wp_head', 'noindex', 1);
        remove_action('wp_head', 'wp_print_head_scripts', 9);
        remove_action('wp_head', 'wp_no_robots');
        remove_action('wp_head', 'wp_post_preview_js', 1);
        add_filter('use_default_gallery_style', '__return_false');

        // emoji
        // http://b.0218.jp/20150425235647.html
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        //add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');

        // embed
        add_filter('embed_oembed_discover', '__return_false');
        remove_action('wp_head','rest_output_link_wp_head');
        remove_action('wp_head','wp_oembed_add_discovery_links');
        remove_action('wp_head','wp_oembed_add_host_js');

        // Jetpack
        remove_action('wp_head', 'jetpack_og_tags');
        add_filter('jetpack_implode_frontend_css', '__return_false');
        add_action('wp_print_styles', function () {
            wp_dequeue_style('simple-payments');
        }, 100);

        // Removing devicepx-jetpack.js
        add_action('wp_enqueue_scripts', function () {
            wp_dequeue_script('devicepx');
        }, 20);

        // WordPress 4.4 Response image
        add_filter('wp_calculate_image_srcset', '__return_false');
        add_filter('wp_calculate_image_sizes', '__return_false');
        add_filter('use_default_gallery_style', '__return_false');

        global $wp_widget_factory;
        if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
            remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
        }
    }

    public function add_trailing_slash($string, $type_of_url) {
        // Add a slash to the end of the URL
        // http://b.0218.jp/20140413154158.html
        if ($type_of_url !== 'single') {
            $string = trailingslashit($string);
        }
        return $string;
    }

    public function remove_ptags_from_images($content){
        // Remove <p> tags from images
        return preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '$1', $content);
    }

    public function remove_description_from_title_tag($title) {
        // Remove description from <title>
        if ( is_home() || is_front_page() ) {
            unset($title['tagline']);
        }

        return $title;
    }

    public function disabled_pages() {
        if (is_date() || is_attachment() || is_author()) {
            global $wp_query;
            $wp_query->set_404();
        }
    }

    ///

    // Remove unnecessary dashboard widgets
    // http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
    public function remove_dashboard_widgets() {
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
        remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
        remove_meta_box('dashboard_primary', 'dashboard', 'normal');
        remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
    }

    // Disable pingback XMLRPC method
    public function filter_xmlrpc_method($methods) {
        unset($methods['pingback.ping']);
        return $methods;
    }

    // Disable XMLRPC call
    public function disable_xmlrpc($action) {
        if ($action === 'pingback.ping') {
            wp_die('Pingbacks are not supported', 'Not Allowed!', ['response' => 403]);
        }
    }

    // Disable self-ping
    public function disable_self_ping($links) {
        $home = get_option('home');
        foreach ( $links as $l => $link ) {
            if ( 0 === strpos( $link, $home ) ) {
                unset($links[$l]);
            }
        }
    }


}

$Clean = new Clean();
