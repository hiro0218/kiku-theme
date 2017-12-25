<?php

class BlogPosting {
    public function render() {
        global $post, $Image;

        $args = [
            "@context" => "http://schema.org",
            "@type"    => "BlogPosting",
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id"   => get_the_permalink()
            ],
            "headline"      => mb_substr(esc_html(get_the_title()), 0, 110),
            "datePublished" => get_the_time(DATE_ISO8601),
            "dateModified"  => get_the_modified_time(DATE_ISO8601),
            "author" => [
                "@type" => "Person",
                "name"  => esc_html(get_the_author_meta('display_name', $post->post_author))
            ],
            "description" => \Kiku\Util::get_excerpt_content()
        ];

        $image_src = '';
        if (is_singular()) {
            $image_src = $Image->get_entry_image($post->ID, false, 'large');
        }

        if (!empty($image_src)) {
            $size = null; // TODO: $Image->get_image_size($image_src);
            $width = 696;
            $height = 696;

            if (!empty($size)) {
                $width  = $size['width'];
                $height = $size['height'];
            }

            $images_args = [
                "image" => [
                    "@type"  => "ImageObject",
                    "url"    => $image_src,
                    "width"  => (int) $width,
                    "height" => (int) $height
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
                            "width"  => "512",
                            "height" => "512"
                            ]
                            ]
                        ];

                        $args = array_merge($args, $publisher_args);
                    }

                    return $args;
                }
            }
