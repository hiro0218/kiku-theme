<?php
namespace Kiku\Modules;

// 省略文字数
function new_excerpt_length($length) {
    return EXCERPT_LENGTH;
}
add_filter('excerpt_length',   __NAMESPACE__ . '\\new_excerpt_length');
add_filter('excerpt_mblength', __NAMESPACE__ . '\\new_excerpt_length');

// 省略記号
function new_excerpt_more() {
    return EXCERPT_HELLIP;
}
add_filter('excerpt_more', __NAMESPACE__ . '\\new_excerpt_more');
add_filter('the_excerpt', ["Kiku\Util",'get_excerpt_content']);

// Sort Post query
function sort_query($query) {
    // influence: admin page's post list
    if ( $query->is_main_query()  ) {
        $query->set('orderby', 'modified');
        $query->set('order', 'desc');
    }

    return $query;
}
add_action( 'pre_get_posts',  __NAMESPACE__ . '\\sort_query' );

// remove page from search result
function remove_page_from_search_result($query) {
    if ( $query->is_search() ) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\\remove_page_from_search_result' );

// Bug? (Wordpress 4.3)
// DataURI form CustomField is destroyed.
function repair_destroyed_datauri($content) {
    if ( !is_singular() ) {
        return $content;
    }

    $content = replace_relative_to_absolute_img_src($content);

    return str_replace( ' src="image/', ' src="data:image/', $content );
}
add_filter('the_content', __NAMESPACE__ . '\\repair_destroyed_datauri', 11);

function replace_relative_to_absolute_img_src($content) {
    preg_match_all('/<img.*?src=(["\'])(.+?)\1.*?>/i', $content, $matches);
    foreach ($matches[2] as $src_url) {
        // to Absolute URL
        if ( \Kiku\Util::is_image($src_url) ) {
            $src_absolute_url = \Kiku\Util::relative_to_absolute_url($src_url);
            $content = str_replace( 'src="'. $src_url, 'src="'. $src_absolute_url, $content );
        }
    }

    return $content;
}

// make Amazon Product Tag when save post
function save_amazon_associate_tag( $post_id ) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }

    global $Amazon;
    $asin = get_post_meta($post_id, CF_ASIN, true);
    if (empty($asin) || empty($Amazon)) {
        return;
    }
    $result = $Amazon->lookupASIN(strtoupper($asin));
    if ( !empty($result) ) {
        $tag = make_amazon_product_tag($result);
        update_post_meta($post_id, CF_AMAZON_PRODUCT_TAG, $tag);
    }
}
add_action('save_post', __NAMESPACE__ . '\\save_amazon_associate_tag', 11, 2);

// add Amazon Product Tag in content footer
function add_content_footer_amazon_associate($content) {
    if ( !is_singular() ) {
        return $content;
    }

    global $post;
    $tag = get_post_meta($post->ID, CF_AMAZON_PRODUCT_TAG, true);
    if ( !empty($tag) ) {
        $content .= $tag;
    }

    return $content;
}
add_filter('the_content', __NAMESPACE__ . '\\add_content_footer_amazon_associate', 50);

// make Amazon Product Tag
function make_amazon_product_tag($info) {
    $tag = '';

    $title = (string)$info->ItemAttributes->Title;
    $url = (string)$info->DetailPageURL;
    $author = (string)$info->ItemAttributes->Author;
    $date = (string)$info->ItemAttributes->PublicationDate;
    $img = replace_amazon_image_scheme( (string)$info->LargeImage->URL );

    $tag .= "<a href='". $url ."' class='amazon-product' target='_blank'>";
    $tag .= "<div class='columns is-gapless'>";
    $tag .= "<div class='column'>";
    $tag .= "<img src='". $img ."' data-zoom-diasbled='true'>";
    $tag .= "</div>";
    $tag .= "<div class='column'>";
    $tag .= "<span class='amazon-title'>". $title ."</span>";
    $tag .= "<span class='amazon-author'>". $author ."</span>";
    $tag .= "<span class='amazon-date'>". $date ."</span>";
    $tag .= "</div>";
    $tag .= "</div>";
    $tag .= "</a>";

    return $tag;
}

function replace_amazon_image_scheme($image_url) {
    return str_replace('http://ecx.', 'https://images-na.ssl-', $image_url);
}

// delete CF_AMAZON_PRODUCT_TAG when delete CF_ASIN
function deleted_asin_meta( $meta_id, $post_id, $meta_key, $meta_value ) {
    if ( CF_ASIN == $meta_key ) {
        delete_post_meta( $post_id, CF_AMAZON_PRODUCT_TAG );
    }
}
add_action( 'deleted_post_meta', __NAMESPACE__ . '\\deleted_asin_meta', 10, 4 );
