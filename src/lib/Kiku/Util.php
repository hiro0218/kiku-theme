<?php
namespace Kiku;

class Util {

    public static function output_prefix() {
        $ogp_prefix = '';
        $opg_template = "og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# %s: http://ogp.me/ns/%s#";

        if (is_singular()) {
          $ogp_prefix = sprintf($opg_template, 'article', 'article');
        } else {
          $ogp_prefix = sprintf($opg_template, 'website', 'website');
        }

        return $ogp_prefix;
    }

    // コピーライト用の年号(開始-現在)を取得する
    public static function get_copyright_year(): string {
        $result = wp_cache_get('copyright_dates');

        if ($result === false) {
            global $Entry;
            $latest_date = $Entry->get_post_date('numberposts=1&post_status=publish&post_type=post');
            $frist_date = $Entry->get_post_date('numberposts=1&order=ASC&post_status=publish&post_type=post');
            if ($latest_date && $frist_date) {
                $result = date("Y", strtotime($frist_date)) .' - '. date("Y", strtotime($latest_date));
                wp_cache_set('copyright_dates', $result, '', 2592000);
            }
        }

        return $result;
    }


    /**
     * 記事関連
     */

    // 記事内容の抜粋
    public static function get_excerpt_content(): string {
        $content = "";
        $post_id = get_queried_object_id();

        if (has_excerpt($post_id)) {
            // This post has excerpt
            $content = get_the_excerpt();
        } else {
            // This post has no excerpt
            $post = get_post($post_id);
            $content = $post->post_content;
        }

        // 何も取得できない
        if (empty($content)) {
            return NOTHING_CONTENT;
        }

        // タグを省いて取得
        $content = self::remove_tags($content);

        // 整形
        return mb_substr($content, 0, EXCERPT_LENGTH) . EXCERPT_HELLIP;
    }

    private static function remove_tags(string $str): string {
        if (empty($str)) {
            return '';
        }

        $str = wp_strip_all_tags($str);
        $str = strip_shortcodes($str);
        $str = self::remove_white_space($str, "");

        return $str;
    }

    // スペースを除く
    public static function remove_white_space(string $tag, $last_line_break = PHP_EOL): string {
        $tag = preg_replace( '/(?:\n|\r|\r\n)/', '', $tag );
        return preg_replace( '/>(\s|\n|\r)+</', '><', $tag ). $last_line_break;
    }

    // "//example.com" -> "http://example.com"
    public static function add_scheme_relative_url($url, $scheme = "http"): string {
        if ( preg_match("/^\/\//", $url) === 1 ) {
            return $scheme. ':' .$url;
        }
        return $url;
    }

    /**
     * URL
     */

    public static function is_url($str): bool {
        return (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $str));
    }

    // 相対URIを絶対URIへ変換する
    public static function relative_to_absolute_url($url): string {
        if ( self::is_relative_url( $url ) ) {
            return self::base_url( $url );
        }

        return $url;
    }

    public static function is_absolute_url($url): bool {
        return (preg_match("/^((https?:)?\/\/|data:)/", $url) === 1);
    }

    public static function is_root_relative_url($url): bool {
        return (!self::is_absolute_url($url) && preg_match("/^\//", $url) === 1);
    }

    public static function is_relative_url($url): bool {
        return !(self::is_absolute_url($url) || self::is_root_relative_url($url));
    }

    // ベースURLを設定(絶対URL)
    public static function base_url( $path = null ): string {
        $parts = parse_url(BLOG_URL);
        $base_url = trailingslashit($parts['scheme'] . '://' . $parts['host']. $parts['path']);

        if ( !is_null($path) ) {
            $base_url .= ltrim($path, '/' );
        }

        return $base_url;
    }




    /**
     * Checker
     */

    public static function is_image($path): bool {
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

    public static function is_shortcode($str): bool {
        return (boolean)(substr($str, 0, 1) === '[') && (substr($str, strlen($str)-1, 1) === ']');
    }

    public static function is_dataURI($str): bool {
        return (boolean)(substr($str, 0, 5) === 'data:');
    }

}
