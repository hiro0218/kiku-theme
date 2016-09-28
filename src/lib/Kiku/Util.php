<?php
namespace Kiku;

class Util {

    // コピーライト用の年号(開始-現在)を取得する
    public static function get_copyright_year() {
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


    /**
     * 記事関連
     */

    // 記事内容の抜粋
    public static function get_excerpt_content() {
        global $post;
        $content = "";

        if ( has_excerpt( $post->ID ) ) {
            // This post has excerpt
            $content = get_the_excerpt();
        } else {
            // This post has no excerpt
            $content = $post->post_content;
        }

        // タグを省いて取得
        $content = self::remove_tags( $content );

        // 何も取得できない
        if ( empty($content) ) {
            return NOTHING_CONTENT;
        }

        // 整形
        return mb_substr($content, 0, EXCERPT_LENGTH) . EXCERPT_HELLIP;
    }

    private static function remove_tags($str) {
        $str = wp_strip_all_tags($str);
        $str = strip_shortcodes($str);
        $str = self::remove_white_space($str, "");

        return $str;
    }

    // スペースを除く
    public static function remove_white_space($tag, $last_line_break = PHP_EOL) {
        $tag = preg_replace( '/(?:\n|\r|\r\n)/', '', $tag );
        return preg_replace( '/>(\s|\n|\r)+</', '><', $tag ). $last_line_break;
    }


    /**
     *  日付関連
     */

    // 更新されているか
    public static function is_modified_post() {
        return (get_the_time('Ymd') <= get_the_modified_time('Ymd'));
    }

    // 更新時間差
    public static function get_posted_time_ago($timestamp) {
        if ($timestamp === null) {
            return '';
        }

        $current_time = CURRENT_TIMESTAMP ?: time();
        $difference = ($current_time - $timestamp);
        $periods = ['second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade'];
        $lengths = [60, 60, 24, 7, 4.35, 12, 10];

        for ($j = 0; isset($lengths[$j]) and $difference >= $lengths[$j] and ( empty($unit) or $unit != $periods[$j]); $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        // 1でなければ複数形にする
        if ($difference != 1) {
            $periods[$j] = $periods[$j] . 's';
        }

        // 0以下のとき
        if ($difference <= 0) {
            return "";
        }

        return $difference . ' ' . $periods[$j] . ' ago';
    }


    /**
     * URL
     */

    public static function is_url($str) {
        return (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $str));
    }

    // 相対URIを絶対URIへ変換する
    public static function relative_to_absolute_url($url) {
        if ( self::is_url_relative( $url ) ) {
            return self::base_url( $url );
        } else {
            return $url;
        }
    }

    // 相対URLか
    public static function is_url_relative( $url ) {
        return ( strpos($url, 'http') !== 0 && strpos($url, '//') !== 0 );
    }

    // ベースURLを設定(絶対URL)
    public static function base_url( $path = null ) {
        $parts = parse_url( get_option('home') );
        $base_url = trailingslashit( $parts['scheme'] . '://' . $parts['host']. $parts['path']);

        if ( !is_null($path) ) {
            $base_url .= ltrim($path, '/' );
        }

        return $base_url;
    }




    /**
     * Checker
     */

    public static function is_image($path) {
        $result = false;
        $path_info = pathinfo($path);

        if ( isset($path_info['extension']) ) {
            switch ($path_info['extension']) {
                case 'gif':
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'bmp':
                case 'tif':
                case 'tiff':
                    $result = true;
                    break;
                default:
                    $result = false;
                    break;
            }
        }

        return $result;
    }

    public static function is_shortcode($str) {
        return (boolean)(substr($str, 0, 1) === '[') && (substr($str, strlen($str)-1, 1) === ']');
    }

    public static function is_dataURI($str) {
      return (boolean)(substr($str, 0, 5) === 'data:');
    }

}
