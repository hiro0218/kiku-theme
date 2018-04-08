<?php

class Posts {
    public function __construct() {
        add_action('pre_get_posts', [$this, 'set_pre_get_posts']);
        add_filter('the_content', [$this, 'repair_destroyed_datauri'], 11);
        add_filter('the_excerpt', ["Kiku\Util", 'get_excerpt_content']);
        add_filter('excerpt_length', [$this, 'change_excerpt_length']);
        add_filter('excerpt_mblength', [$this, 'change_excerpt_length']);
        add_filter('excerpt_more', [$this, 'change_excerpt_more']);
    }

    // 省略文字数
    public function change_excerpt_length($length) {
        return EXCERPT_LENGTH;
    }

    // 省略記号
    public function change_excerpt_more() {
        return EXCERPT_HELLIP;
    }

    public function set_pre_get_posts($query) {
        $query = $this->sort_query($query);
        $query = $this->remove_page_from_search_result($query);

        return $query;
    }

    // Sort Post query
    private function sort_query($query) {
        // influence: admin page's post list
        if ($query->is_main_query()) {
            $query->set('orderby', 'modified');
            $query->set('order', 'desc');
        }

        return $query;
    }

    // remove page from search result
    private function remove_page_from_search_result($query) {
        if ($query->is_search()) {
            $query->set('post_type', 'post');
        }

        return $query;
    }

    // Bug? (Wordpress 4.3)
    // DataURI form CustomField is destroyed.
    public function repair_destroyed_datauri($content) {
        $content = $this->replace_relative_to_absolute_img_src($content);

        return str_replace(' src="image/', ' src="data:image/', $content);
    }

    private function replace_relative_to_absolute_img_src($content) {
        preg_match_all('/<img.*?src=(["\'])(.+?)\1.*?>/i', $content, $matches);

        foreach ($matches[2] as $src_url) {
            // to Absolute URL
            if (\Kiku\Util::is_image($src_url)) {
                $src_absolute_url = \Kiku\Util::relative_to_absolute_url($src_url);
                $content = str_replace('src="'. $src_url, 'src="'. $src_absolute_url, $content);
            }
        }

        return $content;
    }
}

$Posts = new Posts();
