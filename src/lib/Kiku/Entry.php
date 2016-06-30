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
