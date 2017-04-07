<?php

class SearchAction {
    public function render() {
        if (!is_home() && !is_front_page()) {
            return;
        }

        $args = [
            "@context" => "http://schema.org",
            "@type"    => "WebSite",
            "name"     => BLOG_NAME,
            "url"      => BLOG_URL,
            "potentialAction" => [
                "@type"       => "SearchAction",
                "target"      => BLOG_URL ."?s={s}",
                "query-input" => [
                    "@type" => "PropertyValueSpecification",
                    "valueRequired" => true,
                    "valueName" => "s",
                    "valueMaxlength" => 100
                ]
            ]
        ];

        return $args;
    }
}
