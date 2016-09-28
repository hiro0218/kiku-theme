<?php
// wordpress
const DESCRIPTION_LENGTH = 199;
const EXCERPT_LENGTH = 80;
const EXCERPT_HELLIP = "…";
const NOTHING_CONTENT = "👻";
const CF_THUMBNAIL = "thumbnail";

define('BLOG_NAME', get_option('blogname') );
define('BLOG_URL', esc_url(home_url('/')) );
define('BLOG_DESCRIPTION', mb_substr(get_option('blogdescription'), 0, DESCRIPTION_LENGTH) );
define('CURRENT_TIMESTAMP', time() );
define('BLOG_TEMPLATE_DIRECTORY', wp_make_link_relative( get_template_directory_uri() ) );
