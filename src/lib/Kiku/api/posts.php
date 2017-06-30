<?php
add_action('rest_api_init', function() {
    // related posts
    register_rest_field('post', 'related', [
        'get_callback' => function($object, $field_name, $request) {
            global $Entry;
            $similars = $Entry->get_similar_posts(RELATED_POST_NUM, $object['id']);
            return $similars;
        },
        'update_callback' => null,
        'schema' => null,
    ]);
});
