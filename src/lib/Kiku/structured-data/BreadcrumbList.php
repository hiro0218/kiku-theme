<?php

class BreadcrumbList {
    public function render() {
        $args = [];
        $categories = get_the_category();

        if ($categories) {
            $item_list = [];
            $position = 1;

            // home
            $item_list[] = [
                "@type"    => "ListItem",
                "position" => $position,
                "item"     => [
                    "@id"  => BLOG_URL,
                    "name" => BLOG_NAME
                ]
            ];
            $position++;

            // category
            $categories = array_reverse($categories);
            foreach($categories as $category) {
                $item_list[] = [
                    "@type"    => "ListItem",
                    "position" => $position,
                    "item"     => [
                        "@id"  => get_category_link($category->cat_ID),
                        "name" => esc_html($category->cat_name)
                    ]
                ];
                $position++;
            }

            // active
            $item_list[] = [
                "@type"    => "ListItem",
                "position" => $position,
                "item"     => [
                    "@id"  => get_the_permalink(),
                    "name" => the_title_attribute('echo=0')
                ]
            ];

            $args = [
                "@context"        => "http://schema.org",
                "@type"           => "BreadcrumbList",
                "itemListElement" => $item_list
            ];
        }

        return $args;
    }
}
