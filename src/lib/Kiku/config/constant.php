<?php
// wordpress
const DESCRIPTION_LENGTH = 199;
const EXCERPT_LENGTH = 80;
const EXCERPT_HELLIP = "…";
const NOTHING_CONTENT = "👻";
const RELATED_POST_NUM = 6;
const CF_THUMBNAIL = "thumbnail";
const CF_ASIN = "ASIN";
const CF_AMAZON_PRODUCT_TAG = "_amazon_product_tag";

define('BLOG_NAME', get_option('blogname') );
define('BLOG_URL', esc_url(home_url('/')) );
define('BLOG_DESCRIPTION', mb_substr(get_option('blogdescription'), 0, DESCRIPTION_LENGTH) );
define('CURRENT_TIMESTAMP', time() );
define('BLOG_TEMPLATE_DIRECTORY', wp_make_link_relative( get_template_directory_uri() ) );

define('IS_SSL', ( !empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ));
define('SCHEME', IS_SSL ? 'https' : 'http' );
