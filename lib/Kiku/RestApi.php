<?php

class REST_API {
    const API_NAMESPACE = "kiku/v1";
    const CACHE_EXPIRATION = MINUTE_IN_SECONDS * 15;

    // public function __construct() {}

    public function delete_all_transients($new_status, $old_status, $post) {
        if ($old_status !== $new_status) {
            global $wpdb;
            $wpdb->query("DELETE FROM `wp_options` WHERE (`option_name` LIKE '_transient_". CACHE_PREFIX ."_%') OR (`option_name` LIKE '_transient_timeout_". CACHE_PREFIX ."_%')");
        }
    }

    public function pre_dispatch($result, $server, $request) {
        // cache-control ヘッダーをセット
        $headers['Cache-Control'] = 'public, max-age=' . self::CACHE_EXPIRATION;
        $server->send_headers($headers);
    }

    public function disable_api_endpoint($endpoints) {
        unset($endpoints['/wp/v2/users']);
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
        unset($endpoints['/wp/v2/comments']);
        unset($endpoints['/wp/v2/comments/(?P<id>[\d]+)']);
        unset($endpoints['/wp/v2/settings']);

        return $endpoints;
    }

    public function adjusted_api_data($response, $post, $request) {
        // permalink to basename
        $response->data['link'] = '/' . basename($response->data['link']);

        // To decimate API information.
        unset($response->data['date_gmt']);
        unset($response->data['modified_gmt']);
        unset($response->data['guid']);
        unset($response->data['type']);
        unset($response->data['author']);
        unset($response->data['slug']);
        unset($response->data['status']);
        unset($response->data['meta']);
        unset($response->data['categories']);
        unset($response->data['tags']);
        unset($response->data['featured_media']);
        unset($response->data['comment_status']);
        unset($response->data['ping_status']);
        unset($response->data['sticky']);
        unset($response->data['template']);
        unset($response->data['format']);

        return $response;
    }

    public function rest_api_init() {
        $this->original_api();
        $this->rewrite_api();
    }

    public function original_api() {
        register_rest_route(self::API_NAMESPACE, '/advertise', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => function($data) {
                return [
                    'ads1' => [
                        'display' => get_option('kiku_ads1_post_types', []),
                        'content' => get_option('kiku_ads1_content', ""),
                        'script' => get_option('kiku_ads1_script', ""),
                    ],
                    'ads2' => [
                        'display' => get_option('kiku_ads2_post_types', []),
                        'content' => get_option('kiku_ads2_content', ""),
                        'script' => get_option('kiku_ads2_script', ""),
                    ],
                    'ads3' => [
                        'content' => get_option('kiku_ads3_content', ""),
                        'script' => get_option('kiku_ads3_script', ""),
                    ],
                ];
            }
        ]);

        register_rest_route(self::API_NAMESPACE, '/archive', [
            'methods'  => WP_REST_Server::READABLE,
            'callback' => function($data) {
                $request_url = $_SERVER['REQUEST_URI'];

                // transient で一時的にキャッシュしたデータをロード
                $key = CACHE_PREFIX . md5($request_url);
                $result = get_transient($key);

                if ($result === false) {
                    $DB = new \Kiku\DB();
                    $list = $DB->get_archive_list();
                    $archives = [];

                    foreach ($list as $entry) {
                        $archives[$entry['post_year']][] = [
                            'id'    => $entry['ID'],
                            'date'  => $entry['post_date'],
                            'title' => $entry['post_title'],
                            'link'  => \Kiku\Util::base_path(get_permalink($entry['ID'])),
                        ];
                    }

                    unset($DB, $list);
                    set_transient($key, $archives, self::CACHE_EXPIRATION);

                    return $archives;
                }

                return $result;
            }
        ]);

    }

    public function get_widget() {
        $widget = null;

        if (is_active_sidebar(PRIMARY_SIDEBAR_NAME)) {
            ob_start();
            dynamic_sidebar(PRIMARY_SIDEBAR_NAME);
            $widget = ob_get_contents();
            ob_end_clean();
        }

        return $widget;
    }

    public function rewrite_api() {
        // amazon product data
        register_rest_field('post', 'amazon_product', [
            'get_callback' => [$this, 'get_amazon_product'],
            'update_callback' => null,
            'schema' => null,
        ]);

        // post thumbnail
        register_rest_field('post', 'thumbnail', [
            'get_callback' => [$this, 'get_post_thumbnail'],
            'update_callback' => null,
            'schema' => null,
        ]);

        // post attach
        register_rest_field('post', 'attach', [
            'get_callback' => [$this, 'get_post_attach'],
            'update_callback' => null,
            'schema' => null,
        ]);

        register_rest_field('page', 'attach', [
            'get_callback' => [$this, 'get_post_attach'],
            'update_callback' => null,
            'schema' => null,
        ]);
    }

    public function get_amazon_product($object, $field_name, $request, $type) {
        global $post;
        $post = get_post($object['id']);
        $product_data = json_decode(get_post_meta($post->ID, CF_AMAZON_PRODUCT_TAG, true));

        return $product_data;
    }

    public function get_post_thumbnail($object, $field_name, $request, $type) {
        global $Image;
        $url = $Image->get_entry_image($object['id'], true, 'thumbnail');

        return empty($url) ? null : $url;
    }

    public function get_post_attach($object, $field_name, $request, $type) {
        global $Entry, $post;

        $post_id = $object['id'];
        $array = [];

        // related posts
        $related = $Entry->get_similar_posts(RELATED_POST_NUM, $post_id);
        // pager
        $pager = $Entry->pager($post_id);

        // set
        $array = [
            'related' => $related,
            'pager' => $pager,
            'custom' => [
                'script' => get_post_meta($post_id, '_custom_js', true),
                'style'  => get_post_meta($post_id, '_custom_css', true),
            ],
        ];

        return $array;
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

add_filter('rest_endpoints', [$REST_API, 'disable_api_endpoint'], 10, 3);
add_filter('rest_prepare_post', [$REST_API, 'adjusted_api_data'], 10, 3);
add_filter('rest_prepare_page', [$REST_API, 'adjusted_api_data'], 10, 3);
add_filter('rest_pre_dispatch', [$REST_API, 'pre_dispatch'], 0, 3);
add_action('rest_api_init', [$REST_API, 'rest_api_init']);
add_action('transition_post_status', [$REST_API, 'delete_all_transients'], 10, 3);
