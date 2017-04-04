<?php

class Opengraph {
    public $og_tag = [];

    public function __construct() {
        add_action('wp_head', [$this, 'set_og_tags'], 20);
    }

    public function output_og_tag($og_tag) {
        $template = '<meta property="%s" content="%s" />'. PHP_EOL;

        foreach( $og_tag as $tag_property => $tag_content ) {
            $tag_content = array_unique( (array)$tag_content );

            foreach( $tag_content as $tag_content_single ) {
                if (empty( $tag_content_single )) {
                    continue;
                }
                echo sprintf( $template, esc_attr( $tag_property ), esc_attr( $tag_content_single ) );
            }
        }

    }

    public function set_og_tags() {
        $this->set_locale();

        if ( is_home() || is_front_page() ) {
            $this->og_tag['og:type']        = 'website';
            $this->og_tag['og:title']       = BLOG_NAME;
            $this->og_tag['og:url']         = BLOG_URL;
            $this->og_tag['og:description'] = BLOG_DESCRIPTION;
            $this->og_tag['og:image']       = get_site_icon_url();
        } else if ( is_singular() ) {
            $this->og_tag['og:type']        = 'article';
            $this->og_tag['og:title']       = get_the_title();
            $this->og_tag['og:url']         = get_permalink();
            $this->og_tag['og:description'] = \Kiku\Util::get_excerpt_content();
            $this->og_tag['og:image']       = $this->get_singular_image();

            $this->set_publish_date();
        } else if ( is_404() ) {
            $this->og_tag['og:type']  = 'object';
            $this->og_tag['og:title'] = 'Page Not Found - '. BLOG_NAME;
        }

        $this->set_others();

        $this->output_og_tag($this->og_tag);
    }

    private function set_locale() {
        $locale = get_locale();

        if ($locale == 'ja') {
            $this->og_tag['og:locale'] = 'ja_JP';
        } else if ($locale == 'th') {
            $this->og_tag['og:locale'] = 'th_TH';
        }

    }

    private function set_publish_date() {
        $published = get_the_date('c');
        $modified  = get_the_modified_date('c');

        $this->og_tag['article:published_time'] = $published;

        if ($modified !== $published) {
            $this->og_tag['og:updated_time']       = $modified;
            $this->og_tag['article:modified_time'] = $modified;
        }
    }

    private function set_others() {
        $appid = get_option('kiku_appid');
        if ($appid) {
            $this->og_tag['fb:app_id'] = get_option('kiku_appid');
        }
    }

    private function get_singular_image() {
        global $Image;
        $image_url = $Image->get_post_image_from_tag(false);

        if (!$image_url) {
            return get_site_icon_url();
        }

        return \Kiku\Util::add_scheme_relative_url($image_url);
    }

}
