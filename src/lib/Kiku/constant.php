<?php
// wordpress
define('BLOG_NAME', get_option('blogname') );
define('BLOG_URL', esc_url(home_url('/')) );
define('BLOG_DESCRIPTION', get_option('blogdescription') );
define('CURRENT_TIMESTAMP', time() );
define('BLOG_TEMPLATE_DIRECTORY', wp_make_link_relative( get_template_directory_uri() ) );

const DESCRIPTION_LENGTH = 199;
const EXCERPT_LENGTH = 80;
const EXCERPT_HELLIP = "…";
const ENTRY_READ_MORE = "続きを読む ›";
