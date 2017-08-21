<?php

class SEO {

    function __construct() {
        add_action('wp_head', [$this, 'render'], 20);
        add_filter('wp_resource_hints', [$this, 'add_resource_hints'], 10, 2);
    }

    public function render() {
        echo $this->basic_tag();
        echo $this->next_prev_tags();
        echo $this->mics_tag();
    }

    private function basic_tag() {
        $tag = '';

        $tag .= PHP_EOL;

        // description
        if (is_home() && !is_paged()) {
            $tag .= '<meta name="description" content="' . BLOG_DESCRIPTION . '">'. PHP_EOL;
        }

        // author page
        $author_page = get_option('kiku_author_page');
        if (!empty($author_page)) {
            $tag .= '<link itemprop="author" href="'. $author_page .'" />'. PHP_EOL;
        }

        return $tag;
    }

    private function next_prev_tags() {
        global $post, $page;
        $tag = '';
        $tag_prev = '<link rel="prev" href="%s">'. PHP_EOL;
        $tag_next = '<link rel="next" href="%s">'. PHP_EOL;

        if (!is_singular()) {
            return $tags;
        }

        $pages = count(explode('<!--nextpage-->', $post->post_content));
        if ($pages === 0) {
            return $tags;
        }

        if ($page === $pages) {
            if ($page === 2) {
                $tag .= sprintf($tag_prev, get_the_permalink());
            } else {
                $tag .= sprintf($tag_prev, get_the_permalink() . ($page - 1) );
            }
        } else {
            if ($page === 0) {
                $tag .= sprintf($tag_next. PHP_EOL, get_the_permalink() . ($page + 2) );
            } else {
                if ($page === 2) {
                    $tag .= sprintf($tag_prev, get_the_permalink());
                } else {
                    $tag .= sprintf($tag_prev, get_the_permalink() . ($page - 1) );
                }
                $tag .= sprintf($tag_next, get_the_permalink() . ($page + 1) );
            }
        }

        return $tag;
    }

    // DNS Prefetch
    public function add_resource_hints($hints, $relation_type){
        if ($relation_type === 'dns-prefetch') {
            $hints[] = '//googletagmanager.com';
            $hints[] = '//google-analytics.com';
            $hints[] = '//googlesyndication.com';
            $hints[] = '//ssl-images-amazon.com';
        }

        return $hints;
    }

    private function mics_tag() {
        $tag = '';

        $tag .= PHP_EOL;
        $tag .= '<meta name="google" content="notranslate" />'. PHP_EOL;
        $tag .= '<meta name="format-detection" content="telephone=no">'. PHP_EOL;
        $tag .= '<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">'. PHP_EOL;
        $tag .= PHP_EOL;

        return $tag;
    }
}

$SEO = new SEO();
