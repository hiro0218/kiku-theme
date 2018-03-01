<?php

class FrontVariables {
    public function __construct() {
    }

    // Global javaScript variables
    public function output_variables() {
        $vars = [
            'per_page' => $this->get_per_page(),
            'categories_exclude' => $this->get_categories_exclude(),
            'is_preview' => is_preview(),
            'is_logined' => is_user_logged_in(),
            'is_shared' => $this->is_shared(),
            'routes' => $this->create_routes(),
            'nonce' => wp_create_nonce('wp_rest'),
        ];
        $vars = json_encode($vars, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

        echo '<script>';
        echo 'var WP = '. $vars;
        echo '</script>'. PHP_EOL;
    }

    private function get_per_page() {
        if (is_singular()) {
            return null;
        }
        return (int)get_option('posts_per_page');
    }

    private function get_categories_exclude() {
        if (!is_front_page()) {
            return null;
        }
        $exclude_category = (int)get_option('kiku_exclude_category_frontpage');
        return $exclude_category ? $exclude_category : 0;
    }

    private function is_shared() {
        return [
            'twitter' => (boolean) get_option('kiku_share_btn_twitter'),
            'facebook' => (boolean) get_option('kiku_share_btn_facebook'),
            'hatena' => (boolean) get_option('kiku_share_btn_hatena'),
            'line' => (boolean) get_option('kiku_share_btn_line'),
        ];
    }

    private function create_routes() {
        $routes = [];

        // transient で一時的にキャッシュしたデータをロード
        $key = CACHE_PREFIX . "routes";
        $routes = get_transient($key);

        if ($routes === false) {
            $posts = $this->get_post_routes();
            $terms = $this->get_term_routes();

            $routes = array_merge($posts, $terms);

            set_transient($key, $routes, MINUTE_IN_SECONDS * 15);
        }

        return $routes;
    }

    private function get_post_routes() {
        $routes = [];
        $query = new WP_Query([
            'post_type'      =>  ['post', 'page'],
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ]);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $post_type = get_post_type();
                $routes[] = [
                    'id'       => $post_id,
                    'type'     => $post_type,
                    'slug'     => get_post_field('post_name', $post_id),
                    'path'     => '/' . basename(get_permalink()),
                    'title'    => get_the_title(),
                    'template' => $post_type === 'page' ? get_page_template_slug($post_id) : '',
                ];
            }
        }
        wp_reset_postdata();

        return $routes;
    }

    private function get_term_routes() {
        $routes = [];
        $query = new WP_Term_Query([
            'taxonomy' => ['category', 'post_tag']
        ]);

        foreach ($query->get_terms() as $term) {
            $routes[] = [
                'id'       => $term->term_id,
                'type'     => $term->taxonomy,
                'path'     => \Kiku\Util::base_path(get_term_link($term)),
                'title'    => $term->name,
                'slug'     => $term->slug,
                'template' => '',
            ];
        }

        return $routes;
    }
}

$fv = new FrontVariables();
add_action('wp_head', [$fv, 'output_variables']);
