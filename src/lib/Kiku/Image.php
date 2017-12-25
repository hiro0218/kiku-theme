<?php
namespace Kiku;

class Image {

    public function get_entry_image(bool $datauri = true, int $post_id = null, $image_size = 'medium'): string {
        $image_src = "";

        // post_idをチェック
        $post_id = $this->get_post_id($post_id);
        if (empty($post_id)) {
            return "";
        }

        // denied post
        if (post_password_required($post_id)) return "";

        // has thumbnail custom field
        $image_src = $this->get_meta_thumbnail_image($post_id);
        if (!empty($image_src)) {
            return $image_src;
        }

        // has thumbnail
        $image_src = $this->get_post_thumbnail_image($post_id, $image_size);
        if (!empty($image_src)) {
            return $image_src;
        }

        // has ASIN custom field
        $image_src = $this->get_asin_image($post_id);
        if (!empty($image_src)) {
            return $image_src;
        }

        // has img tag
        $image_src = $this->get_post_image_from_tag($datauri, $post_id);

        return $image_src;
    }

    public function get_post_thumbnail_image($post_id, $image_size = 'medium'): string {
        $url = get_the_post_thumbnail_url($post_id, $image_size);

        return $this->is_correct_image($url) ? $url : "";
    }

    public function get_post_image_from_tag($datauri = true, $post_id): string {
        $src = "";
        $content = "";

        // get from Amazon Product Tag
        $content = get_post_meta($post_id, CF_AMAZON_PRODUCT_TAG, true);

        // get from post content
        if (empty($content)) {
            $post = get_post($post_id);
            $content = $post->post_content;
        }

        // maybe URL or Path, sortcode?
        if (preg_match('/<img.*?src=(["\'])(.+?)\1.*?>/i', $content, $match)) {
            $src = $match[2];
        }

        // bye
        if (empty($src)) {
            return "";
        }

        // image file?
        if (Util::is_image($src)) {
            return Util::relative_to_absolute_url($src);
        }

        // is theme shortcode
        if (Util::is_shortcode($src)) {
            $src = do_shortcode($src);

            if (Util::is_url($src)) {
                return Util::relative_to_absolute_url($src);
            }
            // denied DataURI
            if ($datauri) {
                // not Data URI
                if (!Util::is_dataURI($src)) {
                    return "";
                }
            }
        }

        return $src;
    }

    private function is_correct_image(string $src): bool {
        return Util::is_url($src) && Util::is_image($src);
    }

    public function get_meta_thumbnail_image($post_id) {
        $thumbnail_data = get_post_meta($post_id, CF_THUMBNAIL, true);

        return $this->is_correct_image($thumbnail_data) ? $thumbnail_data : "";
    }

    public function get_asin_image($post_id) {
        $url = '';
        $product_data = get_post_meta($post_id, CF_AMAZON_PRODUCT_TAG, true);
        $data = json_decode($product_data, true);

        // migration
        if (is_array($data["LargeImage"])) {
            $url = $data["LargeImage"]['URL'];
        } else if (is_string($data["LargeImage"])) {
            $url = $data["LargeImage"];
        }

        if (empty($url)) {
            return "";
        }

        if ( $this->is_correct_image($url) ) {
            return $url;
        }

        return "";
    }

    public function get_image_size($url) {
        $image = wp_get_image_editor( $url );

        if ( !is_wp_error( $image ) ) {
            return $image->get_size();
        }

        return null;
    }

    private function get_post_id($post_id) {
        if (empty($post_id)) {
            $post_id = get_queried_object_id();
        }
        return $post_id;
    }

}
