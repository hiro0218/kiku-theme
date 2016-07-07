<?php
namespace Kiku;

class Image {

    public function get_entry_image() {
        global $post;
        $image_src = '';

        // denied post
        if ( post_password_required() ) {
            return null;
        }

        // has thumbnail
        if ( has_post_thumbnail() ) {
            $image_src = $this->get_post_thumbnail_image();
            if ( !empty($image_src) ) {
                return $image_src;
            }
        }

        // has img tag
        $image_src = $this->get_post_image_from_tag();

        return $image_src;
    }

    public function get_post_thumbnail_image($size = null) {
        global $post;
        $url = "";

        if ( !has_post_thumbnail() ) {
            return null;
        }

        $thumbnail_id = get_post_thumbnail_id();

        if ($size == null) {
            // wp_get_attachment_image_src -> thumbnail, medium, large, full
            // try large size
            list($url, $width, $height) = wp_get_attachment_image_src($thumbnail_id, 'large');

            // retry medium
            if ( empty($url) ) {
                list($url, $width, $height) = wp_get_attachment_image_src($thumbnail_id, 'medium');
            }

        } else {
            list($url, $width, $height) = wp_get_attachment_image_src($thumbnail_id, $size);
        }

        return $url;
    }

    public function get_post_image_from_tag() {
        global $post;
        $src = "";

        //
        if ( preg_match('/<img.*?src=(["\'])(.+?)\1.*?>/i', $post->post_content, $match) ) {
            $src = $match[2];
        }
        
        return $src;
    }

}
