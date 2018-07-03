<?php

class FrontVariables {
    public function __construct() {
    }

    // Global javaScript variables
    public function output_variables() {
        $vars = [
            'site' => [
                'name' => BLOG_NAME,
                'url' => BLOG_URL,
                'copyright' => Kiku\Util::get_copyright_year(),
                'primary_navigation' => $this->get_primary_navigation(),
            ],
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
        return (int)get_option('posts_per_page');
    }

    private function get_categories_exclude() {
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

                $routes[$post_type][] = [
                    'path' => '/' . basename(get_permalink()),
                    'meta' => [
                        'id' => $post_id,
                    ],
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
            $routes[$term->taxonomy][] = [
                'path' => \Kiku\Util::base_path(get_term_link($term)),
                'meta' => [
                    'id'    => $term->term_id,
                    'title' => $term->name,
                ],
            ];
        }

        return $routes;
    }

    public function get_primary_navigation() {
        if (!has_nav_menu(PRIMARY_NAVIGATION_NAME)) {
            return null;
        }

        // transient で一時的にキャッシュしたデータをロード
        $key = CACHE_PREFIX . md5(PRIMARY_NAVIGATION_NAME);
        $result = get_transient($key);

        if ($result === false) {
            $menu_ids = get_nav_menu_locations();
            $menus = wp_get_nav_menu_items($menu_ids[PRIMARY_NAVIGATION_NAME]);
            $array = [];

            foreach ((array)$menus as $menu) {
                $menu_array = (array) $menu;
                $array[] = [
                    'ID' => $menu_array['ID'],
                    'title' => $menu_array['title'],
                    'url' => $menu_array['url'],
                ];
            }

            set_transient($key, $array, HOUR_IN_SECONDS);
            return $array;
        }

        return $result;
    }
}

$fv = new FrontVariables();
add_action('wp_footer', [$fv, 'output_variables']);
