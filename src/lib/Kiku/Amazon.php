<?php
namespace Kiku;

class Amazon {
    public static function get_amazon_product($post_id) {
        global $Aapapi;

        $asin = get_post_meta($post_id, CF_ASIN, true);

        if (empty($asin) || empty($Aapapi)) {
            return null;
        }

        $product_data = $Aapapi->lookupASIN(strtoupper($asin));

        return $product_data;
    }

    // make Amazon Product Tag when save post
    public function save_amazon_product_tag($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $product_data = self::get_amazon_product($post_id);

        if (!empty($product_data)) {
            $tag = self::make_amazon_product_tag($product_data);
            self::update_asin_meta($post_id, $tag);
        }
    }

    // add Amazon Product Tag in content footer
    public function append_amazon_product_tag($content) {
        global $post;

        if (!is_singular()) {
            return $content;
        }

        $tag = get_post_meta($post->ID, CF_AMAZON_PRODUCT_TAG, true);

        if (!empty($tag)) {
            $content .= $tag;
        }

        return $content;
    }

    // make Amazon Product Tag
    public static function make_amazon_product_tag($info) {
        $tag = '';

        $title = (string)$info->ItemAttributes->Title;
        $url = (string)$info->DetailPageURL;
        $author = (string)$info->ItemAttributes->Author;
        $date = (string)$info->ItemAttributes->PublicationDate;
        $img = self::replace_amazon_image_scheme( (string)$info->LargeImage->URL );

        $tag .= "<a href='". $url ."' class='amazon-product' target='_blank'>";
        $tag .= "<div class='columns'>";
        $tag .= "<div class='column'>";
        $tag .= "<img src='". $img ."' data-zoom-diasbled='true'>";
        $tag .= "</div>";
        $tag .= "<div class='column'>";
        $tag .= $title ?? "<span class='amazon-title'>". $title ."</span>";
        $tag .= $author ?? "<span class='amazon-author'>". $author ."</span>";
        $tag .= $date ?? "<span class='amazon-date'>". $date ."</span>";
        $tag .= "</div>";
        $tag .= "</div>";
        $tag .= "</a>";

        return $tag;
    }

    public static function replace_amazon_image_scheme($image_url) {
        return str_replace('http://ecx.', 'https://images-na.ssl-', $image_url);
    }

    public static function update_asin_meta($post_id, $value) {
        update_post_meta($post_id, CF_AMAZON_PRODUCT_TAG, $value);
    }

    // delete CF_AMAZON_PRODUCT_TAG when delete CF_ASIN
    public static function deleted_asin_meta($meta_id, $post_id, $meta_key, $meta_value) {
        if (CF_ASIN == $meta_key) {
            delete_post_meta($post_id, CF_AMAZON_PRODUCT_TAG);
        }
    }
}
