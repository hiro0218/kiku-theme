<?php

class SearchAction {
    public function render() {
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
