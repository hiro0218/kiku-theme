<?php
namespace Kiku;

class Entry {
    private $meta = [];

    public function get_meta(): array {
        if ( !is_single() ) {
            return [];
        }

        if ( !empty($this->meta) ) {
            return $this->meta;
        }

        $this->meta = [
            'title'          => $this->get_clean_title(),
            'url'            => get_the_permalink(),
            'category'       => $this->get_clean_category(),
            'tag'            => $this->get_clean_tag(),
            'author'         => get_the_author(),
            'date_published' => get_the_date('c'),
            'date_modified'  => get_the_modified_date('c'),
        ];

        return $this->meta;
    }

    // 関連する記事の一覧を取得する
    public function get_similar_posts($post_count = 5, $post_id = null): array {
        $arr = [];
        $term_ids = [];

        if (empty($post_id)) {
            $post_id = get_queried_object_id();
        }
        $categories = get_the_category($post_id);

        if ( empty($categories) ) {
            return [];
        }

        foreach ( $categories as $category ) {
            if ( $category->parent == 0 ) {
                $term_ids[] = $category->term_id;
            } else {
                $term_ids[] = $category->parent;
                $term_ids[] = $category->term_id;
            }
        }

        $the_query = new \WP_Query([
            'post_status'          => 'publish',
            'post_type'            => 'post',
            'post__not_in'         => [$post_id],  // display post
            'orderby'              => 'modified', //'rand',
            'order'                => 'DESC',
            'posts_per_page'       => $post_count,  // show
            'ignore_sticky_posts'  => 1,
            'tax_query' => [
                [
                    'taxonomy' => 'category',
                    'terms' => array_unique( $term_ids ),
                    'include_children' => false,
                ],
            ],
        ]);

        if ( $the_query->have_posts() ) {
            $i = 0;
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $title = $this->get_clean_title();
                if ( empty($title) ) {
                    continue;
                }
                $arr[$i] = [
                    "uri"   => get_the_permalink(),
                    "title" => $title,
                    "description" => \Kiku\Util::get_excerpt_content(),
                ];
                $i++;
            }
            wp_reset_postdata();
        }

        return $arr;
    }

    // クリーンな投稿タイトルを取得する
    private function get_clean_title(): string {
        return (string)the_title_attribute( 'echo=0' );
    }

    private function get_clean_category(): string {
        return strip_tags( get_the_category_list( ',' ) );
    }

    private function get_clean_tag(): string {
        return strip_tags( get_the_tag_list( '', ",", '' ) );
    }

    // 設定されたカテゴリの一覧を取得する
    public function get_category(): array {
        $categories = get_the_category();
        $arr = [];
        $i = 0;

        foreach ( $categories as $category ) {
            $arr[$i] = [
                "link"   => get_category_link( $category->cat_ID ),
                "name" => esc_html( $category->cat_name ),
            ];
            $i++;
        }

        return $arr;
    }

    // 設定されたタグの一覧を取得する
    public function get_tag(): array {
        $tags = get_the_tags();
        if ( empty($tags) ) {
            return [];
        }

        $arr = [];
        $i = 0;
        foreach ( $tags as $tag ) {
            $arr[$i] = [
                "link"  => get_tag_link($tag->term_id),
                "name" => $tag->name,
            ];
            $i++;
        }

        return $arr;
    }

    public function pager($post_id = null) {
        global $post;
        $post = get_post($post_id);

        $pager = [];
        $prev_post = get_previous_post();
        $next_post = get_next_post();

        // previous post
        if (!empty($prev_post)) {
            $pager['prev'] = [
                'id' => $prev_post->ID,
                'url' => get_permalink($prev_post->ID),
                'title' => $prev_post->post_title,
            ];
        }

        // next post
        if (!empty($next_post)) {
            $pager['next'] = [
                'id' => $next_post->ID,
                'url' => get_permalink($next_post->ID),
                'title' => $next_post->post_title,
            ];
        }

        return $pager;
    }
}
