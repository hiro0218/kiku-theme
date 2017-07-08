<?php
add_action('rest_api_init', function() {
    // related posts
    register_rest_field('post', 'related', [
        'get_callback' => function($object, $field_name, $request) {
            global $Entry;
            return $Entry->get_similar_posts(RELATED_POST_NUM, $object['id']);
        },
        'update_callback' => null,
        'schema' => null,
    ]);

    // next/prev posts
    register_rest_field('post', 'pager', [
        'get_callback' => function($object, $field_name, $request) {
            global $Entry;
            return $Entry->pager($object['id']);
        },
        'update_callback' => null,
        'schema' => null,
    ]);

});
