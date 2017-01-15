<?php
namespace Kiku;

class Image {

    public function get_entry_image(bool $datauri = true, int $post_id = 0): string {
        global $post;
        $image_src = '';

        if ($post_id == 0) {
            $post_id = $post->ID;
        }

        // denied post
        if ( post_password_required() ) {
            return "";
        }

        // has thumbnail custom field
        $image_src = get_post_meta($post_id, CF_THUMBNAIL, true);
        if ( $this->is_correct_image($image_src) ) {
            return $image_src;
        }

        // has thumbnail
        if ( has_post_thumbnail() ) {
            $image_src = $this->get_post_thumbnail_image();
            if ( $this->is_correct_image($image_src) ) {
                return $image_src;
            }
        }

        // has img tag
        $image_src = $this->get_post_image_from_tag($datauri);

        return $image_src;
    }

    public function get_post_thumbnail_image($size = null): string {
        global $post;
        $url = "";
        $attachment_image_src = null;

        if ( !has_post_thumbnail() ) {
            return "";
        }

        $thumbnail_id = get_post_thumbnail_id();

        if ($size == null) {
            // wp_get_attachment_image_src -> thumbnail, medium, large, full
            // try large size
            $attachment_image_src = wp_get_attachment_image_src($thumbnail_id, 'large');

            // try full
            if ( empty($attachment_image_src) ) {
                $attachment_image_src = wp_get_attachment_image_src($thumbnail_id, 'full');
            }

            // retry medium
            if ( empty($attachment_image_src) ) {
                $attachment_image_src = wp_get_attachment_image_src($thumbnail_id, 'medium');
            }

        } else {
            $attachment_image_src = wp_get_attachment_image_src($thumbnail_id, $size);
        }

        if ($attachment_image_src) {
            $url = (string)$attachment_image_src[0];
        }

        return $url;
    }

    public function get_post_image_from_tag($datauri = true): string {
        global $post;
        $src = "";
        $content = "";

        // get from Amazon Product Tag
        $content = get_post_meta($post->ID, CF_AMAZON_PRODUCT_TAG, true);

        if ( empty($content) ) {
            $content = $post->post_content;
        }

        // maybe URL or Path, sortcode?
        if ( preg_match('/<img.*?src=(["\'])(.+?)\1.*?>/i', $content, $match) ) {
            $src = $match[2];
        }

        // bye
        if ( empty($src) ) {
            return "";
        }

        // image file?
        if ( Util::is_image($src) ) {
            return Util::relative_to_absolute_url($src);
        }

        // shortcode?
        if ( Util::is_shortcode($src) ) {
            $src = do_shortcode($src);

            if ( Util::is_url($src) && Util::is_image($src) ) {
                return Util::relative_to_absolute_url($src);
            }
            // denied DataURI
            if ( !$datauri ) {
                return "";
            }
            // not Data URI
            if ( !Util::is_dataURI($src) ) {
                return "";
            }
        }

        return $src;
    }

    private function is_correct_image(string $src): bool {
        return Util::is_url($src) && Util::is_image($src);
    }
}
