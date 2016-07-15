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


/**
 * shortcode to view the contents of customfield.
 */
function add_shortcode_CustomFieldView($atts){
    extract( shortcode_atts([
        'id'   => get_the_ID(),
        'name' => false,
        'ss'   => 0,
    ], $atts) );

    // escape
    $id   = sprintf(esc_html("%s"), $id);
    $name = sprintf(esc_html("%s"), $name);
    $ss   = sprintf(esc_html("%s"), $ss);

    if ( !$name ) {
        return false;
    }

    $custom = get_post_meta($id, $name, true);

    // shortcode permitted in a custom field
    $custom = ($ss == 1) ? do_shortcode($custom) : $custom;

    return $custom;
}
add_shortcode('cfview', __NAMESPACE__ . '\\add_shortcode_CustomFieldView');


/**
 * shortcode to show Screenshot (WordPress API)
 */
function add_shortcode_wp_screenshot($attr) {
    extract( shortcode_atts([
        'url'   => '',
        'alt'   => '',
        'class' => '',
        'width' => 0,  // 0: not display width attr
        'link'  => 1   // 0: not link
    ], $attr) );

    if ($url == '') {
        return;
    }

    $image = '//s.wordpress.com/mshots/v1/' . urlencode(esc_url($url));
    $attr = '';
    if ($width > 0) {
        $height = floor($width / 4 * 3);
        $image .= '?w=' . $width;
        $attr = ' width="' . $width . '" height="' . $height . '"';
    }

    if ($class != '') {
        $attr .= ' class="' . $class . '"';
    }

    $image_tag = '<img src="' . $image . '" alt="' . $alt . '"' . $attr . '>';
    if ($link == 1) {
        $image_tag = '<a href="' . $url . '" target="_blank">' . $image_tag . '</a>';
    }

    return $image_tag;
}
add_shortcode('scshot', __NAMESPACE__ . '\\add_shortcode_wp_screenshot');


/**
 * insert custom data to the page
 */
function add_customCss_metabox() {
    global $post;
    echo '<input type="hidden" name="nonce_custom_css" value="'. wp_create_nonce('custom-css') .'" />';
    echo '<textarea name="custom_css" rows="5" cols="30" style="width:100%;">'. get_post_meta($post->ID, '_custom_css', true) .'</textarea>';
}

function add_customJs_metabox() {
    global $post;
    echo '<input type="hidden" name="nonce_custom_js" value="'. wp_create_nonce('custom-js') .'" />';
    echo '<textarea name="custom_js" rows="5" cols="30" style="width:100%;">'. get_post_meta($post->ID, '_custom_js', true) .'</textarea>';
}

function save_cusutom_data() {
    if ( !verify_cusutom_data() ) {
        return;
    }

    global $post;
    $custom_css = filter_input(INPUT_POST, 'custom_css');
    if ( isset($custom_css) ) {
        update_post_meta($post->ID, '_custom_css', $custom_css);
    }
    $custom_js  = filter_input(INPUT_POST, 'custom_js');
    if ( isset($custom_js) ) {
        update_post_meta($post->ID, '_custom_js', $custom_js);
    }
}

function verify_cusutom_data() {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return false;
    }

    $css_nonce = filter_input(INPUT_POST, 'nonce_custom_css');
    $js_nonce  = filter_input(INPUT_POST, 'nonce_custom_js');

    if ( !isset($css_nonce) || !isset($js_nonce) ) {
        return false;
    }

    if (!wp_verify_nonce($css_nonce, 'custom-css') || !wp_verify_nonce($js_nonce, 'custom-js')) {
        return false;
    }

    return true;
}

function insert_custom_data_in_singular() {
    if( !is_singular() ) {
        return;
    }

    while( have_posts() ){
        the_post();

        $object = get_post_meta(get_the_ID(), '_custom_css', true);
        if ( !empty($object) ) {
            echo '<style>'. $object .'</style>'. PHP_EOL;
        }

        $object = get_post_meta(get_the_ID(), '_custom_js', true);
        if ( !empty($object) ) {
            echo '<script>'. $object .'</script>'. PHP_EOL;
        }
    }
    rewind_posts();
}

add_action('admin_menu', function() {
    add_meta_box('custom_css', __('custom CSS', 'kiku'), __NAMESPACE__ . '\\add_customCss_metabox', 'post', 'normal', 'low');
    add_meta_box('custom_css', __('custom CSS', 'kiku'), __NAMESPACE__ . '\\add_customCss_metabox', 'page', 'normal', 'low');
    add_meta_box('custom_js',  __('custom JavaScript', 'kiku'), __NAMESPACE__ . '\\add_customJs_metabox', 'post', 'normal', 'low');
    add_meta_box('custom_js',  __('custom JavaScript', 'kiku'), __NAMESPACE__ . '\\add_customJs_metabox', 'page', 'normal', 'low');
});
add_action('save_post', __NAMESPACE__ . '\\save_cusutom_data');
add_action('wp_footer', __NAMESPACE__ . '\\insert_custom_data_in_singular', 100);
