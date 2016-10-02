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

function add_amazon_associate($content) {
    if ( !is_singular() ) {
        return $content;
    }

    global $post, $Amazon;
    $asin = get_post_meta($post->ID, CF_ASIN, true);
    if (empty($asin) || empty($Amazon)) {
        return $content;
    }

    $result = $Amazon->lookupASIN(strtoupper($asin));
    if ( !empty($result) ) {
        $content .= _make_amazon_product_tag($result);
    }

    return $content;
}
add_filter('the_content', __NAMESPACE__ . '\\add_amazon_associate', 50);

function _make_amazon_product_tag($info) {
    $tag = '';

    $title = (string)$info->ItemAttributes->Title;
    $url = (string)$info->DetailPageURL;
    $author = (string)$info->ItemAttributes->Author;
    $date = (string)$info->ItemAttributes->PublicationDate;
    $img = replace_amazon_image_scheme( (string)$info->LargeImage->URL );

    $tag .= "<a href='". $url ."' class='amazon-product' target='_blank'>";
    $tag .= "<div class='mdl-grid'>";
    $tag .= "<div class='mdl-cell mdl-cell--3-col mdl-cell--12-col-phone mdl-cell--order-2-tablet'>";
    $tag .= "<img src='". $img ."' data-zoom-diasbled='true'>";
    $tag .= "</div>";
    $tag .= "<div class='mdl-cell mdl-cell--9-col mdl-cell--hide-phone mdl-cell--order-1-tablet'>";
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
