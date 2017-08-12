<?php
add_action('rest_api_init', function() {
    register_rest_route('kiku/v1', '/post/(?P<id>\d+)', [
        'methods' => 'GET',
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

            // amazon product data
            $post = get_post($post_id);
            $product_data = json_decode(get_post_meta($post->ID, CF_AMAZON_PRODUCT_TAG, true));

            // set
            $array = [
                'related' => $related,
                'pager' => $pager,
                'amazon_product' => $product_data,
            ];

            return $array;
        },
    ]);

    // post thumbnail
    register_rest_field('post', 'thumbnail', [
        'get_callback' => function($object, $field_name, $request, $type) {
            global $Image;
            $url = $Image->get_entry_image(true, $object['id']);
            return empty($url) ? null : $url;
        },
        'update_callback' => null,
        'schema' => null,
    ]);
});

// To decimate API information.
add_filter('rest_prepare_post', function ( $response, $post, $request ) {
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
}, 10, 3 );

// Global javaScript variables
add_action('wp_head', function () {
    $paged = get_query_var('paged');
    $page_type = get_post_type();
    if ($page_type) {
        $page_type .= 's';
    }
    $vars = [
        'per_page' => (int)get_option('posts_per_page'),
        'paged' => (int)($paged) ? $paged : 1,
        'page_type' => $page_type,
        'page_id' => get_the_ID(),
        'archive' => get_archive_date(),
        'category' => get_query_var('cat'),  // cat id
        'categories_exclude' => get_option('kiku_exclude_category_frontpage') ? get_option('kiku_exclude_category_frontpage') : 0,
        'search' => get_query_var('s'),
        'tag' => get_query_var('tag_id'),
    ];
    $vars = json_encode($vars, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

    echo '<script>';
    echo 'var WP = '. $vars;
    echo '</script>'. PHP_EOL;
});

function get_archive_date() {
    $archive = [];
    $year = get_query_var('year');
    $month = get_query_var('monthnum');
    $day = get_query_var('day');

    if (empty($month) && empty($day)) {
        // yearly: Returns 1/1 to 12/31 of the current year
        $archive = [
            'after'  => date('Y-m-d\TH:i:s', mktime(0, 0, 0, 1, 1, $year)),
            'before' => date('Y-m-d\TH:i:s', mktime(23, 59, 59, 12, 31, $year)),
        ];
    } else {
        // monthly: Return frist day / last day of the current month
        // daily: Return 0: 00 ~ 23: 59 of the day
        $date = $year . (($month) ? '-' . $month : '') . (($day) ? '-' . $day : '');
        $archive = [
            'after'  => date('Y-m-d\TH:i:s', strtotime('first day of 00:00:00'. $date)),
            'before' => date('Y-m-d\TH:i:s', strtotime('last day of 23:59:59'. $date)),
        ];
    }

    return $archive;
}
