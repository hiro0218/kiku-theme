<?php
namespace Kiku;

class Util {

    public static $copyright_year;

    public static function get_copyright_year() {
        if (self::$copyright_year === null) {
            self::$copyright_year = self::_get_copyright_year();
        }

        return self::$copyright_year;
    }

    public static function _get_copyright_year() {
        global $wpdb;

        $sql = "SELECT YEAR(min(post_date_gmt)) AS firstdate,
                YEAR(max(post_date_gmt)) AS lastdate
                FROM $wpdb->posts
                WHERE
                 post_type = 'post' AND
                 post_status = 'publish'";
        $copyright_dates = $wpdb->get_results($sql);

        $output = '';
        if($copyright_dates) {
            $copyright = $copyright_dates[0]->firstdate;
            if( $copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate ) {
                $copyright .= '-' . $copyright_dates[0]->lastdate;
            }
            $output = $copyright;
        }

        return $output;
    }

    // 記事内容の抜粋
    public static function get_excerpt_content($length = EXCERPT_LENGTH, $hellip = EXCERPT_HELLIP) {
        global $post;

        if ( has_excerpt( $post->ID ) ) {
            // This post has excerpt
            $content = self::remove_tags( get_the_excerpt() );

        } else {
            // This post has no excerpt
            // タグを省いて取得
            $content = self::remove_tags( $post->post_content );
        }

        // 何も取得できない
        if ( empty($content) ) {
            return "👻";
        }

        // 整形
        return wp_trim_words($content, EXCERPT_LENGTH, EXCERPT_HELLIP);
    }

    private static function remove_tags($str) {
        $str = strip_tags($str);
        $str = strip_shortcodes($str);

        $str = self::remove_white_space($str, "");

        return $str;
    }

    // スペースを除く
    public static function remove_white_space($tag, $last_line_break = PHP_EOL) {
        $tag = preg_replace( '/>(\s|\n|\r)+</', '><', $tag );
        return trim( str_replace(["\r\n", "\r", "\n", "\t"], '', $tag) ) . $last_line_break;
    }
}
