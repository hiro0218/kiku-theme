<?php

class SEO {

    function __construct() {
        add_action('wp_head', [$this, 'render'], 20);
        add_filter('wp_resource_hints', [$this, 'add_resource_hints'], 10, 2);
    }

    public function render() {
        echo $this->basic_tag();
        echo $this->next_prev_tags();
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
            return $tag;
        }

        $pages = count(explode('<!--nextpage-->', $post->post_content));
        if ($pages <= 1) {
            return $tag;
        }

        $permalink = rtrim(get_the_permalink(), '/') .'/';
        if ($page === $pages) {
            if ($page === 2) {
                $tag .= sprintf($tag_prev, $permalink);
            } else {
                $tag .= sprintf($tag_prev, $permalink . ($page - 1) );
            }
        } else {
            if ($page === 0) {
                $tag .= sprintf($tag_next, $permalink . ($page + 2) );
            } else {
                if ($page === 2) {
                    $tag .= sprintf($tag_prev, $permalink);
                } else {
                    $tag .= sprintf($tag_prev, $permalink . ($page - 1) );
                }
                $tag .= sprintf($tag_next, $permalink . ($page + 1) );
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

}

$SEO = new SEO();
