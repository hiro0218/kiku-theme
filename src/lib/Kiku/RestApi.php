<?php

class REST_API {
    public function __construct() {
    }

    public function get_api_namespace() {
        return 'kiku/v1';
    }

    // To decimate API information.
    public function unset_api_data($response, $post, $request) {
        unset($response->data['date_gmt']);
        unset($response->data['modified_gmt']);
        unset($response->data['guid']);
        unset($response->data['type']);
        unset($response->data['author']);
        unset($response->data['slug']);
        unset($response->data['content']);
        unset($response->data['status']);
        unset($response->data['featured_media']);
        unset($response->data['comment_status']);
        unset($response->data['ping_status']);
        unset($response->data['sticky']);
        unset($response->data['template']);
        unset($response->data['format']);

        return $response;
    }

    // Global javaScript variables
    public function output_variables() {
        $vars = [
            'per_page' => $this->get_per_page(),
            'paged' => $this->get_paged(),
            'page_type' => $this->get_post_type(),
            'page_id' => $this->get_page_id(),
            'categories_exclude' => $this->get_categories_exclude(),
            'category' => $this->get_category_id(),
            'category_name' => $this->get_category_name(),
            'search' => $this->get_search_query(),
            'tag' => $this->get_tag_id(),
            'tag_name' => $this->get_tag_name(),
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

    private function get_paged() {
        if (is_singular()) {
            return null;
        }
        $paged = (int)get_query_var('paged');
        return $paged ? $paged : 1;
    }

    private function get_post_type() {
        if (!is_singular()) {
            return null;
        }
        $page_type = get_post_type();

        if ($page_type) {
            $page_type .= 's';
        }

        return $page_type;
    }

    private function get_page_id() {
        if (!is_singular()) {
            return null;
        }
        return get_the_ID();
    }

    private function get_categories_exclude() {
        if (!is_front_page()) {
            return null;
        }
        $exclude_category = (int)get_option('kiku_exclude_category_frontpage');
        return $exclude_category ? $exclude_category : 0;
    }

    private function get_category_id() {
        if (!is_category()) {
            return null;
        }
        return get_query_var('cat');
    }

    private function get_category_name() {
        if (!is_category()) {
            return null;
        }
        return get_query_var('category_name');
    }

    private function get_search_query() {
        if (!is_search()) {
            return null;
        }
        return get_query_var('s');
    }

    private function get_tag_id() {
        if (!is_tag()) {
            return null;
        }
        return get_query_var('tag_id');
    }

    private function get_tag_name() {
        if (!is_tag()) {
            return null;
        }
        return get_query_var('tag');
    }

    public function rest_api_init() {
        register_rest_route($this->get_api_namespace(), '/post/(?P<id>\d+)', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => function($data) {
                $post_id = $data['id'];
                if (empty($post_id)) {
                    return null;
                }

                global $Entry, $post;
                $array = [];

                // related posts
                $related = $Entry->get_similar_posts(RELATED_POST_NUM, $post_id);
                // pager
                $pager = $Entry->pager($post_id);

                // set
                $array = [
                    'related' => $related,
                    'pager' => $pager,
                ];

                return $array;
            },
        ]);

        // amazon product data
        register_rest_field('post', 'amazon_product', [
            'get_callback' => function($object, $field_name, $request, $type) {
                if (!$this->is_postId_route($request, $type)) {
                    return null;
                }
                global $post;
                $post = get_post($object['id']);
                $product_data = json_decode(get_post_meta($post->ID, CF_AMAZON_PRODUCT_TAG, true));
                return $product_data;
            },
            'update_callback' => null,
            'schema' => null,
        ]);

        // post category
        register_rest_field('post', 'categories', [
            'get_callback' => function($object, $field_name, $request, $type) {
                global $Entry;
                $object['categories'] = $Entry->get_category();
                return $object['categories'];
            },
            'update_callback' => null,
            'schema' => null,
        ]);

        // post tags
        register_rest_field('post', 'tags', [
            'get_callback' => function($object, $field_name, $request, $type) {
                global $Entry;
                $object['tags'] = $Entry->get_tag();
                return $object['tags'];
            },
            'update_callback' => null,
            'schema' => null,
        ]);

        // post thumbnail
        register_rest_field('post', 'thumbnail', [
            'get_callback' => function($object, $field_name, $request, $type) {
                global $Image;
                $url = $Image->get_entry_image($object['id'], false, 'thumbnail');
                return empty($url) ? null : $url;
            },
            'update_callback' => null,
            'schema' => null,
        ]);
    }

    private function is_postId_route($request, $type) {
        if ($type !== 'post') {
            return false;
        }

        $route = preg_split('/\//', $request->get_route());
        $post_id = (int)end($route);

        return ($post_id === 0) ? false : true;
    }
}

$REST_API = new REST_API();
add_filter('rest_prepare_post', [$REST_API, 'unset_api_data'], 10, 3);
add_filter('rest_prepare_page', [$REST_API, 'unset_api_data'], 10, 3);
add_action('wp_head', [$REST_API, 'output_variables']);
add_action('rest_api_init', [$REST_API, 'rest_api_init']);
