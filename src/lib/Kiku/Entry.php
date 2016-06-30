<?php
namespace Kiku;

class Entry {
    // 関連する記事の一覧を取得する
    public function get_similar_posts() {
        if ( !is_single() ) {
            return;
        }

        global $post;
        $arr = [];
        $post_id = $post->ID;
        $category_id = get_the_category($post_id);

        if( empty($category_id) ) {
            return;
        }

        $i = 0;
        $similar_query = new \wp_query([
            'post_status'          => 'publish',
            'category__in'         => $category_id[0]->term_id,
            'orderby'              => 'modified', //'rand',
            'order'                => 'DESC',
            'post__not_in'         => [$post_id],  // this post
            'posts_per_page'       => 5,  // show
            'ignore_sticky_posts'  => 1
        ]);

        while( $similar_query->have_posts() ) {
            $similar_query->the_post();
            $arr[$i] = [
                "uri"   => get_the_permalink(),
                "title" => $this->get_clean_title(),
            ];
            $i++;
        }

        wp_reset_query();
        unset($similar_query);

        return $arr;
    }

    // クリーンな投稿タイトルを取得する
    private function get_clean_title() {
        return the_title_attribute( 'echo=0' );
    }

    // 設定されたカテゴリの一覧を取得する
    public function get_category() {
        if ( !is_single() ) {
            return null;
        }

        $categories = get_the_category();
        $arr = [];
        $i = 0;

        foreach( $categories as $category ) {
            $arr[$i] = [
                "link"   => get_category_link( $category->cat_ID ),
                "name" => esc_html( $category->cat_name ),
            ];
            $i++;
        }

        return array_reverse($arr);
    }

    // 設定されたタグの一覧を取得する
    public function get_tag() {
        if ( !is_single() ) {
            return null;
        }

        $tags = get_the_tags();
        if ( empty($tags) ) {
            return null;
        }

        $arr = [];
        $i = 0;
        foreach( $tags as $tag ) {
            $arr[$i] = [
                "link"  => get_tag_link($tag->term_id),
                "name" => $tag->name,
            ];
            $i++;
        }

        return $arr;
    }

}
