<?php
namespace Kiku\Modules;

/**
* Don't Update "modified time"
* http://ja.forums.wordpress.org/topic/57495
*/
// Add a custom meta box on page edit screen
add_action( 'admin_menu', function() {
    add_meta_box(
        'update_level',
        __('update level', 'kiku'),
        __NAMESPACE__ . '\\add_html_update_level_custombox',
        'post',
        'side',
        'high'
    );
});

// Form HTML source of to be displayed on the post screen
function add_html_update_level_custombox() {
    $update_level = get_post_meta( filter_input(INPUT_GET, 'post'), 'update_level', true );

    // check "checked"
    $normal_checked = "";
    $modify_checked = "";
    if (empty($update_level)) {
        $normal_checked = ' checked="checked"';
    } else {
        if ( $update_level == "" || $update_level == "high" ){
            $normal_checked = ' checked="checked"';
        }
        else if ( $update_level == "low" ) {
            $modify_checked = ' checked="checked"';
        }
    }

    echo '<div class="submitbox">';
    echo '<ul>';
    echo '<li><label>';
    echo '<input name="update_level" type="radio" value="high" ';
    echo $normal_checked;
    echo ' />'. __('Normal update', 'kiku');
    echo '</label></li>';
    echo '<li><label>';
    echo '<input name="update_level" type="radio" value="low" ';
    echo $modify_checked;
    echo '/>'. __('Modify only', 'kiku');
    echo '</label></li>';
    echo '</ul>';
    echo '</div>';
}

// Write the value of the custom field in the database
function save_custom_field_postdata( $post_id ) {
    $update_level = filter_input(INPUT_POST, 'update_level');
    if ( "" == get_post_meta( $post_id, 'update_level' )) {
        add_post_meta( $post_id, 'update_level', $update_level, true ) ;
    } else if ( $update_level != get_post_meta( $post_id, 'update_level' )) {
        update_post_meta( $post_id, 'update_level', $update_level ) ;
    } else if ( "" == $update_level ) {
        delete_post_meta( $post_id, 'update_level' ) ;
    }
}
add_action( 'save_post', __NAMESPACE__ . '\\save_custom_field_postdata' );

// Except "update" not change the update date time
function insert_post_data( $data, $postarr ) {
    $update_level = filter_input(INPUT_POST, 'update_level');
    if ( $update_level == "low" ) {
        unset( $data["post_modified"] );
        unset( $data["post_modified_gmt"] );
    }
    return $data;
}
add_filter( 'wp_insert_post_data', __NAMESPACE__ . '\\insert_post_data', 10, 2 );
