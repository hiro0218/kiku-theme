<?php

class Article {
    public function render() {
        global $post, $Image;

        $args = [
            "@context" => "http://schema.org",
            "@type"    => "Article",
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id"   => get_the_permalink()
            ],
            "headline"      => mb_substr(esc_html(get_the_title()), 0, 110),
            "datePublished" => get_the_time(DATE_ISO8601),
            "dateModified"  => get_the_modified_time(DATE_ISO8601),
            "author" => [
                "@type" => "Person",
                "name"  => get_the_author()
            ],
            "description" => \Kiku\Util::get_excerpt_content()
        ];

        $image_src = $Image->get_entry_image(false, $post->ID, 'large');
        if (!empty($image_src)) {
            $size = $Image->get_image_size($image_src);
            $width = 0;
            $height = 0;

            if (!empty($size)) {
                $width  = $size['width'];
                $height = $size['height'];
            }

            $images_args = [
                "image" => [
                    "@type"  => "ImageObject",
                    "url"    => $image_src,
                    "width"  => $size['width'],
                    "height" => $size['height']
                ]
            ];
            $args = array_merge($args, $images_args);
        }

        $site_icon = esc_url(get_site_icon_url(512));
        if (!empty($site_icon)) {
            $publisher_args = [
                "publisher" => [
                    "@type" => "Organization",
                    "name"  => BLOG_NAME,
                    "logo"  => [
                        "@type"  => "ImageObject",
                        "url"    => $site_icon,
                        "width"  => 512,
                        "height" => 512
                    ]
                ]
            ];

            $args = array_merge($args, $publisher_args);
        }

        return $args;
    }


}
