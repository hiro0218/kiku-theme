<?php

namespace App;

use Roots\Sage\Template;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    // style
    wp_enqueue_style('normalize', 'https://cdnjs.cloudflare.com/ajax/libs/normalize/6.0.0/normalize.min.css', false, null);
    wp_enqueue_style('styles/main', asset_path('styles/main.css'), false, null);

    // script
    wp_enqueue_script('scripts/main', asset_path('scripts/main.js'), [], null, true);

    // syntax highlighter
    if (is_singular()) {
        wp_enqueue_script('scripts/prism', asset_path('scripts/prism.js'), [], null, true);
    }

}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    // Make theme available for translation
    // load_theme_textdomain('kiku', get_template_directory() . '/lang');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'kiku')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'gallery', 'search-form']);

    /**
     * Use main stylesheet for visual editor
     * @see assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
});

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'kiku'),
        'id'            => 'sidebar-primary'
    ] + $config);

});
