<?php
namespace Kiku;

use AvpLab\PhpHtmlBuilder;

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
            $product_data = json_encode($product_data, JSON_UNESCAPED_UNICODE);
            self::update_asin_meta($post_id, $product_data);
        }
    }

    // add Amazon Product Tag in content footer
    public function append_amazon_product_tag($content) {
        global $post;

        if (!is_singular()) {
            return $content;
        }

        $product_data = get_post_meta($post->ID, CF_AMAZON_PRODUCT_TAG, true);

        if (!empty($product_data)) {
            $content .= self::make_amazon_product_tag($product_data);
        }

        return $content;
    }

    // make Amazon Product Tag
    public static function make_amazon_product_tag($product_data) {
        $data = json_decode($product_data, true);

        if (!is_array($data)) {
            return "";
        }

        $title = $data["ItemAttributes"]["Title"];
        $image_url = self::replace_amazon_image_scheme($data["LargeImage"]["URL"]);

        $builder = new PhpHtmlBuilder();

        $builder->div()->setClass('amazon-product')->setStyle('background-image: url("'.$image_url.'")')
                    ->a()->setHref($data["DetailPageURL"])->setClass('columns is-multiline is-vcentered')
                        ->div()->setClass('column is-12')
                            ->img()->setSrc($image_url)->setDataZoomDisabled('true')->end()
                        ->end()
                        ->div()->setClass('column is-12')
                            ->span($title)->setClass('amazon-title')->end()
                        ->end()
                    ->end()
                ->end();

        return $builder->build();
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
